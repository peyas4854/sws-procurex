<?php

namespace App\Jobs;

use App\Models\Department;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchDepartment implements ShouldQueue
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

        $department  = Department::query()->updateOrCreate(
            ['name' => $this->response['name'], 'remote_department_id'=>$this->response['id']],
            [
                'name' => $this->response['name'],
                'detail' => $this->response['detail'] ?? null,
                'created_by' => 1,
                'remote_department_id'=>$this->response['id']

            ],
        );
        echo $department->name. ' added department'."\n";

    }
}
