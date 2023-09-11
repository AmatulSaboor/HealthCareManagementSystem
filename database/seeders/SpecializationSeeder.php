<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specializations')->insert([
            'name' => 'Cardiologist',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Orthopedic Surgeon',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Neurologist',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Ophthalmologist',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Oncologist',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Dermatologist',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Gastroenterologist',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Psychiatrist',
        ]);
        DB::table('specializations')->insert([
            'name' => 'Pediatrician',
        ]);
    }
}
