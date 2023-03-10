<?php

namespace App\Observers;

use App\Models\Department;
use App\Services\AuditLogService;

class DepartmentObserver
{
    protected $auditLogService;

    public function __construct()
    {
        // $this->auditLogService = new AuditLogService();
    }

    /**
     * Handle the Department "created" event.
     *
     * @param  \App\Department  $department
     * @return void
     */
    public function created(Department $department)
    {
        $this->auditLogService->add("create", $department);
    }

    /**
     * Handle the Department "updated" event.
     *
     * @param  \App\Department  $department
     * @return void
     */
    public function updated(Department $department)
    {
        if($department->isDirty() === true){

            $this->auditLogService->add("update", $department);
        }
    }

    /**
     * Handle the Department "deleted" event.
     *
     * @param  \App\Department  $department
     * @return void
     */
    public function deleted(Department $department)
    {
        $this->auditLogService->add("delete", $department);
    }

    /**
     * Handle the Department "restored" event.
     *
     * @param  \App\Department  $department
     * @return void
     */
    public function restored(Department $department)
    {
        //
    }

    /**
     * Handle the Department "force deleted" event.
     *
     * @param  \App\Department  $department
     * @return void
     */
    public function forceDeleted(Department $department)
    {
        //
    }
}
