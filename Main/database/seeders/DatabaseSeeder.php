<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Students
        $students = [
            ['lrn' => '109876543210', 'name' => 'Jm Marvie Brizuela', 'role' => 'student'],
            ['lrn' => '109876543211', 'name' => 'Eduard Licatan',      'role' => 'student'],
            ['lrn' => '109876543212', 'name' => 'Clint John Orbillo',  'role' => 'student'],
            ['lrn' => '109876543213', 'name' => 'Charles Cabrera',     'role' => 'student'],
        ];

        foreach ($students as $student) {
            User::firstOrCreate(
                ['lrn' => $student['lrn']], 
                $student
            );
        }

        // 2. Seed Teacher User Record
        $teacherUser = User::firstOrCreate(
            ['lrn' => 'EMP-2026-001'], // using lrn column as a unique identifier placeholder if needed, or create by name/role
            [
                'lrn' => 'EMP-2026-001', 
                'name' => 'Maria Santos', 
                'role' => 'teacher'
            ]
        );

        // 3. Seed Teacher Profile Record (with Employee ID & Password)
        Teacher::firstOrCreate(
            ['employee_id' => 'EMP-2026-001'],
            [
                'user_id' => $teacherUser->id,
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'password' => Hash::make('password123'),
            ]
        );
    }
}