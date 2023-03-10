<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Approval extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function approvalable()
    {
        return $this->morphTo();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id','id');
    }

}
