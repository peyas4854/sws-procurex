<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovalTeam extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'created_by', 'employee_ids'];

    /**
     * Relation setup: Inverse of One to Many with User
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function employees()
    {
        return Employee::whereIn('id', json_decode($this->employee_ids))->get();
    }

    public function scopeTeam($query,$team)
    {
        return $query->where('name',$team)->exists();
    }



}
