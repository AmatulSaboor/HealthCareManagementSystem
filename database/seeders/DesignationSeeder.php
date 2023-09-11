<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('designations')->insert([
            'name' => 'Associate Professor',
        ]);
        DB::table('designations')->insert([
            'name' => 'Medical Director',
        ]);
        DB::table('designations')->insert([
            'name' => 'Assistant Professor',
        ]);
        DB::table('designations')->insert([
            'name' => 'Chief Medical Officer',
        ]);
        DB::table('designations')->insert([
            'name' => 'Chief Surgeon',
        ]);
        DB::table('designations')->insert([
            'name' => 'Clinical Instructor',
        ]);
        DB::table('designations')->insert([
            'name' => 'Resident Physician',
        ]);
        DB::table('designations')->insert([
            'name' => 'Senior Consultant',
        ]);
    }
}
