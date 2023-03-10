<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    /**
     * Relationship: find items that belongs to this brand.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
