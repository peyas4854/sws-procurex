<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CostCenter;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Setting;
use App\Models\User;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;


class LoginWithHrmController extends Controller
{
    protected $domain;

    public function __construct()
    {
        $this->settingService = new SettingService();
        $this->domain = $this->settingService->get("domain_api") ?? null;
    }

    public function showLoginForm()
    {
        return view('auth.hrmLogin');
    }

    public function login(Request $request)
    {
        $response = self::authenticate($request);
//        dd($response);


        if ($response == null) {
            session()->flash("message", 'Please add domain api');
            return redirect()->back();
        }
        if ($response->status == 'error') {
            session()->flash("message", $response->message);
            return redirect()->back();
        }
        if ($response->status == 'success') {

            return self::authenticateSuccess($request, $response);
        }

    }

    public function authenticate($request)
    {

        if (!isset($this->domain) && $this->domain == null) {
            return;
        }
        $url = $this->domain . '/api/v1/login';


        $response = Http::post($url, [
            'username' => $request->username,
            'password' => $request->password,
        ]);
        return json_decode($response->body());

    }

    public function authenticateSuccess($request, $response)
    {
        $findUser = User::query()
            ->where(function($query) use($request,$response){
                $query->orWhere('username', $request->username)
                      ->orWhere('email', $request->username)
                      ->orWhere('remote_user_id', $response->data->user_id);
            })
            ->where('active', 1)
            ->first();
        if (!$findUser) {
            $user = $this->createUser($request, $response);
            $url = $this->domain . '/api/v1/employee/profile';
            $data = Http::withToken($response->data->access_token)->get($url);
            $employee = json_decode($data->body())->data;
            $department = Department::query()->where('name', $employee->department_name)->first();
            $designation = Designation::query()->where('name', $employee->designation_name)->first();
            $cost_center = CostCenter::query()->where('name', $employee->cost_center_name)->first();
            Employee::updateOrCreate(
                [
                    'code' => $employee->code
                ],
                [
                    'first_name' => $employee->first_name ?? null,
                    'middle_name' => $employee->middle_name ?? null,
                    'last_name' => $employee->last_name ?? null,
                    'code' => $employee->code,
                    'phone' => $employee->phone ?? null,
                    'email' => $employee->email ?? null,
                    'remote_employee_id' => $employee->id,
                    'user_id' => $user->id,
                    'created_by' => 1,
                    'department_id' =>  $department ? $department->id : null,
                    'designation_id' =>  $designation ? $designation->id : null,
                    'cost_center_id' =>  $cost_center ? $cost_center->id : null,
                ]);
            $findUser = $user;
        }
        Auth::login($findUser);
        return redirect()->route('home');
    }

    public function createUser($request, $response)
    {

        return User::create([
            'username' => $response->data->username,
            'password' => Hash::make($request->password),
            'remote_user_id' => $response->data->user_id,
            'active'=>1,
        ]);
    }
}
