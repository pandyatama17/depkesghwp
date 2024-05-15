<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class usersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // Seed a sample user
       DB::table('users')->insert([
            'name' => 'Admin Registrasi',
            'email' => 'admin@reggakeslab.com',
            'password' => Hash::make('r4hAs1@'),
        ]);

    // You can add more users as needed
    }
}
