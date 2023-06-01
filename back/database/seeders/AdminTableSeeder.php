<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('admins')->insert([
            'first_name' => 'David',
            'last_name' => 'John',
            'age' => 36,
            'profile_image' => 'dfdghj',
            'email' => 'david@gmail.com',
            'password' => Hash::make('password')
        ]);
    }
}
