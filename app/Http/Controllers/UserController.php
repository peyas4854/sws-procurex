<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\EmployeeService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Requests\User\UpdateFormRequest;


class UserController extends Controller
{
    protected $userService, $employeeService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->employeeService = new EmployeeService();
        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['massRole', 'massRoleAssign']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);

    }

    public function index(Request $request)
    {
        $data = $request->all();

        $users = $this->userService->lists($data);
        $types = $this->userService->typeDropdown();

        $search = $request->search;
        $employee = $this->employeeService->getDropdownList();

        $roles = Role::pluck('name', 'name')->all();

        return view("users.list", compact([
            "users",
            "search",
            "roles",
            'employee',
            'types',
            'request'
        ]));
    }

    public function edit($id)
    {
        $user = $this->userService->getById($id);
        $employees = $this->employeeService->getDropdownList();
        $employeeId = $this->employeeService->getByUserId($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view("users.edit", compact(['roles', 'userRole', "user", "employees", "employeeId"]));
    }

    public function update(UpdateFormRequest $request)
    {

        $user = $this->userService->updateOrCreate($request);

        if (auth()->user()->isHqAdmin()) {
            DB::table('model_has_roles')->where('model_id', $request->id)->delete();
            $user->assignRole($request->input('roles'));
        }
        Employee::query()->find($request->employee_id)->update([
            'user_id' => $user->id,
        ]);

        return redirect('/users')->with("message", message("User updated successfully"));
    }

    public function massRole(Request $request)
    {

        $data = $request->all();

        $users = $this->userService->lists($data);

        $search = $request->search;
        $employee = $this->employeeService->getDropdownList();

        $roles = Role::pluck('name', 'name')->all();

        return view("users.mass-user", compact(["users", "search", "roles", 'employee']));
    }

    public function massRoleAssign(Request $request)
    {
        $this->userService->assignMassRole($request);
        $message = message("Role updated successfully.");
        session()->flash("message", $message);
        return redirect()->back();

    }

}
