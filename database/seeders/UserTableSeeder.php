<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::create([
            'email' => 'admin@demo.com',
            'username'=>'useradmin',
            'password' => Hash::make('password'),
        ]);
        // Note: Enter some other users:
        User::factory(10)->create();
    }
}
