<?php

namespace App\Console\Commands;
use App\Jobs\OldCsPrInsertJob;
use App\Models\CsDetail;
use Illuminate\Console\Command;

class OldCsPrRelationInsert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cs:pr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Old Cs and Pr relation insert';

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
        $csDetails = CsDetail::query()->whereNotNull('requisition_id')
            ->select('id', 'requisition_id')
            ->get();
        foreach ($csDetails as $csDetail) {
            OldCsPrInsertJob::dispatch($csDetail);
        }
    }
}
