<?php

namespace App\Services;

use App\Models\ApprovalTeam;
use App\Models\CostCenter;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;


class EmployeeService
{
    protected $errorNotifier;
    protected $settingService;

    public $paginatedList = true;

    public function __construct()
    {
        $this->errorNotifier = new ErrorNotifierService();
        $this->settingService = new SettingService();
    }

    /**
     * Employees for select2 remote data options:
     */
    public function getRemoteDropdownList($data = null)
    {
        if ($data !== null ) {

            $query = Employee::select([
                "id",
                DB::raw(
                    "CONCAT(employees.first_name,' ',COALESCE(employees.middle_name,''),' ',COALESCE(employees.last_name,''),' ',employees.code) as name"
                )
            ])
                ->where('status', 1);
            $query->where(function ($q) use ($data) {
                $q->orWhere("first_name", "LIKE", "%" . $data . "%");
                $q->orWhere("middle_name", "LIKE", "%" . $data . "%");
                $q->orWhere("last_name", "LIKE", "%" . $data . "%");
                $q->orWhere("code", "=", $data . "%");
            });
            return $query->get('name', 'id')->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'text' => $tag->name,
                ];
            });
        }
    }

     /**
     * Employees for select2 preselected:
     */
    public function getPreSelectedList(array $ids)
    {
        return Employee::query()
            ->select([
                "id",
                DB::raw(
                    "CONCAT(employees.first_name,' ',COALESCE(employees.middle_name,''),' ',COALESCE(employees.last_name,''),' ',employees.code) as name"
                )
            ])->whereNull('deleted_at')
            ->whereIn('id', $ids)
            ->pluck('name', 'id');
    }

    /**
     * Employees for select options:
     */
    public function getDropdownList()
    {
        return Employee::query()
            ->select([
                "id",
                DB::raw(
                    "CONCAT(employees.first_name,' ',COALESCE(employees.middle_name,''),' ',COALESCE(employees.last_name,''),' ',employees.code) as name"
                )
            ])->whereNull('deleted_at')
            ->where('status', 1)
            ->pluck('name', 'id');
    }


    public function lists($data = null)
    {
        $search_query = [];

        $order = $this->settingService->get("data_order", "desc") ?? "desc";
        $departments_with_employee_count = Department::select('id', 'name')->withCount('employees')->get();
        $cost_centers_with_employee_count = CostCenter::select('id', 'name')->withCount('employees')->get();
        $query = Employee::query()->with(['department', 'designation', 'costCenter']);
        //exclude deleted and inactive employees
        $query->whereNull('deleted_at');
        $query->where('status', 1);

        if (isset($data["search"])) {
            $search_query = [
                "search" => $data["search"]
            ];
            $query->where(function ($q) use ($data) {
                $q->orWhere("first_name", "LIKE", "%" . $data["search"] . "%");
                $q->orWhere("middle_name", "LIKE", "%" . $data["search"] . "%");
                $q->orWhere("last_name", "LIKE", "%" . $data["search"] . "%");
                $q->orWhere("code", "LIKE", "%" .  $data["search"] . "%");
                $q->orWhereHas('department', function ($q) use ($data) {
                    $q->Where("name", "LIKE", "%" . $data["search"] . "%");
                });
                $q->orWhereHas('designation', function ($q) use ($data) {
                    $q->Where("name", "LIKE", "%" . $data["search"] . "%");
                });
                $q->orWhereHas('costCenter', function ($q) use ($data) {
                    $q->Where("name", "LIKE", "%" . $data["search"] . "%");
                });
            });
        }
        if (isset($data["department_id"])) {
            $query->where('department_id',$data["department_id"]);
            $search_query = [
                "department_id" => $data["department_id"]
            ];

        }
        if (isset($data["designation_id"])) {
            $query->where('designation_id',$data["designation_id"]);
            $search_query = [
                "designation_id" => $data["designation_id"]
            ];

        }
        if (isset($data["cost_center_id"])) {
            $query->where('cost_center_id',$data["cost_center_id"]);
            $search_query = [
                "cost_center_id" => $data["cost_center_id"]
            ];
        }

        $query->orderBy('id', $order);

        if ($this->paginatedList === true) {

            $item_per_page = $this->settingService->get("item_per_page", 25) ?? 25;

            $employees = $query->paginate($item_per_page)->appends($search_query);
            $employees->pagination_summary = get_pagination_summary($employees);
        } else {
            $employees = $query->get();
        }

        foreach($employees as $employee){
            foreach( $departments_with_employee_count as $department){
                if($employee->department_id == $department->id){
                    $employee->department_employee_count = $department->employees_count;
                }
            }

            foreach( $cost_centers_with_employee_count as $cost_center){
                if($employee->cost_center_id == $cost_center->id){
                    $employee->cost_center_employee_count = $cost_center->employees_count;
                }
            }
        }

        // dd($employees);
        return $employees;
    }

    public function updateOrCreate($data)
    {
        $user_id = auth()->user()->id;

        if (!empty($data["id"])) {
            // update

            $employee = Employee::whereId($data["id"])->first();
            $employee->updated_by = $user_id;
        } else {
            //create

            $employee = new Employee();
            $employee->created_by = $user_id;
        }


        if (isset($data['department_id'])) {
            $employee->department_id = $data['department_id'];
        }


        if (isset($data['designation_id'])) {
            $employee->designation_id = $data['designation_id'];
        }


        if (isset($data['cost_center_id'])) {
            $employee->cost_center_id = $data['cost_center_id'];
        }


        $employee->code = $data['code'];


        $employee->first_name = $data['first_name'];


        if (isset($data['middle_name'])) {
            $employee->middle_name = $data['middle_name'];
        }


        if (isset($data['last_name'])) {
            $employee->last_name = $data['last_name'];
        }


        if (isset($data['phone'])) {
            $employee->phone = $data['phone'];
        }


        if (isset($data['email'])) {
            $employee->email = $data['email'];
        }


        if (isset($data['profile_photo'])) {
            $employee->profile_photo = $data['profile_photo'];
        }


        $employee->status = $data['status'];


        return $employee->save() ? $employee : null;
    }

    public function getById($id)
    {
        return Employee::find($id);
    }
    public function getByUserId($id)
    {
        $employee = Employee::where('user_id',$id)->select('id')->first();

        return $employee->id ? $employee->id : null ;
    }

    public function delete($employee)
    {
        return $employee->delete();
    }

    public function getDropdown()
    {
        return Employee::query()
            ->where('status', 1)
            ->whereNull('deleted_at')
            ->select(
                'id',
                'first_name',
                'middle_name',
                'last_name',
                'department_id',
                'designation_id',
                'cost_center_id',
                'code',
                'user_id',
                'status',
                DB::raw("CONCAT(COALESCE(employees.first_name,''),' ',COALESCE(employees.middle_name,''),' ',COALESCE(employees.last_name,''),' ',employees.code) as code_name")
            )->get();
    }

    public function teamEmployee($employeeIds)
    {
        return Employee::query()
            ->select([
                "id",
                DB::raw(
                    "CONCAT(employees.first_name,' ',COALESCE(employees.middle_name,''),' ',COALESCE(employees.last_name,''),' ',employees.code) as name"
                )
            ])->whereNull('deleted_at')
            ->where('status', 1)
            ->whereIn('id',$employeeIds)
            ->pluck('name', 'id');
    }


}
