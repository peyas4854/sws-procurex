<?php

namespace App\Models;

use App\Models\Category as ModelsCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes, HasFactory;

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category_id', 'id');
    }

    // return one level of child categories
    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    // recursive relationship
    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_category_id')->with('categories');
    }

    /**
     * Relationship: find items that belongs to this cagegory.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
