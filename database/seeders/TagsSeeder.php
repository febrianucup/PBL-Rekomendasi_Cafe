<?php

namespace Database\Seeders;

use App\Models\Tags;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tags::create(['tag_name' => 'quite']);
        Tags::create(['tag_name' => 'wifi']);
        Tags::create(['tag_name' => 'social']);
        Tags::create(['tag_name' => 'promo']);
    }
}
