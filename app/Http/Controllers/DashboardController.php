<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee ?? null;
         return view('dashboard.user',compact('employee'));
    }
}
