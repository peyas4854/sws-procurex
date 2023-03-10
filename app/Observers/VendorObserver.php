<?php

namespace App\Observers;

use App\Models\Vendor;
use App\Services\AuditLogService;

class VendorObserver
{
    protected $auditLogService;

    public function __construct()
    {
        $this->auditLogService = new AuditLogService();
    }

    /**
     * Handle the Vendor "created" event.
     *
     * @param  \App\Vendor  $vendor
     * @return void
     */
    public function created(Vendor $vendor)
    {
        $this->auditLogService->add("create", $vendor);
    }

    /**
     * Handle the Vendor "updated" event.
     *
     * @param  \App\Vendor  $vendor
     * @return void
     */
    public function updated(Vendor $vendor)
    {
        if($vendor->isDirty() === true){

            $this->auditLogService->add("update", $vendor);
        }
    }

    /**
     * Handle the Vendor "deleted" event.
     *
     * @param  \App\Vendor  $vendor
     * @return void
     */
    public function deleted(Vendor $vendor)
    {
        $this->auditLogService->add("delete", $vendor);
    }

    /**
     * Handle the Vendor "restored" event.
     *
     * @param  \App\Vendor  $vendor
     * @return void
     */
    public function restored(Vendor $vendor)
    {
        //
    }

    /**
     * Handle the Vendor "force deleted" event.
     *
     * @param  \App\Vendor  $vendor
     * @return void
     */
    public function forceDeleted(Vendor $vendor)
    {
        //
    }
}
