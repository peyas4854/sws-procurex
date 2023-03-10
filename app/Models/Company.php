<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function costCenters()
    {
        return $this->belongsToMany(CostCenter::class,'companies_cost_centers',
            'company_id','cost_center_id');
    }


}
