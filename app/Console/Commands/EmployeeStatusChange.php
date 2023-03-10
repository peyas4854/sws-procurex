<?php

namespace App\Console\Commands;

use App\Jobs\EmployeeStatusChangeJob;
use App\Services\SettingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class EmployeeStatusChange extends Command
{
    protected $domain;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employeestatus:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change employee status based on api data';

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
                dispatch(new EmployeeStatusChangeJob($data));
            }
        }
    }
}
