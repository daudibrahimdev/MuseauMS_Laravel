<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        \App\Models\User::create([
            'name' => 'Daud Ibrahim',
            'email' => 'daud@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'curator',
        ]);
        \App\Models\User::create([
            'name' => 'Collector One',
            'email' => 'collector@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'collector',
            'address' => 'Jl Bikini Bottom asem 2'
        ]);
        \App\Models\User::create([
            'name' => 'Collector Two',
            'email' => 'collector2@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'collector',
        ]);
        \App\Models\User::create([
            'name' => 'Curator',
            'email' => 'curator@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'curator',
        ]);
    }
}
