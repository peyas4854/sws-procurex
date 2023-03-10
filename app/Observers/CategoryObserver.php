<?php

namespace App\Observers;

use App\Category;
use App\Services\AuditLogService;

class CategoryObserver
{
    protected $auditLogService;

    public function __construct()
    {
        $this->auditLogService = new AuditLogService();
    }

    /**
     * Handle the Category "created" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        $this->auditLogService->add("create", $category);
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        if($category->isDirty() === true){

            $this->auditLogService->add("update", $category);
        }
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        $this->auditLogService->add("delete", $category);
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}
