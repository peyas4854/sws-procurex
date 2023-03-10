<?php

namespace App\Console\Commands;

use App\Models\Employee;
use Illuminate\Console\Command;
use App\Jobs\UserEmailInsertJob;
use Illuminate\Support\Facades\Log;

class UserEmailField extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:sync-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User null email filled by employee email';

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
        Log::info("user:sync-email started at: " .date("Y-m-d H:i:s")); 
        $count = 0;
        Employee::query()->where('status',1)->whereNotNull('email')->whereHas('user', function ($q) {
            $q->WhereNull('email');
        })->select('id', 'email', 'user_id')
            ->chunk(500, function ($employees, $count) {
                foreach ($employees as $employee) {
                    echo 'user_id: '.$employee->user_id . "\n";
                    $count++;
                    dispatch(new UserEmailInsertJob($employee));
                }
            });
        
            
        Log::info("user:sync-email ended at: " .date("Y-m-d H:i:s")." | Processed: ".$count );

    }
}
