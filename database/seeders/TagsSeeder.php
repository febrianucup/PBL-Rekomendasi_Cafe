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
        Tags::firstOrCreate(['tag_name' => 'quite']);
        Tags::firstOrCreate(['tag_name' => 'wifi']);
        Tags::firstOrCreate(['tag_name' => 'social']);
        Tags::firstOrCreate(['tag_name' => 'promo']);
    }
}
