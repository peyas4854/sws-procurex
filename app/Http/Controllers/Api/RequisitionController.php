<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Requisitions\SaveFormRequest;
use App\Http\Resources\PurchaseOrderRequisitionItemResource;
use App\Http\Resources\RequisitionEditResource;
use App\Http\Resources\RequisitionResource;
use App\Models\ApprovalTeam;
use App\Models\Requisition;
use App\Services\ApprovalTeamService;
use App\Services\CostCenterService;
use App\Services\DepartmentService;
use App\Services\RequisitionService;
use App\Services\SettingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequisitionController extends Controller
{
    protected $requisitionService;

    public function __construct()
    {
        $this->requisitionService = new RequisitionService();
    }

    public function requisitionCreateInfo()
    {
        return $this->requisitionService->requisitionCreateInfo();
    }

    public function store(SaveFormRequest $request)
    {


        $items = json_decode($request->itemData);

        foreach ($items as $val) {
            if ($val->quantity == '') {
                return response()->json(['message' => 'Please select an item'], 400);
            }
        }
        if ($request->item_type == 'it') {
            $query = (new ApprovalTeamService())->getTeamMembers('it_team');
            if (count($query) == 0) {
                return response()->json(['error' => 'It team approval member not define , please contact with your super admin'], 400);
            }
        }

        if ($request->item_type == 'admin') {

            $buHead = (new RequisitionService())->buHead($request->cost_center_id);

            if (count($buHead) == 0) {
                return response()->json(['error' => 'business unit head  not define , please contact with your super admin'], 400);
            }
        }


        DB::beginTransaction();
        try {
            $this->requisitionService->store($request);
            DB::commit();
            $message = "Successfully send to approval team";
            return response()->json(['message' => $message], 201);
        } catch (Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();
            $message = "Something went wrong" . $e;
            return response()->json(['message' => $message], 400);
        }
    }

    public function show(Requisition $requisition)
    {

        return new RequisitionResource($requisition);
    }

    public function edit(Requisition $requisition)
    {
        return new RequisitionEditResource($requisition);
    }

    public function requisitionDetailItem(Request $request)
    {
        $items = $this->requisitionService->getItemsFromRequisitionDetail($request->ids);
        return PurchaseOrderRequisitionItemResource::collection($items);
    }

    public function itTeamStore(Request $request)
    {

        DB::beginTransaction();
        try {
            $this->requisitionService->itTeamStoreAndSendApproval($request);
            DB::commit();
            $message = "Successfully Save and send to approval team";
            return response()->json(['message' => $message], 201);
        } catch (Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();
            $message = "Something went wrong" . $e;
            return response()->json(['message' => $message], 400);
        }

    }

    public function revertRequisitionStore(Request $request)
    {

        DB::beginTransaction();
        try {
            $this->requisitionService->itTeamStoreAndSendApproval($request);
            DB::commit();
            $message = "Successfully Save and send to approval team";
            return response()->json(['message' => $message], 201);
        } catch (Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();
            $message = "Something went wrong" . $e;
            return response()->json(['message' => $message], 400);
        }

    }


}
