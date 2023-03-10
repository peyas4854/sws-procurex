<?php

namespace App\Services;

use Exception;
use App\Models\Approval;
use App\Models\User;
use App\Notifications\RequisitionNotification;
use App\Traits\MailMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;


class RequisitionApprovalService
{
    use MailMessage;

    protected $type = ['it_team', 'admin_team', 'bu_head'];

    public function statusApproved($requisition, $request)
    {
        DB::beginTransaction();
        try {
            self::checkStatus($requisition, $request);
            DB::commit();
            $message = "Your response has been recorded successfully";
            return response()->json(['message' => $message], 201);
        } catch (Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();
            $message = "Something went wrong. See details " . $e;
            return response()->json(['message' => $message], 400);

        }
    }

    public function checkStatus($requisition, $request)
    {


        $approval = Approval::query()->findOrFail($request->approval_id);


        if ($approval->approval_stage == 'it_team') {
            self::updateStatus($requisition, $request, $approval);
            self::createApproval($requisition, 2,'pending','procurement_team');
            self::triggerNotification($requisition, 'procurement_team');
        } else if ($approval->approval_stage == 'procurement_team') {
            self::updateStatus($requisition, $request, $approval);
            self::createApproval($requisition, 3, 'pending', 'finance');
            self::triggerNotification($requisition, 'finance');
        } else if ($approval->approval_stage == 'finance') {
            self::updateStatus($requisition, $request, $approval);
            self::createApproval($requisition, 3, 'pending', 'bu_head');
            self::triggerNotification($requisition, 'bu_head');
        } else {
            self::approvalStatusUpdate($approval, $requisition, 'bu_head', $request);
            $message = $this->sendToUser($requisition);
            self::sendNotification($requisition->employee_id, $message);
            self::procurementTeamNotification($requisition);

        }
    }

    public function procurementTeamNotification($requisition)
    {
        $teamMembers = self::teamMembers($requisition, 'procurement_team');
        $message = $this->procurementTeamMessage($requisition);
        if (!is_null($teamMembers)) {
            foreach ($teamMembers as $employee_id) {
                self::sendNotification($employee_id, $message);
            }
        }
    }

    public function updateStatus($requisition, $request, $approval)
    {

        self::approvalUpdate($approval, 'approved', $request->description);
        $approvals = $requisition->approval->where('approvalable_id', $approval->approvalable_id)
            ->where('status', 'pending')
            ->where('approval_stage', $approval->approval_stage);
        foreach ($approvals as $approval) {
            self::approvalUpdate($approval, 'approved-by-teammate');
        }

    }

    public function createApproval($requisition, $authority_order = 1, $status = 'pending', $approval_stage = 'bu_head', $description = null)
    {
        $teamMembers = self::teamMembers($requisition, $approval_stage);

        if (!is_null($teamMembers)) {
            foreach ($teamMembers as $employee_id) {
                $approval = new Approval();
                $approval->employee_id = $employee_id;
                $approval->authority_order = $authority_order;
                $approval->status = $status;
                $approval->approval_stage = $approval_stage;
                $approval->description = $description;
                $requisition->approval()->save($approval);
            }
        }
        return $teamMembers;
    }

    public function resubmitApproval($requisition,$approve,$description)
    {
        $approval = new Approval();
        $approval->employee_id = auth()->user()->employee->id;
        $approval->status = 'resubmitted';
        $approval->approval_stage = $approve->approval_stage;
        $approval->description = $description;
        $requisition->approval()->save($approval);
    }

    public function forwardApproval($requisition, $employees)
    {
        $message = $this->sendToCostCenterHead($requisition);
        if (count($requisition->approval) > 0) {
            $approvalData = $requisition->approval[0];


            foreach ($employees as $employee_id) {
                $data = [
                    'employee_id' => $employee_id,
                    'authority_order' => $approvalData->authority_order,
                    'status' => $approvalData->status,
                    'approval_stage' => $approvalData->approval_stage,
                    'forwarded_by_employee_id' => auth()->id(),
                    'is_forwarded' => 1,
                    'approvalable_type'=>'App\Models\Requisition',
                    'approvalable_id'=>$requisition->id
                ];

                $approvalExist = Approval::query()
                    ->where('employee_id',$employee_id)
                    ->where('approvalable_type','=','App\Models\Requisition')
                    ->where('approvalable_id',$requisition->id)
                    ->where('is_forwarded',1)
                    ->where('status',$approvalData->status)
                    ->count();


                if($approvalExist == 0){
                    Approval::query()->create($data);
                    self::sendNotification($employee_id, $message);
                }
            }

        }

    }

    public function forwardNotification($requisition, $employees)
    {
        $message = $this->sendToCostCenterHead($requisition);
        if (!is_null($employees)) {
            foreach ($employees as $employee_id) {
                   self::sendNotification($employee_id, $message);
            }
        }
    }

    public function triggerNotification($requisition, $approval_stage)
    {

        $teamMembers = self::teamMembers($requisition, $approval_stage);

        $message = $this->sendToCostCenterHead($requisition);
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
        Notification::send($user, new RequisitionNotification($message));
    }

    public function teamMembers($requisition, $approval_stage)
    {
        if ($approval_stage == 'bu_head') {
            return (new RequisitionService())->buHead($requisition->cost_center_id, $requisition);
        } else if ($approval_stage == 'finance') {
            return (new CostCenterService())->financeApproval($requisition->cost_center_id);
        } else {
            return (new ApprovalTeamService())->getTeamMembers($approval_stage);
        }
    }


