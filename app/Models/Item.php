<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];



    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function category_item()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function uom()
    {
        return $this->belongsTo(uom::class, 'uom_id');
    }

    /**
     * Relationship: find items that belongs to this PR.
     * Note: Used to restrict deletion of items that are associated with PR.
     */
    public function requisitions()
    {
        return $this->belongsToMany(Requisition::class, 'requisition_details', 'item_id', 'requisition_id');
    }

}
