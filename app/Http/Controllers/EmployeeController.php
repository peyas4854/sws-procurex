<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\SaveFormRequest;
use App\Http\Requests\Employee\UpdateFormRequest;
use App\Models\Employee;
use App\Services\CostCenterService;
use App\Services\DepartmentService;
use App\Services\DesignationService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct()
    {
        $this->employeeService = new EmployeeService();
        // Initiate Permission
        $this->middleware('permission:employee-list', ['only' => ['index']]);
        $this->middleware('permission:employee-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:employee-view', ['only' => ['show']]);
        $this->middleware('permission:employee-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:employee-delete', ['only' => ['destroy']]);
    }

    /**
     * Employees for select2 remote data options:
     */
    public function selectApprovalTeam(Request $request)
    {
        return $this->employeeService->getRemoteDropdownList($request->q);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $employees = $this->employeeService->lists($data);
        $department = (new DepartmentService())->getDropdownList();
        $designation = (new DesignationService())->getDropdownList();
        $costCenter = (new CostCenterService())->getDropdownList();
        return view("employee.list", compact([
            "employees",
            'department',
            'designation',
            'costCenter',
            'request'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $costCenter = (new CostCenterService())->getDropdownList();
        $department = (new DepartmentService())->getDropdownList();
        $designation = (new DesignationService())->getDropdownList();
        return view("employee.create", compact('costCenter', 'department', 'designation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveFormRequest $request)
    {

        $validatedData = $request->validated();

        $employee = $this->employeeService->updateOrCreate($validatedData);

        if (is_null($employee) === false) {
            $message = message("Employee has been successfully created.");
        } else {
            $message = message("Employee has not created.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {

        return view('employee.view', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $costCenter = (new CostCenterService())->getDropdownList();
        $department = (new DepartmentService())->getDropdownList();
        $designation = (new DesignationService())->getDropdownList();
        return view("employee.edit", compact("employee", 'costCenter', 'department', 'designation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormRequest $request)
    {

        $employee = $this->employeeService->updateOrCreate($request);

        if (is_null($employee) === false) {
            $message = message("Employee has been successfully updated.");
        } else {
            $message = message("Employee has not updated.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $response = $this->employeeService->delete($employee);

        if ($response === true) {
            $message = message("Employee has been successfully deleted.");
        } else {
            $message = message("Employee has not deleted.", "error");
        }

        session()->flash("message", $message);
        return redirect()->back();
    }
}
