<?php

namespace App\Services;
use App\Helpers\ApprovalNotification;
use App\Models\Approval;
use App\Models\PurchaseOrder;
use App\Notifications\PurchaseOrderNotification;
use App\Traits\MailMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class PurchaseOrderApprovalService
{
    /*
     * Approval Stage sequence
     * bu_head
     * cs_approval_hod (Head Of procurement)
     * cs_approval_panel
     * chief_business_officer
     * deputy_finance_director
     * chief_finance_officer
     * chief_executive_officer
     */
    use MailMessage;

    public function statusCheck($request)
    {

        $purchaseOrder = PurchaseOrder::with('approval')->findOrFail($request->purchade_order_id);
        $approval = Approval::query()->findOrFail($request->approval_id);

        if ($request->status == 'approved') {

            // status approved
            self::approved($request, $purchaseOrder, $approval);

        } else {
            // other status
            self::approvedRevertReject($request, $purchaseOrder, $approval);
            $message = $this->purchaseOrderResponseMesageforUser($purchaseOrder);
            self::sendNotification($purchaseOrder->employee_id, $message);
        }

    }


    public function approved($request, $purchaseOrder, $approval)
    {

        // Bu head team stage
        if ($approval->approval_stage == 'bu_head') {

            self::updateStatus($purchaseOrder, $request, $approval);
            self::createApproval($purchaseOrder, 2, 'pending', 'cs_approval_hod');
            self::triggerNotification($purchaseOrder, 'cs_approval_hod');
        }
        // procurement team stage
        if ($approval->approval_stage == 'cs_approval_hod') {

            self::procurementStage($request, $purchaseOrder, $approval);
        }
        if($approval->approval_stage == 'chief_business_officer'){
            self::chiefBusinessOfficerStage($purchaseOrder,$request,$approval);
        }
        if($approval->approval_stage == 'deputy_finance_director'){
            self::deputyFinanceDirectorStage($request,$purchaseOrder,$approval);
        }
        if($approval->approval_stage == 'chief_finance_officer'){
            self::chiefFinanceOfficer($request,$purchaseOrder,$approval);
        }
        if($approval->approval_stage == 'chief_executive_officer'){

            self::chiefExecutiveOfficerStage($purchaseOrder, $request, $approval);
        }
    }


    public function approvedRevertReject($request, $purchaseOrder, $approval)
    {
        ApprovalNotification::approvalUpdate($approval, $request->status, $request->description);
        // Find team-mate approvals
        $approvals = $purchaseOrder->approval->where('approvalable_id', $approval->approvalable_id)
            ->where('status', 'pending')
            ->Where('employee_id', '!=', $approval->employee_id)
            ->where('approval_stage', $approval->approval_stage);

        $status = self::getStatus($request->status);

        if (count($approvals) != 0) {
            foreach ($approvals as $approval) {
                ApprovalNotification::approvalUpdate($approval, $status);
            }
        }
        // purchase order self update
        $purchaseOrder->update([
            'status' => $request->status,
            'status_date' => Carbon::now(),
        ]);

    }

    /**
     * @param $budget
     * @param $purchaseOrder
     * @return bool
     */
    public function budgetCheck($budget, $purchaseOrder): bool
    {
        return $purchaseOrder->total_price_with_vat <= $budget;
    }


    public function updateStatus($purchaseOrder, $request, $approval)
    {

        ApprovalNotification::approvalUpdate($approval, 'approved', $request->description);

        $approvals = $purchaseOrder->approval->where('approvalable_id', $approval->approvalable_id)
            ->where('status', 'pending')
            ->Where('employee_id', '!=', $approval->employee_id)
            ->where('approval_stage', $approval->approval_stage);

      // approval status
        $status = self::getStatus($request->status);

        if (count($approvals) != 0) {
            foreach ($approvals as $approval) {
                ApprovalNotification::approvalUpdate($approval, $status);
            }
        }

    }

    public function getStatus($status): string
    {
        return $status . '-by-teammate';
    }

    public function createApproval($purchaseOrder, $authority_order = 1, $status = 'pending', $approval_stage = 'bu_head', $description = null)
    {
        $teamMembers = ApprovalNotification::teamMembers($purchaseOrder, $approval_stage);

        if (!is_null($teamMembers)) {
            foreach ($teamMembers as $employee_id) {
                $approval = new Approval();
                $approval->employee_id = $employee_id;
                $approval->authority_order = $authority_order;
                $approval->status = $status;
                $approval->approval_stage = $approval_stage;
                $approval->description = $description;
                $purchaseOrder->approval()->save($approval);
            }
        }
    }

    public function triggerNotification($purchaseOrder, $approval_stage)
    {
        $teamMembers = ApprovalNotification::teamMembers($purchaseOrder, $approval_stage);

        $message = $this->purchaseOrderApprovalMessage($purchaseOrder);
        if (!is_null($teamMembers)) {
            foreach ($teamMembers as $employee_id) {
                self::sendNotification($employee_id, $message);
            }
        }
    }

    public function sendNotification($employee_id, $message)
    {
        $user = ApprovalNotification::getUser($employee_id);
        \Log::info($user);
        Notification::send($user, new PurchaseOrderNotification($message));
    }

    public function procurementStage($request, $purchaseOrder, $approval){
        $inBudget = self::budgetCheck(200000, $purchaseOrder);
        if ($inBudget) {
            // in budget
            self::approvedRevertReject($request, $purchaseOrder, $approval);
            $message = $this->purchaseOrderResponseMesageforUser($purchaseOrder);
            self::sendNotification($purchaseOrder->employee_id, $message);
        } else {
            // over budget
            self::updateStatus($purchaseOrder, $request, $approval);
            self::createApproval($purchaseOrder, 3, 'pending', 'chief_business_officer');
            self::triggerNotification($purchaseOrder, 'chief_business_officer');
        }
    }

    public function chiefBusinessOfficerStage($purchaseOrder,$request,$approval)
    {
        // budget over 200000+
        if($purchaseOrder->total_price_with_vat > 200000){
            self::updateStatus($purchaseOrder, $request, $approval);
            self::createApproval($purchaseOrder, 4, 'pending', 'deputy_finance_director');
            self::triggerNotification($purchaseOrder, 'deputy_finance_director');
        }
    }

    public function deputyFinanceDirectorStage($request,$purchaseOrder,$approval)
    {
       // in budget
        if($purchaseOrder->total_price_with_vat > 200001 && $purchaseOrder->total_price_with_vat <=1000000){
            self::approvedRevertReject($request, $purchaseOrder, $approval);
            $message = $this->purchaseOrderResponseMesageforUser($purchaseOrder);
            self::sendNotification($purchaseOrder->employee_id, $message);
        }else{
            self::updateStatus($purchaseOrder, $request, $approval);
            self::createApproval($purchaseOrder, 5, 'pending', 'chief_finance_officer');
            self::triggerNotification($purchaseOrder, 'chief_finance_officer');
        }
    }

    public function chiefFinanceOfficer($request,$purchaseOrder,$approval)
    {
        // budget over 200000+
        if($purchaseOrder->total_price_with_vat >= 1000001){
            self::updateStatus($purchaseOrder, $request, $approval);
            self::createApproval($purchaseOrder, 6, 'pending', 'chief_executive_officer');
            self::triggerNotification($purchaseOrder, 'chief_executive_officer');
        }
    }

    public function chiefExecutiveOfficerStage($purchaseOrder, $request, $approval)
    {
        self::approvedRevertReject($request, $purchaseOrder, $approval);
        $message = $this->purchaseOrderResponseMesageforUser($purchaseOrder);
        self::sendNotification($purchaseOrder->employee_id, $message);
    }

    public function masterUserStatusChange($request)
    {

        $purchaseOrder = PurchaseOrder::with('approval')->findOrFail($request->purchade_order_id);
        $approvals = Approval::query()->where('approvalable_type','App\Models\PurchaseOrder')
            ->where('approvalable_id',$purchaseOrder->id)->get();

        $status = $request->status.'-by-master-user';
        $findApproval='';
        // update previous approval
        if (count($approvals) != 0) {
            $findApproval = $approvals[0];
            foreach ($approvals as $approval) {
                ApprovalNotification::approvalUpdate($approval, $status);
            }
        }

        //create new approval
        $approval = new Approval();
        $approval->employee_id = auth()->user()->employee ? auth()->user()->employee->id:null;
        $approval->authority_order = $findApproval->authority_order;
        $approval->status = $request->status;
        $approval->approval_stage = $findApproval->approval_stage;
        $approval->status_date = Carbon::now();
        $purchaseOrder->approval()->save($approval);

        // purchase order self update
        $purchaseOrder->update([
            'status' => $request->status,
            'status_date' => Carbon::now(),
        ]);

        $message = $this->purchaseOrderResponseMesageforUser($purchaseOrder);
        self::sendNotification($purchaseOrder->employee_id, $message);

    }
}
