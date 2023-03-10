<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\CsDetail;
use App\Models\Requisition;
use App\Models\User;
use App\Notifications\CsDetailNotification;
use App\Traits\MailMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class CsDetailService
{
    use MailMessage;
    protected $errorNotifier;
    protected $settingService;

    public $paginatedList = true;

    public function __construct()
    {
        $this->errorNotifier = new ErrorNotifierService();
        $this->settingService = new SettingService();
    }

    public function lists($data = null)
    {
//        dd($data);
        $search_query = [];

        $order = $this->settingService->get("data_order", "desc") ?? "desc";

        if (auth()->user()->type == 'admin' || auth()->user()->type == 'hq-admin' || auth()->user()->can('CS-list')) {
            $query = CsDetail::query()->with(['employee', 'costcenter','csDetailPurchaseOrder','csDetailRequisition']);
        } else {
            $cs_detail_ids = CsDetail::query()->where('created_by', auth()->id())->pluck('id')->unique()->toArray();
            $approval_ids = array();
            if (auth()->user()->employee) {
                $approval_ids = Approval::query()->where('approvalable_type', 'App\Models\CsDetail')
                    ->where('employee_id', auth()->user()->employee->id)
                    ->pluck('approvalable_id')->unique()->toArray();
            }
            $ids = (array_merge($cs_detail_ids, $approval_ids));
            $query = CsDetail::query()->with(['costcenter', 'employee','csDetailPurchaseOrder','csDetailRequisition'])->whereIn('id', array_unique($ids));
        }
        if (isset($data["search"])) {
            $search_query = [
                "search" => $data["search"]
            ];
            $query->where(function ($q) use ($data) {
                $q->orWhere("cs_number", "LIKE", "%" . $data["search"] . "%");
            });
        }
        if(isset($data["cost_center_id"])){
            $query->where('cost_center_id',$data["cost_center_id"]);
            $search_query = [
                "cost_center_id" => $data["cost_center_id"]
            ];
        }
        if(isset($data["status"])){
            $query->where('status',$data["status"]);
            $search_query = [
                "status" => $data["status"]
            ];
        }
        if(isset($data["requisition_code"])){
            $query->whereHas('csDetailRequisition', function ($q) use ($data) {
                $q->where('requisition_code', $data['requisition_code']);
            });
            $search_query = [
                "requisition_code" => $data["requisition_code"]
            ];
        }
        if(isset($data["requester_employee_id"])){
            $query->where('requester_employee_id',$data["requester_employee_id"]);
            $search_query = [
                "requester_employee_id" => $data["requester_employee_id"]
            ];
        }

        $query->orderBy('id', $order);

        if ($this->paginatedList === true) {

            $item_per_page = $this->settingService->get("item_per_page", 25) ?? 25;

            $cs_details = $query->paginate($item_per_page)->appends($search_query);
            $cs_details->pagination_summary = get_pagination_summary($cs_details);
        } else {
            $cs_details = $query->get();
        }

        return $cs_details;
    }

    public function updateOrCreate($data)
    {

        $user_id = auth()->user()->id;
        $employee_id = auth()->user()->employee->id;
        $requisition = Requisition::query()->select('description')->find($data['requisition_id']);


        if (!empty($data["id"])) {
            // update
            $cs_detail = CsDetail::whereId($data["id"])->first();
            $cs_detail->updated_by = $user_id;
            $cs_detail->status = 'pending';
        } else {
            //create
            $cs_detail = new CsDetail();

            $cs_detail->created_by = $user_id;
            $cs_detail->requester_employee_id = $employee_id;

            $cs_detail->cs_number = self::generateCsNumber();
        }

        if (isset($data['justification_for_procurement'])) {
            $cs_detail->justification_for_procurement = $data['justification_for_procurement'];
        }
        if (isset($data['requisition_id'])) {

        }

        if (isset($data['justification_for_vendor_selection'])) {
            $cs_detail->justification_for_vendor_selection = $data['justification_for_vendor_selection'];
        }

        if (isset($data['cost_center_id'])) {
            $cs_detail->cost_center_id = $data['cost_center_id'];
        }
        if (isset($data['budget_info'])) {
            $cs_detail->budget_info = $data['budget_info'];
        }
        if (isset($data['delivery_location'])) {
            $cs_detail->delivery_location = $data['delivery_location'];
        }
        if (isset($data['description'])) {
            $cs_detail->description = $data['description'];
        }else{
            $cs_detail->description = $requisition->description;
        }

        return $cs_detail->save() ? $cs_detail : null;
    }


    public function store($request)
    {


        $csDetail = self::updateOrCreate($request);
        if($request->requisitions){
            $csDetail->csDetailRequisition()->attach($request->requisitions);
        }else if($request->requisition_id){
            $requisition_id = array($request->requisition_id);
            $csDetail->csDetailRequisition()->attach($requisition_id);

        }
        if (array_key_exists('files', $request->all())) {
            self::uploadFiles($csDetail, $request);
        }
        self::createApproval($request, $csDetail);
        self::triggerNotification($request, $csDetail);
        if(isset($request['edit']) && $request['edit'] == 'true'){

            self::reSubmitApproval($csDetail,$request);
        }

        return $csDetail;
    }

    public function getTeamMembers($request)
    {
        return (new ApprovalTeamService())->getTeamMembers($request->type);
    }

    public function createApproval($request, $csDetail, $authority_order = 1, $status = 'pending')
    {

        $teamMembers = self::getTeamMembers($request);
        if (!is_null($teamMembers)) {
            foreach ($teamMembers as $employee_id) {
                $approval = new Approval();
                $approval->employee_id = $employee_id;
                $approval->authority_order = $authority_order;
                $approval->status = $status;
                $approval->approval_stage = $request->type;
                $csDetail->approval()->save($approval);
            }
        }
    }

    public function triggerNotification($request, $csDetail)
    {
        $teamMembers = self::getTeamMembers($request);
        $message = $this->csDetailMessage($csDetail);
        if (!is_null($teamMembers)) {
            foreach ($teamMembers as $employee_id) {

                self::sendNotification($employee_id, $message);
            }
        }
    }

    public function sendNotification($employee_id, $message)
    {
        $user = self::getUser($employee_id);
        \Log::info($user);

        Notification::send($user, new CsDetailNotification($message));
    }
    public function getUser($employee_id)
    {
        return User::select(["users.id", "users.email"])
            ->join("employees as e", "e.user_id", "users.id")
            ->where("e.id", $employee_id)
            ->whereNotNull("e.user_id")
            ->first();
    }

    public function uploadFiles($cs_detail, $request)
    {
        foreach ($request->files as $file) {
            foreach ($file as $singlefile) {
                $cs_detail->addMedia($singlefile)
                    ->preservingOriginal()
                    ->toMediaCollection();
            }
        }
    }

    public function generateCsNumber()
    {

        $code = 'CS/' . strtoupper(Carbon::today()->format('My'));
        $query = CsDetail::query()->select('cs_number')
            ->where('cs_number', 'LIKE', '%' . $code . '%')
            ->withTrashed()
            ->latest()->first();

        $initial_number = str_pad(1, 3, 0, STR_PAD_LEFT);

        if (is_null($query)) {
            $csNumber = $code . '/' . $initial_number;
        } else {
            $value = explode('/', $query->cs_number);
            $number = $value[2] + 1;
            $next_number = str_pad($number, 3, 0, STR_PAD_LEFT);
            $csNumber = $code . '/' . $next_number;
        }

        return $csNumber;
    }

    public function approvalAccess($data)
    {
        foreach ($data as $value) {
            if ($value['employee_id'] == auth()->user()->employee->id && $value['status'] == 'pending') {
                return true;
            }
        }
        return false;
    }
    public function approvalId($data)
    {
        foreach ($data as $value) {
            if ($value['employee_id'] == auth()->user()->employee->id) {
                return $value['id'];
            }
        }
    }
    public function getCSDropDown()
    {
        return CsDetail::query()->whereNull('deleted_at')
            ->select('id', 'cs_number')
            ->get();
    }

    public function withdraw($csDetail)
    {

        if($csDetail->approval){
            $csDetail->approval()->delete();
        }

        return $csDetail->update([
            'status'=>'draft',
        ]);

    }

    public function approvalAuthority($data)
    {
        foreach ($data as $value) {
            if ($value['employee_id'] == auth()->user()->employee->id) {
                return true;
            }
        }
        return false;
    }

    public function delete($csDetail)
    {

        if($csDetail){

            $notifications = \App\Models\Notification::query()->where('type','App\Notifications\CsDetailNotification')
                ->where('data->cs_detail_id',$csDetail->id)->get();

            foreach ($notifications as $notification){
                \App\Models\Notification::query()->find($notification->id)->delete();
            }
        }
        return $csDetail->delete();

    }

    public function reSubmitApproval($csDetail,$request)
    {


        $approvals = $csDetail->approval()->where('status','reverted')->get()->first();
        $approval = new Approval();
        $approval->employee_id = auth()->user()->employee->id;
        $approval->status = 'resubmitted';
        $approval->approval_stage = $approvals->approval_stage;
        $approval->description = $request['description'];
        $csDetail->approval()->save($approval);


    }
}
