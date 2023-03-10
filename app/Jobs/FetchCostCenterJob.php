<?php

namespace App\Jobs;

use App\Models\CostCenter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchCostCenterJob implements ShouldQueue
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
        $costCenter = CostCenter::query()->updateOrCreate(
            ['name' => $this->response['name'], 'remote_cost_center_id'=>$this->response['id']],
            [
                'name' => $this->response['name'],
                'cost_center_code' => $this->response['cost_center_code'] ?? null,
                'description' => $this->response['description'] ?? null,
                'created_by' => 1,
                'remote_cost_center_id'=>$this->response['id']
            ],
        );
        echo $costCenter->name . ' added cost center'."\n";
    }
}
