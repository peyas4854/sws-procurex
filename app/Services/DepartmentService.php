<?php

namespace App\Services;

use App\Models\Department;
use App\Models\DepartmentHead;
use App\Services\ErrorNotifierService;
use App\Services\SettingService;

class DepartmentService
{
    protected $errorNotifier;
    protected $settingService;

    public $paginatedList = true;

    public function __construct()
    {

        $this->settingService = new SettingService();
    }
    public function getDropdownList()
    {
        return Department::pluck('name', 'id');
    }
    public function lists($data = null)
    {
        $search_query = [];

        $order = $this->settingService->get("data_order", "desc") ?? "desc";

        $query = Department::query()->withCount(['employees']);

        if(isset($data["search"])){

            $search_query = [
                "search" => $data["search"]
            ];

            $query->where(function($q) use($data){
                $q->orWhere("name", "LIKE", "%".$data["search"]."%");
            });
        }

        $query->orderBy('id', $order);

        if ($this->paginatedList === true) {

            $item_per_page = $this->settingService->get("item_per_page", 25) ?? 25;

            $departments = $query->paginate($item_per_page)->appends($search_query);
            $departments->pagination_summary = get_pagination_summary($departments);
        } else {
            $departments = $query->get();
        }

        return $departments;
    }

    public function updateOrCreate($data)
    {
        $user_id = auth()->user()->id;

        if(!empty($data["id"])){
            // update

            $department = Department::whereId($data["id"])->first();
            $department->updated_by = $user_id;

        }else{
            //create

            $department = new Department();
            $department->created_by = $user_id;
        }
        if(isset($data['name'])){
            $department->name = $data['name'];
        }


        if(isset($data['detail'])){
            $department->detail = $data['detail'];
        }

        $department->save();


        if (isset($data['employee_ids'])) {
            $department->departmentHead()->sync($data['employee_ids']);
        }else{
            $department->departmentHead()->detach();
        }


        return  $department;
    }

    public function getById($id)
    {
        return Department::find($id);
    }

    public function delete($department)
    {
        return $department->delete();
    }

    public function getDepartment(){
       return  Department::query()->whereNull('deleted_at')
           ->select('id','name')
           ->get();
    }
    public function getMembers($department_id)
    {
        return DepartmentHead::query()
            ->where('department_id', $department_id)
            ->pluck('employee_id')->toArray();
    }
}
