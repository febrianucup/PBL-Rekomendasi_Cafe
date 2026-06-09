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
        Type::create(['type_name'=>'Cafe & Bakkery']);
        Type::create(['type_name'=>'Coffee Shop']);
        Type::create(['type_name'=>'Kopi Specialty']);
        Type::create(['type_name'=>'Tea House']);
        Type::create(['type_name'=>'Dessert Cafe']);
        Type::create(['type_name'=>'Restaurant']);
    }
}
