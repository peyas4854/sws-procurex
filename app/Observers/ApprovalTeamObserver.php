<?php

namespace App\Observers;

use App\ApprovalTeam;
use App\Services\AuditLogService;

class ApprovalTeamObserver
{
    protected $auditLogService;

    public function __construct()
    {
        $this->auditLogService = new AuditLogService();
    }

    /**
     * Handle the ApprovalTeam "created" event.
     *
     * @param  \App\ApprovalTeam  $approval_team
     * @return void
     */
    public function created(ApprovalTeam $approval_team)
    {
        $this->auditLogService->add("create", $approval_team);
    }

    /**
     * Handle the ApprovalTeam "updated" event.
     *
     * @param  \App\ApprovalTeam  $approval_team
     * @return void
     */
    public function updated(ApprovalTeam $approval_team)
    {
        if($approval_team->isDirty() === true){

            $this->auditLogService->add("update", $approval_team);
        }
    }

    /**
     * Handle the ApprovalTeam "deleted" event.
     *
     * @param  \App\ApprovalTeam  $approval_team
     * @return void
     */
    public function deleted(ApprovalTeam $approval_team)
    {
        $this->auditLogService->add("delete", $approval_team);
    }

    /**
     * Handle the ApprovalTeam "restored" event.
     *
     * @param  \App\ApprovalTeam  $approval_team
     * @return void
     */
    public function restored(ApprovalTeam $approval_team)
    {
        //
    }

    /**
     * Handle the ApprovalTeam "force deleted" event.
     *
     * @param  \App\ApprovalTeam  $approval_team
     * @return void
     */
    public function forceDeleted(ApprovalTeam $approval_team)
    {
        //
    }
}
