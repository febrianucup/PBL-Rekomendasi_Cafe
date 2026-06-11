<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Type::firstOrCreate(['type_name'=>'Cafe & Bakkery']);
        Type::firstOrCreate(['type_name'=>'Coffee Shop']);
        Type::firstOrCreate(['type_name'=>'Kopi Specialty']);
        Type::firstOrCreate(['type_name'=>'Tea House']);
        Type::firstOrCreate(['type_name'=>'Dessert Cafe']);
        Type::firstOrCreate(['type_name'=>'Restaurant']);
    }
}
