<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Gradely Admin',
            'email' => 'admin@gradely.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Gradely Teacher',
            'email' => 'teacher@gradely.test',
            'password' => 'password',
            'role' => 'teacher',
        ]);

        User::create([
            'name' => 'Gradely Parent',
            'email' => 'parent@gradely.test',
            'password' => 'password',
            'role' => 'parent',
        ]);
    }
}