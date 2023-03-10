<?php

namespace App\Jobs;

use App\Models\CostCenter;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchEmployeeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $response;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $departmentId = self::department($this->response['department_id']);
        $designationId = self::designation($this->response['designation_id']);
        $costCenterId = self::costCenter($this->response['cost_center_id']);

        Employee::updateOrCreate(
            [
                'code' => $this->response['code']
            ],
            [
                'first_name' => $this->response['first_name'] ?? null,
                'middle_name' => $this->response['middle_name'] ?? null,
                'last_name' => $this->response['last_name'] ?? null,
                'department_id' => $departmentId,
                'designation_id' => $designationId,
                'cost_center_id' => $costCenterId,
                'email' => $this->response['email'] ?? null,
                'phone' => $this->response['phone'] ?? null,
                'code' => $this->response['code'],
                'remote_employee_id' => $this->response['id'],
                'status' => $this->response['status'],
                'created_by' => 1
            ],
        );

    }

    public function department($departmentId)
    {
        $department = Department::query()->where('remote_department_id', $departmentId)->first();
        return $department ? $department->id : null;

    }

    public function designation($designationId)
    {
        $designation = Designation::query()->where('remote_designation_id', $designationId)->first();
        return $designation ? $designation->id : null;
    }

    public function costCenter($costCenterId)
    {
        $costCenter = CostCenter::query()->where('remote_cost_center_id', $costCenterId)->first();
        return $costCenter ? $costCenter->id : null;
    }


}
