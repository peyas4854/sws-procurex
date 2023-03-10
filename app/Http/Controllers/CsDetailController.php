<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsDetails\SaveFormRequest;
use App\Models\CsDetail;
use App\Models\Requisition;
use App\Services\ApprovalTeamService;
use App\Services\CostCenterService;
use App\Services\CsDetailService;
use App\Services\EmployeeService;
use App\Services\RequisitionService;
use App\Traits\MarkAsRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class CsDetailController extends Controller
{
    use MarkAsRead;

    protected $csdetailService;

    public function __construct()
    {
        $this->csdetailService = new CsDetailService();

        // initiate permission
        //$this->middleware('permission:cs-list', ['only' => ['index']]);
        $this->middleware('permission:cs-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:cs-print', ['only' => ['print']]);
//        $this->middleware('permission:cs-view', ['only' => ['view']]);

    }

    public function index(Request $request)
    {
        $data = $request->all();
        $cs_details = $this->csdetailService->lists($data);
        $costCenter = (new CostCenterService())->getDropdownList();
        $employees = (new ApprovalTeamService())->team('procurement_team');
        return view("cs-details.list", compact([
            "cs_details",
            "request",
            'costCenter',
            'employees'
        ]));
    }

    public function create($id = null)
    {

        $requisition = null;
        if ($id != null) {
            $requisition = Requisition::query()->where('id', $id)->with(['requisitionDetails', 'approval_team' => function ($query) {
                $query->orderBy('id');
            }, 'employee'])->first();
        }
        $costCenter = (new CostCenterService())->getDropdownList();
        $prDropdown = (new RequisitionService())->getPRDropdown();

        return view('cs-details.create', compact(
            'requisition',
            'costCenter',
            'prDropdown'
        ));
    }

    public function save(SaveFormRequest $request)
    {
        DB::beginTransaction();
        try {
            $csDetails = $this->csdetailService->store($request);
            DB::commit();
            $message = message("CSDetail has been successfully created.");
        } catch (Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();
            $message = message("CSDetail has not created $e", "error");
        }
        session()->flash("message", $message);
        return redirect('cs-details');

    }

    public function view(Request $request, $id)
    {

        // find cs detail with all approval
        $cs_Detail = CsDetail::with(['approval' => function ($query) {
            $query->latest();
        }])->find($id);

        if(!$cs_Detail){
            $message = message("This CS not available right now", 'error');
            session()->flash("message", $message);
            return redirect()->back();
        }

        $approvalAccess = $this->csdetailService->approvalAccess($cs_Detail->approval);
        $approvalAuthority = $this->csdetailService->approvalAuthority($cs_Detail->approval);

        if(!$approvalAuthority && auth()->user()->type !='hq-admin' && auth()->user()->type !='admin' ){
            abort(403, 'Access denied');
        }

        $this->markAsRead($request);
        $approvalId = $this->csdetailService->approvalId($cs_Detail->approval);
        $files = $cs_Detail->getMedia();
        // get requisition related with cs detail.
        $requisition = Requisition::query()->where('id', $cs_Detail->requisition_id)->with(['requisitionDetails', 'approval_team' => function ($query) {
            $query->where('status', '=', 'approved');
        }, 'employee'])->first();
        $costCenter = (new CostCenterService())->getDropdownList();

        return view('cs-details.view', compact(
            'cs_Detail',
            'costCenter',
            'requisition',
            'files',
            'approvalAccess',
            'approvalId'
        ));
    }

    public function edit(CsDetail $csDetail)
    {
        $cs_Detail = $csDetail;
        $costCenter = (new CostCenterService())->getDropdownList();
        $prDropdown = (new RequisitionService())->getPRDropdown();
        return view('cs-details.edit', compact(
            'costCenter',
            'cs_Detail',
            'prDropdown'
        ));
    }

    public function print($id){

        $cs_Detail = CsDetail::with(['approval' => function ($query) {
            $query->latest();
        }])->findOrFail($id);
        return view('cs-details.print.index', compact('cs_Detail'));
    }

    public function withdraw(CsDetail $csDetail)
    {

        $response = $this->csdetailService->withdraw($csDetail);
        if ($response === true) {
            $message = message("CSDetail has been successfully withdraw.");
        } else {
            $message = message("CSDetail has not withdraw.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();

    }

    public function destroy(CsDetail $csDetail)
    {


        $response = $this->csdetailService->delete($csDetail);

        if ($response === true) {
            $message = message("CS has been successfully deleted.");
        } else {
            $message = message("CS has not deleted.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();

    }

}
