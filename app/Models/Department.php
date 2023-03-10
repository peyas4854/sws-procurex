<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $guarded=[];

    /**
     * @return User or Null
     */
    public function createdBy()
    {
        return User::find($this->created_by);
    }

    /**
     * @return User or Null
     */
    public function updatedBy()
    {
        return User::find($this->updated_by);
    }

    /**
     * Relationship: find employees that belong to this department.
     */
    public function employees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function departmentHead()
    {
        return $this->belongsToMany(Employee::class, 'department_heads',
            'department_id',
            'employee_id')->withTimestamps();

    }
}
