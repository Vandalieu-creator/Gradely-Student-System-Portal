<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            /*
            |--------------------------------------------------------------------------
            | 1. Maria Santos - Teacher Account
            |--------------------------------------------------------------------------
            */

            // Find Maria's existing teacher record first.
            $existingTeacher = Teacher::where(
                'employee_id',
                'EMP-2026-001'
            )->first();

            // Reuse her linked user account when available.
            $teacherUser = $existingTeacher
                ? User::find($existingTeacher->user_id)
                : null;

            if (! $teacherUser) {
                $teacherUser = User::firstOrCreate(
                    [
                        'name' => 'Maria Santos',
                        'role' => 'teacher',
                    ],
                    [
                        'password' => 'password123',
                    ]
                );
            }

            $teacherUser->update([
                'name' => 'Maria Santos',
                'role' => 'teacher',
            ]);

            $teacher = Teacher::firstOrNew([
                'employee_id' => 'EMP-2026-001',
            ]);

            $teacher->user_id = $teacherUser->id;
            $teacher->first_name = 'Maria';
            $teacher->middle_name = 'Clara';
            $teacher->last_name = 'Santos';

            // Only assign the default password if this is a new account
            // or the existing account has no password.
            if (! $teacher->exists || blank($teacher->password)) {
                $teacher->password = 'password123';
            }

            $teacher->save();


            /*
            |--------------------------------------------------------------------------
            | 2. Maria's Grade 1 - Section A
            |--------------------------------------------------------------------------
            */

            $class = SchoolClass::updateOrCreate(
                [
                    'teacher_id' => $teacher->id,
                    'class_name' => 'Grade 1 - Section A',
                ],
                [
                    'grade_level' => 'Grade 1',
                    'section' => 'Section',
                    'school_year' => '2026-2027',
                    'room' => 'Room 2',
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | 3. Rene Baterbonia - Student Account
            |--------------------------------------------------------------------------
            */

            $studentUser = User::firstOrNew([
                'lrn' => '098765432111',
            ]);

            $studentUser->name = 'Rene Noja Baterbonia';
            $studentUser->role = 'student';

            if (! $studentUser->exists) {
                $studentUser->password = 'testpass2';
            }

            $studentUser->save();

            Student::updateOrCreate(
                [
                    'lrn' => '098765432111',
                ],
                [
                    'first_name' => 'Rene',
                    'middle_name' => 'Noja',
                    'last_name' => 'Baterbonia',
                    'date_of_birth' => '2026-11-01',
                    'gender' => 'Male',
                    'address' => 'To the moon, squirtsquirt',
                    'class_id' => $class->id,
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | 4. Maria's Mathematics Grading Configuration
            |--------------------------------------------------------------------------
            */

            DB::table('grading_configurations')->updateOrInsert(
                [
                    'class_id' => $class->id,
                    'subject' => 'Mathematics',
                    'quarter' => '2nd',
                    'school_year' => '2026-2027',
                ],
                [
                    'teacher_id' => $teacher->id,
                    'grading_framework' => 'numerical',
                    'written_work_weight' => 40,
                    'performance_task_weight' => 40,
                    'quarterly_assessment_weight' => 20,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        });
    }
}
