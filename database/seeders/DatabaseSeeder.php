<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Designation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(UserTableSeeder::class);
//         $this->call(SettingTableSeeder::class);
//         Category::factory(20)->create();
//         Designation::factory(20)->create();
//         $this->call(BrandTableSeeder::class);
         $this->call(PermissionSeeder::class);

    }
}
