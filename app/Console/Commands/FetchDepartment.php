<?php

namespace App\Console\Commands;

use App\Services\SettingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchDepartment extends Command
{
    protected $domain;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:department';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Department data from api';

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
        $url = $this->domain . '/api/v1/departments';

        $response = Http::get($url);
        if ($response['status'] == 'success') {
            foreach ($response['data'] as $data){
                dispatch(new \App\Jobs\FetchDepartment($data));
            }
        }

    }
}
