<?php

namespace App\Console\Commands;

use App\Services\SettingService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchCostCenter extends Command
{
    protected $domain;
    protected $settingService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:costcenter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch CostCenter From Api';

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
        $url = $this->domain . '/api/v1/cost-centers';
//        echo $url ."\n";
        $response = Http::get($url);
        if ($response['status'] == 'success') {
            foreach ($response['data'] as $data){
                dispatch(new \App\Jobs\FetchCostCenterJob($data));
            }
        }
    }
}
