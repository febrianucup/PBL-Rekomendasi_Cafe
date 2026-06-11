<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            TypeSeeder::class,
            TagsSeeder::class,
            AdminAccountSeeder::class,
            CafeDataSeeder::class,
        ]);

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['username' => 'Test User', 'role_id' => 1]
        );
    }
}
