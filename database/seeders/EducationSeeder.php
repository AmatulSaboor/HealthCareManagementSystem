<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('educations')->insert([
            'name' => 'MBBS',
        ]);
        DB::table('educations')->insert([
            'name' => 'FRCPs',
        ]);
        DB::table('educations')->insert([
            'name' => 'PhD',
        ]);
        DB::table('educations')->insert([
            'name' => 'Surgeon',
        ]);
    }
}
