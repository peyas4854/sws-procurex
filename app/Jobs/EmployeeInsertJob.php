<?php

namespace App\Jobs;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EmployeeInsertJob implements ShouldQueue
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
//        Employee::query()->create(
//            [
//                'first_name' => $this->response['first_name'] ?? null,
//                'middle_name' => $this->response['middle_name'] ?? null,
//                'last_name' => $this->response['last_name'] ?? null,
//                'department_id' => $departmentId,
//                'designation_id' => $designationId,
//                'cost_center_id' => $costCenterId,
//                'email' => $this->response['email'],
//                'code' => $this->response['code'],
//                'remote_employee_id' => $this->response['id'],
//                'status' => $this->response['status'],
//                'created_by' => 1
//            ],
//        );
    }
}
