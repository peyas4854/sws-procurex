<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Services\DepartmentService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use App\Http\Requests\Departments\SaveFormRequest;
use App\Http\Requests\Departments\UpdateFormRequest;
use Gate;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct()
    {
        $this->departmentService = new DepartmentService();
        // Initiate Permission
        $this->middleware('permission:department-list', ['only' => ['index']]);
        $this->middleware('permission:department-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:department-view', ['only' => ['show']]);
        $this->middleware('permission:department-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:department-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $departments = $this->departmentService->lists($data);

        $search = $request->search;

        return view("departments.list", compact(["departments", "search"]));
    }

    public function create()
    {

        return view("departments.create");
    }

    public function edit(Department $department)
    {


        $departmentHeadIds = $department->departmentHead->pluck('id')->toArray();
        $preSelectedHead= (new EmployeeService())->getPreSelectedList($departmentHeadIds);

        return view("departments.edit", compact([
            "department",
            'preSelectedHead',
            'departmentHeadIds'
        ]));
    }

    public function store(SaveFormRequest $request)
    {
        $validatedData = $request->validated();

        $department = $this->departmentService->updateOrCreate($validatedData);

        if (is_null($department) === false) {
            $message = message("Department has been successfully created.");
        } else {
            $message = message("Department has not created.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    public function update(UpdateFormRequest $request)
    {
        $validatedData = $request->validated();

        $department = $this->departmentService->updateOrCreate($validatedData);

        if (is_null($department) === false) {
            $message = message("Department has been successfully updated.");
        } else {
            $message = message("Department has not updated.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    public function show($id)
    {
        $department = $this->departmentService->getById($id);

        return view("departments.view", compact(["department"]));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        $department = $this->departmentService->getById($id);

        if ($department->employees()->exists()) {

            $message = message("Department cannot be deleted. Because, employees are assigned to it.", "error");

        } else {

            $response = $this->departmentService->delete($department);

            if ($response === true) {
                $message = message("Department has been successfully deleted.");
            } else {
                $message = message("Department has not deleted.", "error");
            }
        }

        session()->flash("message", $message);
        return redirect()->back();
    }
}
