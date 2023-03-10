<?php

namespace App\Console\Commands;

use App\Jobs\EmployeeInsertJob;
use App\Services\SettingService;
use Illuminate\Console\Command;

class EmployeeInsert extends Command
{
    protected $domain;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employee:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Employee data insert from api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->settingService = new SettingService();
        $this->domain = $this->settingService->get("domain_api") ?? null;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = $this->domain . '/api/v1/procurex-employees?active=1';
        $response = Http::get($url);
        if ($response['status'] == 'success') {
            foreach ($response['data'] as $data){

                dispatch(new EmployeeInsertJob($data));
            }
        }

    }
}
