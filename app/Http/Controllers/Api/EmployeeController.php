<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function getEmployee()
    {
        $employees = (new EmployeeService())->getDropdown();
        return response()->json($employees);


    }
}
