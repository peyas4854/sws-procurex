<?php

namespace App\Jobs;
use App\Models\CsDetailRequisition;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class OldCsPrInsertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;
    protected $csDetail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($csDetail)
    {
        $this->csDetail = $csDetail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        CsDetailRequisition::query()->firstOrCreate(
            [
                'cs_detail_id'=>$this->csDetail->id,
                'requisition_id'=>$this->csDetail->requisition_id,
            ],
            [
                'cs_detail_id'=>$this->csDetail->id,
                'requisition_id'=>$this->csDetail->requisition_id,
            ]
        );
    }
}
