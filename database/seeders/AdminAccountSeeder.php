<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'adminku@gmail.com'],
            ['role_id' => 1, 'password' => bcrypt('123456789'), 'status' => 'active', 'username' => 'adminganteng']
        );
    }
}
