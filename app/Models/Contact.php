<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'contact_person',
        'contact_email',
        'contact_phone',
        'position',
        'is_default',
    ];

    /**
     * Relation: Polymorphic One to Many
     * Get the parent contactable model (vendor or other).
     */
    public function contactable()
    {
        return $this->morphTo();
    }
}
