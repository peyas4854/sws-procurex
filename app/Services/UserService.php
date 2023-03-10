<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $settingService;
    protected $errorNotifier;
    public $paginatedList = true;

    public function __construct()
    {
        $this->errorNotifier = new ErrorNotifierService();
        $this->settingService = new SettingService();
    }

    public function lists($data = null)
    {

        $query = User::query();

        $query->join("employees", function ($join) {
            $join->on("users.id", "=", "employees.user_id");
        });
        $query->orderBy('users.id', "ASC");

//        if (!auth()->user()->isHqAdmin()) {
//
//            if (isset(auth()->user()->employee->business_unit_id)) {
//
//                $query->where("employees.business_unit_id", auth()->user()->employee->business_unit_id);
//            }
//        }

        if (isset($data['role'])) {

            $query->role($data["role"]);
        }

        if (isset($data["employee_id"])) {

            $query->where("employees.id", $data["employee_id"]);
        }
        if (isset($data["type"])) {

            $query->where("type", $data["type"]);
        }

        $query->select(["users.*", \DB::raw("CONCAT(employees.first_name,' ',COALESCE(employees.middle_name,''),' ',COALESCE(employees.last_name,''),' ',COALESCE(employees.code,'')) as full_name"), "employees.user_id"]);

        if ($this->paginatedList === true) {

            $users = $query->paginate(30)->appends($data);

            $users->pagination_summary = get_pagination_summary($users);

        } else {

            $users = $query->get();
        }

        return $users;
    }
    public static function getById($id, $columns=null)
    {
        if(is_null($columns) === true || is_array($columns) === false){
            $columns = [
                "users.*"
            ];
        }
        $user = User::select($columns)->whereId($id)->first();
        return $user;
    }
    public function updateOrCreate($data)
    {
        if(!empty($data["id"])){
            // update
            $user = User::whereId($data["id"])->first();

        }else{
            //create
            $user = new User();
        }

        if(isset($data["type"]) && !is_null($data["type"])){

            $user->type = $data["type"];
        }

        if(isset($data["username"]) && !is_null($data["username"])){

            $user->username = $data["username"];

            $identity = $this->username($data["username"]);

            if($identity === "email"){

                $user->email = $data["username"];
            }
        }

        if(isset($data["user_email"]) || isset($data["email"])){

            $user->email = isset($data["user_email"]) ? $data["user_email"] : $data["email"] ;

        }


        if(isset($data["password"]) && !is_null($data["password"])){

            $user->password = bcrypt($data["password"]);

        }

        $user->active = isset($data["active"]) ? $data["active"] : 1;

        return $user->save() ? $user : null;
    }

    public function username($identity)
    {
        $field = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return $field;
    }

    public function assignMassRole($request)
    {
        foreach ($request->employee_id as $employee){
            $userId = Employee::query()->find($employee)->user_id;
            if($userId !=null){
                DB::table('model_has_roles')->where('model_id', $userId)->delete();
                $user = User::query()->find($userId);
                $user->assignRole($request->input('role'));
            }
        }
    }

    public function typeDropdown()
    {
        return User::query()->where('active',1)
        ->pluck('type','type')->unique();
    }
}
