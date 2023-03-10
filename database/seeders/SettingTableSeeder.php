<?php

namespace Database\Seeders;

use App\Services\SettingService;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    protected $settings = [
        "data_order" => "asc",
        "item_per_page" => "25",
        "date_format" => "Y-m-d",
        "salary_processor_base" => "basic",
        "email_notifications" => "off",
        "auto_logoff_time_in_minutes" => "2"
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->settings as $key => $value) {
            SettingService::updateOrCreate($key, $value);
        }

    }
}
