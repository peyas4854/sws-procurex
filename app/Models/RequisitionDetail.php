<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequisitionDetail extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function uom()
    {
        return $this->belongsTo(uom::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

}
