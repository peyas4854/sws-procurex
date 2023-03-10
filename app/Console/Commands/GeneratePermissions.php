<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;

class GeneratePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Artisan::call("config:clear");
        Artisan::call("cache:clear");
        Artisan::call("permission:cache-reset");
        $features = config('features');
        foreach($features as $feature){
            foreach($feature['actions'] as $action){
                Permission::findOrCreate($action);
            }
        }
        $this->info("Permissions successfully generated!");
        return 0;
    }
}
