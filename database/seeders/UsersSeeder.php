<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('admin123$'),
        //     'role_id' => 1
        // ]);
        DB::table('users')->insert([
            'name' => 'doctor',
            'email' => 'doctor@gmail.com',
            'password' => Hash::make('doctor123$'),
            'role_id' => 1
        ]);
    }
}
