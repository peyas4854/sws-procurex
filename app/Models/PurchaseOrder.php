<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function costcenter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CostCenter::class,'cost_center_id');
    }

    public function csDetails()
    {
        return $this->belongsToMany(CsDetail::class)
            ->using(CsDetailPurchaseOrder::class)
            ->withTimestamps();
    }

    public function requisitions()
    {
        return $this->belongsToMany(Requisition::class)
            ->using(PurchaseOrderRequisition::class)
            ->withTimestamps();
    }
    public function approval()
    {
        return $this->morphMany(Approval::class, 'approvalable');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function purchaseOrderDetail(){

        return $this->hasMany(PurchaseOrderDetail::class,'purchase_order_id','id');
    }

    public function approvalAccess()
    {
        return $this->morphMany(Approval::class, 'approvalable')
            ->where('status', 'pending');
    }



}
