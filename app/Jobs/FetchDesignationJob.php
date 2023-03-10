<?php

namespace App\Jobs;

use App\Models\Designation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchDesignationJob implements ShouldQueue
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
//echo $this->response['name'];
        $designation  = Designation::query()->updateOrCreate(
            ['name' => $this->response['name'], 'remote_designation_id' => $this->response['id']],
            [
                'name' => $this->response['name'],
                'detail' => $this->response['detail'] ?? null,
                'remote_designation_id' => $this->response['id'],
                'created_by' => 1
            ],
        );
        echo $designation->name. ' added designation'."\n";
    }
}
