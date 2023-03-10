<?php

namespace App\Jobs;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResignedEmployeeDisableJob implements ShouldQueue
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
        $employee = Employee::query()->where('code', $this->response['code'])
            ->firstOrFail();
        $employee->update([
            'status' => 0
        ]);
        if($employee->user_id ){
            $user = User::query()->find($employee->user_id);
            $user->update([
                'active'=> 0
            ]);
            echo $user->id . ' user--id ' . "\n";
            echo $user->active . ' user--status ' . "\n";
        }
        echo $employee->id . ' employee_id ' . "\n";

    }
}
