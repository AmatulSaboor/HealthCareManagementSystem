<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'role_name' => 'admin',
        ]);
        DB::table('roles')->insert([
            'role_name' => 'doctor',
        ]);
        DB::table('roles')->insert([
            'role_name' => 'patient',
        ]);
    }
}