    public function getUser($employee_id)
    {
        return User::select(["users.id", "users.email"])
            ->join("employees as e", "e.user_id", "users.id")
            ->where("e.id", $employee_id)
            ->whereNotNull("e.user_id")
            ->first();
    }

    public function approvalStatusUpdate($approval, $requisition, $approval_stage, $request)
    {

        self::approvalUpdate($approval, 'approved', $request->description);
        $requisition->update([
            'status' => 'approved',
            'procurement_type' => $request->procurement_type,
            'budget_info' => $request->budget_info,
            'status_date' => Carbon::now(),
        ]);
        $approvals = $requisition->approval->where('approvalable_id', $approval->approvalable_id)
            ->where('status', 'pending')
            ->where('approval_stage', $approval_stage);

        if (count($approvals) != 0) {
            foreach ($approvals as $approval) {
                Approval::find($approval->id)->update([
                    'status' => 'approved-by-teammate',
                    'status_date' => Carbon::now(),
                ]);
            }
        }
    }

    public function statusRejectRevert($requisition, $request)
    {
        DB::beginTransaction();
        try {
            self::action($requisition, $request);
            DB::commit();
            $message = "Your response has been recorded successfully";
            return response()->json(['message' => $message], 201);
        } catch (Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();
            $message = "Something went wrong. See details " . $e;
            return response()->json(['message' => $message], 400);
        }
    }

    public function action($requisition, $request)
    {
        $approval = Approval::query()->findOrFail($request->approval_id);
        self::approvalUpdate($approval, $request->status, $request->description);
        $approvals = $requisition->approval->where('approvalable_id', $approval->approvalable_id)
            ->where('status', 'pending')
            ->where('approval_stage', $approval->approval_stage);
        $status = $request->status == 'rejected' ? 'rejected-by-teammate' : 'reverted-by-teammate';
        foreach ($approvals as $approval) {
            self::approvalUpdate($approval, $status);
        }

        $requisition->update([
            'status' => $request->status,
            'procurement_type' => $request->procurement_type,
            'budget_info' => $request->budget_info,
            'status_date' => Carbon::now(),
        ]);
        $message = $this->sendToUser($requisition);
        self::sendNotification($requisition->employee_id, $message);
    }

    public function approvalUpdate($approval, $status = null, $description = null)
    {

        $approval->update([
            'status' => $status,
            'description' => $description,
            'status_date' => Carbon::now(),
            'approval_stage' => $approval->approval_stage,
        ]);
    }

    public function statusChangeMasterUser($requisition, $request)
    {
        DB::beginTransaction();
        try {
            self::masterUserAction($requisition, $request);
            DB::commit();
            $message = "Your response has been recorded successfully";
            return response()->json(['message' => $message], 201);
        } catch (Exception $ex) {
            DB::rollback();
            $e = $ex->getMessage();
            $message = "Something went wrong. See details " . $e;
            return response()->json(['message' => $message], 400);
        }

    }

    public function masterUserAction($requisition, $request)
    {
        $approvals = Approval::query()->where('approvalable_type', 'App\Models\Requisition')
            ->where('approvalable_id', $requisition->id)->get();


        $status = $request->status . '-by-master-user';
        $findApproval = $approvals->last();


        foreach ($approvals as $approval) {
            self::approvalUpdate($approval, $status);
        }

        // new approval create
        $approval = new Approval();
        $approval->employee_id = auth()->user()->employee ? auth()->user()->employee->id : null;
        $approval->status = $request->status;
        $approval->approval_stage = $findApproval->approval_stage;
        $requisition->approval()->save($approval);

        // update requisition
        $requisition->update([
            'status' => $request->status,
            'status_date' => Carbon::now(),
        ]);

        $message = $this->sendToUser($requisition);
        self::sendNotification($requisition->employee_id, $message);
        self::procurementTeamNotification($requisition);

    }

    public function revertCreateApproval($requisition, $request)
    {


        $approvals = $requisition->approval()->where('status', 'reverted')->get();

        // draft status
        if (count($approvals) == 0) {
            $approvals = $requisition->approval()->get();
            $approval = $approvals->last();

        } else {
            $approval = $approvals->last();
        }
        // resubmit approval for user
        self::resubmitApproval($requisition,$approval,$request->comment);

        if ($approval->approval_stage == 'it_team') {
            self::createApproval($requisition, 1, 'pending', 'it_team');
            self::triggerNotification($requisition, 'it_team');
        }
        else if ($approval->approval_stage == 'procurement_team') {
            self::createApproval($requisition, 2, 'pending', 'procurement_team');
            self::triggerNotification($requisition, 'procurement_team');
        }
        else if ($approval->approval_stage == 'finance') {
            self::createApproval($requisition, 3, 'pending', 'finance');
            self::triggerNotification($requisition, 'finance');
        }
        else if ($approval->approval_stage == 'bu_head') {
            self::createApproval($requisition, 4, 'pending', 'bu_head');
            self::triggerNotification($requisition, 'bu_head');
        }


    }

    public function requisitionReInitiate($requisition, $request)
    {

        $approval = $requisition->approval()->where('status', 'approved')->latest()->first();
        if (!$approval) {
            return false;
        }

        if ($approval->approval_stage == 'it_team') {
            self::updateStatus($requisition, $request, $approval);
            self::createApproval($requisition, 2);
            self::triggerNotification($requisition, 'bu_head');
        } else if ($approval->approval_stage == 'bu_head' || $approval->approval_stage == 'admin_team') {
            self::updateStatus($requisition, $request, $approval);
            self::createApproval($requisition, 2, 'pending', 'procurement_team');
            self::triggerNotification($requisition, 'procurement_team');
        }

    }

}
