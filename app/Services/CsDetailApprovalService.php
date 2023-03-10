<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\CsDetail;
use App\Notifications\CsDetailNotification;
use App\Traits\MailMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class CsDetailApprovalService
{
    use MailMessage;

    public function statusChange($request)
    {
        // Find  CS Detail
        $cs_detail = CsDetail::with('approval')->findOrFail($request->cs_detail_id);

        // Find Approval
        $approval = Approval::query()->findOrFail($request->approval_id);

        // actions for change status
        self::statusChangeAction($cs_detail, $approval, $request);

        // send notification to user
        $message = $this->CsDetailResponseMesageforUser($cs_detail);

        (new CsDetailService())->sendNotification($cs_detail->requester_employee_id, $message);

    }

    /*
     * CS Action for Approved , Reverted and Rejected.
     */
    public function statusChangeAction($cs_detail, $approval, $request)
    {
        self::approvalUpdate($approval, $request->status, $request->description);
        // Find team-mate approvals
        $approvals = $cs_detail->approval->where('approvalable_id', $approval->approvalable_id)
            ->where('status', 'pending')
            ->Where('employee_id', '!=', $approval->employee_id)
            ->where('approval_stage', $approval->approval_stage);

        $status = self::getStatus($request->status);

        if (count($approvals) != 0) {
            foreach ($approvals as $approval) {
                self::approvalUpdate($approval, $status);
            }
        }
        $cs_detail->update([
            'status' => $request->status,
            'status_date' => Carbon::now(),
        ]);

    }

    public function getStatus($status): string
    {
        return $status . '-by-teammate';
    }

    public function approvalUpdate($approval, $status = null, $description = null)
    {
        $approval->update([
            'status' => $status,
            'description' => $description,
            'status_date' => Carbon::now(),
        ]);
    }

    public function masterUserStatusChange($request)
    {
        $cs_detail = CsDetail::with('approval')->findOrFail($request->cs_detail_id);
        // Find Approval
        $approvals = Approval::query()->where('approvalable_type','App\Models\CsDetail')
            ->where('approvalable_id',$cs_detail->id)->get();

        $status = $request->status.'-by-master-user';
        $findApproval='';
        // update previous approval
        if (count($approvals) != 0) {
            $findApproval = $approvals[0];
            foreach ($approvals as $approval) {
                self::approvalUpdate($approval, $status);
            }
        }

        //create new approval
        $approval = new Approval();
        $approval->employee_id = auth()->user()->employee ? auth()->user()->employee->id:null;;
        $approval->authority_order = $findApproval->authority_order;
        $approval->status = $request->status;
        $approval->approval_stage = $findApproval->approval_stage;
        $approval->status_date = Carbon::now();
        $cs_detail->approval()->save($approval);

        $cs_detail->update([
            'status' => $request->status,
            'status_date' => Carbon::now(),
        ]);

        // send notification to user
        $message = $this->CsDetailResponseMesageforUser($cs_detail);
        (new CsDetailService())->sendNotification($cs_detail->requester_employee_id, $message);

    }
}
