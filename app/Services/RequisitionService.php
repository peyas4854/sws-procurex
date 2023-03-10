<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\Employee;
use App\Models\Notification;
use App\Models\Requisition;
use App\Models\RequisitionDetail;
use App\Models\User;
use App\Traits\MailMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class RequisitionService
{
    use MailMessage;

    protected $errorNotifier;
    protected $settingService;
    protected $dateFormat;

    public $paginatedList = true;

    public function __construct()
    {
        $this->errorNotifier = new ErrorNotifierService();
        $this->settingService = new SettingService();
        $this->dateFormat = $this->settingService->get("date_format") ?? "Y-m-d";
    }

    public function lists($data = null, $all = false)
    {

        $search_query = [];
        $order = $this->settingService->get("data_order", "desc") ?? "desc";
        if (auth()->user()->type == 'admin' || auth()->user()->type == 'hq-admin') {
            $query = Requisition::query()->with(['employee', 'costcenter', 'purchaseOrderRequisition', 'approvalAccess','csDetailRequisition']);

        } else {
            $requisitions_ids = Requisition::query()->where('created_by', auth()->id())->pluck('id')->unique()->toArray();
            $approval_ids = array();
            if (auth()->user()->employee) {
                $approval_ids = Approval::query()->where('approvalable_type', 'App\Models\Requisition')
                    ->where('employee_id', auth()->user()->employee->id)
                    ->pluck('approvalable_id')->unique()->toArray();
            }

            $ids = (array_merge($requisitions_ids, $approval_ids));

            $query = Requisition::query()->with(['costcenter', 'employee', 'approvalAccess','csDetailRequisition'])->whereIn('id', array_unique($ids));
        }

        if (isset($data["search"])) {
            $search_query = [
                "search" => $data["search"]
            ];
            $query->where(function ($q) use ($data) {
                $q->orWhere("requisition_code", "LIKE", "%" . $data["search"] . "%");
            });

        }
        if (isset($data["item_type"])) {
            $query->where('item_type', $data["item_type"]);
            $search_query = [
                "item_type" => $data["item_type"]
            ];
        }
        if (isset($data["cost_center_id"])) {
            $query->where('cost_center_id', $data["cost_center_id"]);
            $search_query = [
                "cost_center_id" => $data["cost_center_id"]
            ];
        }
        if (isset($data["procurement_type"])) {
            $query->where('procurement_type', $data["procurement_type"]);
            $search_query = [
                "procurement_type" => $data["procurement_type"]
            ];
        }
        if (isset($data["budget_info"])) {
            $query->where('budget_info', $data["budget_info"]);
            $search_query = [
                "budget_info" => $data["budget_info"]
            ];
        }
        if (isset($data["status"])) {

            $query->where('status', $data["status"]);
            $search_query = [
                "status" => $data["status"]
            ];
        }
        if (isset($data["employee_id"])) {
            $query->where('employee_id', $data["employee_id"]);
            $search_query = [
                "employee_id" => $data["employee_id"]
            ];
        }
        if (isset($data['date_filter'])) {
            $parts = explode(' - ', $data['date_filter']);
            $date_from = Carbon::parse($parts[0]);
            $date_to = Carbon::parse($parts[1]);
            $query->whereBetween("required_date", [$date_from, $date_to]);
        }
        if (isset($data['approval_stage'])) {

            $query->whereHas('approvalAccess', function ($q) use ($data) {
                $q->where('approval_stage', $data['approval_stage']);
            })->where('status', 'pending');
            $search_query = [
                "approval_stage" => $data["approval_stage"]
            ];
        }

        $query->orderBy('id', $order);

        if ($all) {
            return $query->get();
        }
        if ($this->paginatedList === true) {

            $item_per_page = $this->settingService->get("item_per_page", 25) ?? 25;

            $requisitions = $query->paginate($item_per_page)->appends($search_query);
            $requisitions->pagination_summary = get_pagination_summary($requisitions);
        } else {
            $requisitions = $query->get();
        }

        return $requisitions;
    }

    public function updateOrCreate($data)
    {
        $user_id = auth()->user()->id;

        if (!empty($data["id"])) {
            // update

            $requisition = Requisition::whereId($data["id"])->first();
            $requisition->updated_by = $user_id;

        } else {
            //create

            $requisition = new Requisition();
            $requisition->created_by = $user_id;
        }


        if (isset($data['requisition_code'])) {
            $requisition->requisition_code = $data['requisition_code'];
        }


        if (isset($data['cost_center_id'])) {
            $requisition->cost_center_id = $data['cost_center_id'];
        }


        $requisition->employee_id = $data['employee_id'];


        if (isset($data['application_date'])) {
            $requisition->application_date = $data['application_date'];
        }


        if (isset($data['required_date'])) {
            $requisition->required_date = $data['required_date'];
        }


        if (isset($data['procurement_type'])) {
            $requisition->procurement_type = $data['procurement_type'];
        }


        if (isset($data['budget_info'])) {
            $requisition->budget_info = $data['budget_info'];
        }


        if (isset($data['delivery_location'])) {
            $requisition->delivery_location = $data['delivery_location'];
        }


        if (isset($data['approximate_cost'])) {
            $requisition->approximate_cost = $data['approximate_cost'];
        }


        return $requisition->save() ? $requisition : null;
    }

    public function getById($id)
    {
        return Requisition::find($id);
    }

    public function delete($requisition)
    {
        if($requisition->requisitionDetails()->count()){
            // delete notification
            $notifications = Notification::query()->where('type','App\Notifications\RequisitionNotification')
                ->where('data->requisition_id',$requisition->id)->get();

            foreach ($notifications as $notification){
                Notification::query()->find($notification->id)->delete();

            }
            // delete requisition details
            $requisition->requisitionDetails()->delete();


        }
        // deleted media related with requisition
        if($requisition->media()){
            $mediaList = $requisition->getMedia();
            foreach ($mediaList as $media){
                Media::query()->find($media->id)->delete();
            }
        }
        return $requisition->delete();
    }

    public function withdraw($requisition)
    {
         return $requisition->update([
           'status'=>'draft',
        ]);
    }

    public function requisitionCreateInfo()
    {
        $info = [];
        $info['dateFormate'] = self::dateFormate();
        $info['itemType'] = self::itemType();
        $info['budgetInfo'] = self::budgetInfo();
        $info['procurementType'] = self::procurementType();
        $info['employeeList'] = (new EmployeeService())->getDropdown();
        $info['departmentList'] = (new DepartmentService())->getDepartment();
        $info['designationList'] = (new DesignationService())->getDesignation();
        $info['costCenterList'] = (new CostCenterService())->getCostCenter();
        $info['uomList'] = (new UomService())->getUom();

        $departments = (new SettingService())->get('departments');

        $settingsDepartments = $departments ? json_decode($departments) : [];

        $info['changeCostCenterDepartments'] = array_map('intval', $settingsDepartments);

        return $info;
    }

    public function dateFormate()
    {
        $settings = new SettingService();
        $dateFormat = $settings->get("date_format", "Y-m-d");
        return config("settings.js_date_format.{$dateFormat}");
    }

    public function itemType()
    {
        return config("constants.item_type");
    }

    public function budgetInfo()
    {
        return config("constants.budget_info");
    }

    public function procurementType()
    {
        return config("constants.procurement_type");
    }

    public function getRequisitionDropDown()
    {
        return Requisition::query()->where('status','approved')
            ->whereNull('deleted_at')
            ->select('id', 'requisition_code')
            ->get();
    }

    public function store($request)
    {

        $requisition = self::requisitionStore($request);

        if (array_key_exists('files', $request->all())) {
            self::uploadFiles($requisition, $request);
        }
        self::storeRequisitionDetails($request, $requisition->id, $request->itemData);

        if($request->revert_mode == 'true'){

            (new RequisitionApprovalService())->revertCreateApproval($requisition,$request);
        }else{
            self::itemTypeApproval($request, $requisition);
        }
    }

    public function itemTypeApproval($request, $requisition)
    {
        if ($request->item_type == "it") {
            (new RequisitionApprovalService())->createApproval($requisition, 1, 'pending', 'it_team', Null);
            (new RequisitionApprovalService())->triggerNotification($requisition, 'it_team');
        } else {
            (new RequisitionApprovalService())->createApproval($requisition, 1, 'pending', 'procurement_team', Null);
            (new RequisitionApprovalService())->triggerNotification($requisition, 'procurement_team');
        }

    }

    public function requisitionStore($request)
    {

        $required_date = self::requireDate($request);
        $employee = Employee::query()->find($request->employee_id);

        $data = [
            'item_type' => $request->item_type,
            'cost_center_id' => $request->cost_center_id,
            'employee_id' => $request->employee_id,
            'application_date' => Carbon::now(),
            'required_date' => $required_date,
            'procurement_type' => $request->procurement_type,
            'approximate_cost' => $request->sub_total,
            'status' => 'pending',
            'delivery_location' => $request->delivery_location,
            'contact_person_name_and_number' => $request->contact_person_name_and_number,
            'description' => $request->description,
            'budget_info' => $request->budget_info,
            'created_by' => $employee->user_id,
        ];

        if ($request->revert_mode == "true") {
            $id = $request->id;
            $data['status'] = 'pending';

        } else {
            $id = null;
            $data['requisition_code'] = self::generatePRCode();
        }

        return Requisition::query()->updateOrCreate(
            ['id' => $id],
            $data
        );
    }
    public function requireDate($request): ?string
    {
        if($request->required_date != 'null' && !is_null($request->required_date)){
            return  Carbon::parse($request->required_date)->format($this->dateFormat);
        }else{
            return null;
        }
    }


    public function storeRequisitionDetails($request, $requisitionId, $items)
    {
        if($request->revert_mode === "true") {
            RequisitionDetail::query()->where('requisition_id',$requisitionId)->delete();
        }
        foreach (json_decode($items) as $item) {


            RequisitionDetail::query()->Create(
                [
                    'requisition_id' => $requisitionId,
                    'item_id' => $item->item_id,
                    'uom_id' => $item->uom_id,
                    'unit_price' => $item->unit_price,
                    'price' => $item->total_price,
                    'quantity' => $item->quantity,
                    'description' => $item->description,
                    'brand' => isset($item->brand) ? $item->brand :null,
                ]);
        }
        (new ItemService())->itemPriceUpdate($item->unit_price,$item->item_id);
    }


    public function uploadFiles($requisition, $request)
    {
        foreach ($request->files as $key => $file) {
            foreach ($file as $singlefile) {
                $requisition->addMedia($singlefile)
                    ->preservingOriginal()
                    ->toMediaCollection();
            }
        }
    }

    public function generatePRCode(): string
    {
        $code = 'PR/' . strtoupper(Carbon::today()->format('My'));
        $query = Requisition::query()->select('requisition_code')
            ->where('requisition_code', 'LIKE', '%' . $code . '%')
            ->withTrashed()
            ->latest()->first();
        $initial_number = str_pad(1, 3, 0, STR_PAD_LEFT);
        if (is_null($query)) {
            $pr = $code . '/' . $initial_number;
        } else {
            $value = explode('/', $query->requisition_code);
            $number = $value[2] + 1;
            $next_number = str_pad($number, 3, 0, STR_PAD_LEFT);
            $pr = $code . '/' . $next_number;
        }
        return $pr;
    }

    public function getItemsFromRequisitionDetail($ids){

        return RequisitionDetail::query()->whereIn('requisition_id',$ids)->get();
    }

    public function getPRDropdown()
    {

        return Requisition::query()->where('status','approved')
            ->whereNull('deleted_at')
            ->select('id', 'requisition_code')
            ->pluck('requisition_code','id');
    }

    public function itTeamStoreAndSendApproval($request)
    {
        $requisition = self::requisitionStore($request);
        if (array_key_exists('files', $request->all())) {
            self::uploadFiles($requisition, $request);
        }
        self::storeRequisitionDetails($request, $requisition->id, $request->itemData);

    }
    public function buHead($cost_center_id, $requisition=null)
    {
        $costCenters = json_decode(SettingService::get('cost_centers'));

        if ($costCenters && in_array($cost_center_id, $costCenters)) {

            $buHead = (new DepartmentService())->getMembers($requisition->employee->department->id ?? auth()->user()->employee->department_id);
        } else {
            $buHead = (new CostCenterService())->getMembers($cost_center_id);
        }
        return $buHead;

    }
}
