<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('qwe'),
                'role' => 'SA',
                'department' => 'IT',
                'team' => 'ITPM2',
                'region' => 'VIS',
            ],
            [
                'name' => 'Justine',
                'email' => 'justine@gmail.com',
                'password' => Hash::make('qwe'),
                'role' => 'USER',
                'department' => 'IT',
                'team' => 'ITPM1',
                'region' => 'VIS',
            ],
            [
                'name' => 'Jeff Mahinay',
                'email' => 'jeffmahinay@gmail.com',
                'password' => Hash::make('qwe'),
                'role' => 'USER',
                'department' => 'IT',
                'team' => 'INFRA',
                'region' => 'VIS',
            ],
        ]);
    }
}
