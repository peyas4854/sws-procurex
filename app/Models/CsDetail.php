<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CsDetail extends Model implements HasMedia
{
    use HasFactory, SoftDeletes,InteractsWithMedia;

    protected $guarded = [];

    public function approval()
    {
        return $this->morphMany(Approval::class, 'approvalable');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class,'requester_employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function costcenter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CostCenter::class,'cost_center_id');
    }

    public function csDetailPurchaseOrder()
    {
        return $this->belongsToMany(PurchaseOrder::class,'cs_detail_purchase_order',
        'cs_detail_id','purchase_order_id')->withTimestamps();
    }
    public function csDetailRequisition()
    {
        return $this->belongsToMany(Requisition::class,'cs_detail_requisition',
        'cs_detail_id','requisition_id')->withTimestamps();

    }


}
