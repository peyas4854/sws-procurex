<?php

namespace App\Console\Commands;

use App\Models\CsDetail;
use App\Models\CsDetailRequisition;
use Illuminate\Console\Command;

class CsRequisitionInsert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cs:requisition';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert cs requisition pivot table data from cs detail table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $csDetails = CsDetail::query()->whereNotNull('requisition_id')->get();
        foreach($csDetails as $csDetail){
            CsDetailRequisition::query()->create([
               'cs_detail_id'=>$csDetail->id,
               'requisition_id'=>$csDetail->requisition_id
            ]);
        }
    }
}
