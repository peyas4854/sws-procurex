<?php

namespace App\Observers;

use App\Models\Designation;
use App\Services\AuditLogService;

class DesignationObserver
{
    protected $auditLogService;

    public function __construct()
    {
        $this->auditLogService = new AuditLogService();
    }

    /**
     * Handle the Designation "created" event.
     *
     * @param  \App\Designation  $designation
     * @return void
     */
    public function created(Designation $designation)
    {
        $this->auditLogService->add("create", $designation);
    }

    /**
     * Handle the Designation "updated" event.
     *
     * @param  \App\Designation  $designation
     * @return void
     */
    public function updated(Designation $designation)
    {
        if($designation->isDirty() === true){

            $this->auditLogService->add("update", $designation);
        }
    }

    /**
     * Handle the Designation "deleted" event.
     *
     * @param  \App\Designation  $designation
     * @return void
     */
    public function deleted(Designation $designation)
    {
        $this->auditLogService->add("delete", $designation);
    }

    /**
     * Handle the Designation "restored" event.
     *
     * @param  \App\Designation  $designation
     * @return void
     */
    public function restored(Designation $designation)
    {
        //
    }

    /**
     * Handle the Designation "force deleted" event.
     *
     * @param  \App\Designation  $designation
     * @return void
     */
    public function forceDeleted(Designation $designation)
    {
        //
    }
}
