<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('genders')->insert([
            ['id' => 0, 'gender' => 'male'],
            ['id' => 1, 'gender' => 'female'],
        ]);
    }
}
