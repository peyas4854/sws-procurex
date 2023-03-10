<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Requisition extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function costcenter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requisitionDetails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RequisitionDetail::class);
    }

    public function approval_team()
    {
        return $this->morphMany(Approval::class, 'approvalable');
    }

    public function approval()
    {
        return $this->morphMany(Approval::class, 'approvalable')->orderBy('id', 'Desc');
    }

    public function approvalAccess()
    {
        return $this->morphMany(Approval::class, 'approvalable')
            ->where('status', 'pending');
    }

    public function costCenterHead()
    {
        return $this->belongsTo(CostCenterHead::class, 'cost_center_id')->where('order', 1);
    }

    /**
     * Relationship: find items that belongs to this PR.
     * Note: This relation can be used to bring in all items of this PR. Adding withPivot() method
     * will bring in all other columns that are necessary. RequisitionDetail model is redundant in
     * this respect.
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'requisition_details', 'requisition_id', 'item_id');
    }

    public function csDetail()
    {
        return $this->hasMany(CsDetail::class, 'requisition_id', 'id');
    }

    public function purchaseOrderRequisition()
    {
        return $this->belongsToMany(PurchaseOrder::class,'purchase_order_requisition',
            'requisition_id','purchase_order_id');

    }

    public function csDetailRequisition()
    {
        return $this->belongsToMany(CsDetail::class,'cs_detail_requisition',
            'requisition_id','cs_detail_id')->withTimestamps();

    }




}
