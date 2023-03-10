<?php

namespace App\Helpers;

use App\Models\User;
use App\Services\ApprovalTeamService;
use App\Services\CostCenterService;
use App\Services\DepartmentService;
use Carbon\Carbon;

class ApprovalNotification
{

    public static function getUser($employee_id)
    {
        return User::select(["users.id", "users.email"])
            ->join("employees as e", "e.user_id", "users.id")
            ->where("e.id", $employee_id)
            ->whereNotNull("e.user_id")
            ->first();
    }

    public static function teamMembers($purchaseOrder, $approval_stage)
    {
        if ($approval_stage == 'bu_head') {
            return (new DepartmentService())->getMembers($purchaseOrder->employee->department_id);
        } else {
            return (new ApprovalTeamService())->getTeamMembers($approval_stage);
        }
    }

    public static function approvalId($data)
    {
        foreach ($data as $value) {
            if ($value['employee_id'] == auth()->user()->employee->id) {
                return $value['id'];
            }
        }
    }

    public static function approvalAccess($data)
    {
        foreach ($data as $value) {

            if ($value['employee_id'] == auth()->user()->employee->id && $value['status'] == 'pending') {
                return true;
            }
        }
        return false;
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

    public static function approvalUpdate($approval, $status = null, $description = null)
    {

        $approval->update([
            'status' => $status,
            'description' => $description,
            'status_date' => Carbon::now(),
        ]);
    }
}
