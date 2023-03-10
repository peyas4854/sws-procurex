<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function requisitionsDetail()
    {
        return $this->belongsToMany(RequisitionDetail::class)
            ->using(PurchaseOrderDetailRequisitionDetail::class)
            ->withTimestamps();
    }

    /**
     * Relation with Item
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Relation with Purchase Order
     */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    /**
     * Relation with UOM
     */
    public function uom(){
        return $this->belongsTo(uom::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function grn(){
        return $this->belongsTo(GoodsReceivableNote::class,'id','purchase_order_detail_id');
    }

}
