<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'naka87003',
            'email' => 'naka87003@outlook.jp',
            'password' => Hash::make('Akkshi@76')
        ]);
    }
}
