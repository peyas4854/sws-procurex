<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;

    protected $guarded= [];


    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'created_by','id');
    }


    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'updated_by','id');
    }

    /**
     * Relationship: Polymorphic One to Many with Contact.
     * Get all the Vendor's contacts.
     */
    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }
}
