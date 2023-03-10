<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PurchaseOrderDetailRequisitionDetail extends Pivot
{
    use HasFactory;
    protected $table = 'purchase_order_detail_requisition_detail';


}
