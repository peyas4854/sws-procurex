<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class uom extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded =[];

    /**
     * Relationship: find items that belongs to this UoM.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
