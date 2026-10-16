<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $students = [
            ['lrn' => '109876543210', 'name' => 'Jm Marvie Brizuela', 'role' => 'student'],
            ['lrn' => '109876543211', 'name' => 'Eduard Licatan',      'role' => 'student'],
            ['lrn' => '109876543212', 'name' => 'Clint John Orbillo',  'role' => 'student'],
            ['lrn' => '109876543213', 'name' => 'Charles Cabrera',     'role' => 'student'],
        ];

        foreach ($students as $student) {
            User::create($student);
        }
    }
}