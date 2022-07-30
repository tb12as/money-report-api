<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::where('username', 'syafiq')->exists()) {
            die();
        }
        User::create([
            'name' => 'Syafiq Afifuddin',
            'username' => 'syafiq',
            'password' => bcrypt('1234'),
            'api_token' => base64_encode(Str::random(40)),
        ]);
    }
}
