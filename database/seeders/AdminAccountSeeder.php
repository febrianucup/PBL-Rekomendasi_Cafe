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
        User::create(['role_id'=>1, 'email'=>'adminku@gmail.com', 'password'=>'123456789', 'status'=>'active', 'username'=>'adminganteng']);
    }
}
