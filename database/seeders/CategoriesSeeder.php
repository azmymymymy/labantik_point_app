<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('p_categories')->insert([
            ['name' => 'Ringan'],
            ['name' => 'Sedang'],
            ['name' => 'Berat'],
        ]);
    }
}
