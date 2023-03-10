<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Requisition;
use App\Services\RequisitionApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RequisitionApprovalController extends Controller
{
    protected $approvalService;

    public function __construct(RequisitionApprovalService $approvalService)
    {
        $this->approvalService = $approvalService;

    }

    public function statusChangeByBuHead(Requisition $requisition, Request $request)
    {

        if ($request->status == 'approved') {
            return $this->approvalService->statusApproved($requisition,$request);
        }
        else {
            return $this->approvalService->statusRejectRevert($requisition,$request);
        }

    }

    public function requisitionForward(Requisition $requisition,Request $request)
    {
        DB::beginTransaction();
        try {

            $this->approvalService->forwardApproval($requisition,$request->employees);
//            $this->approvalService->forwardNotification($requisition,$request->employees);
            DB::commit();
            $message = "Requisition Successfully forwarded.";
            return response()->json(['message' => $message], 201);
        } catch (Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();
            $message = "Something went wrong" . $e;
            return response()->json(['message' => $message], 400);
        }
    }

    public function statusChangeMasterUser(Requisition $requisition,Request $request)
    {

        return $this->approvalService->statusChangeMasterUser($requisition,$request);

    }

    public function requisitionReInitiate(Requisition $requisition,Request $request)
    {

        DB::beginTransaction();
        try {
            $reInitiate = $this->approvalService->requisitionReInitiate($requisition,$request);
            DB::commit();
            $message="";
            if($reInitiate){
                $message = "Your response has been recorded successfully";
            }
            return response()->json(['message' => $message], 201);
        } catch (Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();

            $message = "Something went wrong. See details" . $e;
            return response()->json(['message' => $message], 400);
        }

    }

}
