<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function getNameCodeAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name} {$this->code}";
    }

    public function getFullNameCodeAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name} ($this->code)";
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    /**
     * Relationship: Many to Many with CostCenter
     * CostCenters that belong to this Employee
     */
    public function costCenters()
    {
        return $this->belongsToMany(CostCenter::class, 'cost_center_heads')
            ->withPivot('order', 'remarks');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the requisitions of the employee.
     */
    public function requisitions()
    {
        return $this->hasMany(Requisition::class);
    }



}
