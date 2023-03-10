<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostCenter extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded=[];

    /**
     * Relationship: Many to Many with Employee as BU Heads
     * Employees who belong to CostCenter
     */
    public function buHeads()
    {
        return $this->belongsToMany(Employee::class, 'cost_center_heads');

    }

    /**
     * Relationship: find requisitions that belongs to this cost center.
     */
    public function requisitions()
    {
        return $this->hasMany(Requisition::class);
    }

    /**
     * Get the employees for the cost center.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function company()
    {
        return $this->belongsToMany(Company::class,'companies_cost_centers',
        'cost_center_id','company_id');
    }

    public function financeApprover()
    {
        return $this->belongsToMany(Employee::class, 'cost_center_finances')->withTimestamps();
    }
}
