<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CsDetailPurchaseOrder extends Pivot
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'cs_detail_purchase_order';

}
