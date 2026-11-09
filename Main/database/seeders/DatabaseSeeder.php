<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Grade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with complete teacher, class, student, and grade data.
     */
    public function run(): void
    {
        // 1. Seed Student Users (for student login)
        $studentUsers = [
            ['lrn' => '109876543210', 'name' => 'Jm Marvie Brizuela', 'role' => 'student'],
            ['lrn' => '109876543211', 'name' => 'Eduard Licatan',      'role' => 'student'],
            ['lrn' => '109876543212', 'name' => 'Clint John Orbillo',  'role' => 'student'],
            ['lrn' => '109876543213', 'name' => 'Charles Cabrera',     'role' => 'student'],
        ];

        foreach ($studentUsers as $st) {
            User::firstOrCreate(['lrn' => $st['lrn']], $st);
        }

        // 2. Seed Default Teacher Account (Mrs. Sarah Miller)
        $teacher = Teacher::updateOrCreate(
            ['employee_id' => 'T-2026-001'],
            [
                'first_name' => 'Sarah',
                'middle_name' => 'Elizabeth',
                'last_name' => 'Miller',
                'contact_number' => '+63 917 555 0192',
                'password' => Hash::make('password123'),
            ]
        );

        // 3. Seed Classrooms
        $class1 = SchoolClass::updateOrCreate(
            ['teacher_id' => $teacher->id, 'class_name' => 'Grade 4 - Diamond'],
            [
                'grade_level' => 'Grade 4',
                'section' => 'Diamond',
                'school_year' => '2026-2027',
                'room' => 'Building A, Room 204',
            ]
        );

        $class2 = SchoolClass::updateOrCreate(
            ['teacher_id' => $teacher->id, 'class_name' => 'Grade 5 - Sapphire'],
            [
                'grade_level' => 'Grade 5',
                'section' => 'Sapphire',
                'school_year' => '2026-2027',
                'room' => 'Building B, Room 102',
            ]
        );

        $class3 = SchoolClass::updateOrCreate(
            ['teacher_id' => $teacher->id, 'class_name' => 'Grade 6 - Emerald'],
            [
                'grade_level' => 'Grade 6',
                'section' => 'Emerald',
                'school_year' => '2026-2027',
                'room' => 'Building C, Room 301',
            ]
        );

        // 4. Seed Students in Grade 4 - Diamond
        $diamondStudents = [
            ['lrn' => '109876543210', 'first_name' => 'Jm Marvie', 'middle_name' => 'Ramos', 'last_name' => 'Brizuela', 'gender' => 'Male', 'date_of_birth' => '2015-04-12', 'address' => 'Poblacion, Ginatilan, Cebu'],
            ['lrn' => '109876543211', 'first_name' => 'Eduard', 'middle_name' => 'Tan', 'last_name' => 'Licatan', 'gender' => 'Male', 'date_of_birth' => '2015-06-25', 'address' => 'San Roque, Ginatilan, Cebu'],
            ['lrn' => '109876543212', 'first_name' => 'Clint John', 'middle_name' => 'Cruz', 'last_name' => 'Orbillo', 'gender' => 'Male', 'date_of_birth' => '2015-08-14', 'address' => 'Guiwanon, Ginatilan, Cebu'],
            ['lrn' => '109876543213', 'first_name' => 'Charles', 'middle_name' => 'Santos', 'last_name' => 'Cabrera', 'gender' => 'Male', 'date_of_birth' => '2015-01-30', 'address' => 'Mangaco, Ginatilan, Cebu'],
            ['lrn' => '109876543214', 'first_name' => 'Sophia', 'middle_name' => 'Marie', 'last_name' => 'Alcantara', 'gender' => 'Female', 'date_of_birth' => '2015-09-08', 'address' => 'Looc, Ginatilan, Cebu'],
            ['lrn' => '109876543215', 'first_name' => 'Angela', 'middle_name' => 'Grace', 'last_name' => 'Villanueva', 'gender' => 'Female', 'date_of_birth' => '2015-11-19', 'address' => 'Calabawan, Ginatilan, Cebu'],
            ['lrn' => '109876543216', 'first_name' => 'Daniel', 'middle_name' => 'Paul', 'last_name' => 'Mercado', 'gender' => 'Male', 'date_of_birth' => '2015-03-03', 'address' => 'Poblacion, Ginatilan, Cebu'],
            ['lrn' => '109876543217', 'first_name' => 'Chloe', 'middle_name' => 'Rose', 'last_name' => 'Del Rosario', 'gender' => 'Female', 'date_of_birth' => '2015-07-22', 'address' => 'Cagsing, Ginatilan, Cebu'],
        ];

        foreach ($diamondStudents as $data) {
            $student = Student::updateOrCreate(
                ['lrn' => $data['lrn']],
                array_merge($data, ['class_id' => $class1->id])
            );

            // Seed Attendance for Today
            Attendance::updateOrCreate(
                ['student_id' => $student->id, 'attendance_date' => today()],
                [
                    'class_id' => $class1->id,
                    'teacher_id' => $teacher->id,
                    'status' => in_array($student->last_name, ['Mercado']) ? 'late' : (in_array($student->last_name, ['Del Rosario']) ? 'absent' : 'present'),
                    'remarks' => $student->last_name === 'Mercado' ? 'Arrived at 8:05 AM' : null,
                ]
            );

            // Seed Grades for Grade 4 Subjects
            $subjects = [
                ['subject' => 'Mathematics', 'quarterly' => rand(88, 96)],
                ['subject' => 'Science', 'quarterly' => rand(86, 95)],
                ['subject' => 'English', 'quarterly' => rand(89, 97)],
                ['subject' => 'Filipino', 'quarterly' => rand(87, 94)],
                ['subject' => 'Araling Panlipunan', 'quarterly' => rand(88, 93)],
                ['subject' => 'MAPEH', 'quarterly' => rand(90, 98)],
                ['subject' => 'EsP', 'quarterly' => rand(92, 98)],
            ];

            foreach ($subjects as $sub) {
                Grade::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'subject' => $sub['subject'],
                        'quarter' => '1st',
                        'school_year' => '2026-2027',
                    ],
                    [
                        'class_id' => $class1->id,
                        'teacher_id' => $teacher->id,
                        'written_work' => $sub['quarterly'] - 2,
                        'performance_task' => $sub['quarterly'] + 1,
                        'quarterly_assessment' => $sub['quarterly'],
                        'initial_grade' => $sub['quarterly'],
                        'quarterly_grade' => $sub['quarterly'],
                        'remarks' => 'Passed - Outstanding Performance',
                    ]
                );
            }
        }

        // 5. Seed Students in Grade 5 - Sapphire
        $sapphireStudents = [
            ['lrn' => '109876543220', 'first_name' => 'Ethan', 'middle_name' => 'James', 'last_name' => 'Navarro', 'gender' => 'Male', 'date_of_birth' => '2014-05-10', 'address' => 'San Roque, Ginatilan, Cebu'],
            ['lrn' => '109876543221', 'first_name' => 'Hannah', 'middle_name' => 'Mae', 'last_name' => 'Salazar', 'gender' => 'Female', 'date_of_birth' => '2014-08-17', 'address' => 'Guiwanon, Ginatilan, Cebu'],
            ['lrn' => '109876543222', 'first_name' => 'Marcus', 'middle_name' => 'Alexander', 'last_name' => 'Perez', 'gender' => 'Male', 'date_of_birth' => '2014-02-14', 'address' => 'Poblacion, Ginatilan, Cebu'],
            ['lrn' => '109876543223', 'first_name' => 'Beatriz', 'middle_name' => 'Nicole', 'last_name' => 'Domingo', 'gender' => 'Female', 'date_of_birth' => '2014-10-29', 'address' => 'Looc, Ginatilan, Cebu'],
        ];

        foreach ($sapphireStudents as $data) {
            $student = Student::updateOrCreate(
                ['lrn' => $data['lrn']],
                array_merge($data, ['class_id' => $class2->id])
            );

            Attendance::updateOrCreate(
                ['student_id' => $student->id, 'attendance_date' => today()],
                [
                    'class_id' => $class2->id,
                    'teacher_id' => $teacher->id,
                    'status' => 'present',
                ]
            );

            Grade::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'subject' => 'Mathematics',
                    'quarter' => '1st',
                    'school_year' => '2026-2027',
                ],
                [
                    'class_id' => $class2->id,
                    'teacher_id' => $teacher->id,
                    'written_work' => 90,
                    'performance_task' => 92,
                    'quarterly_assessment' => 91,
                    'initial_grade' => 91,
                    'quarterly_grade' => 91.2,
                    'remarks' => 'Passed',
                ]
            );
        }

        // 6. Seed Students in Grade 6 - Emerald
        $emeraldStudents = [
            ['lrn' => '109876543230', 'first_name' => 'Gabriel', 'middle_name' => 'Lucas', 'last_name' => 'Reyes', 'gender' => 'Male', 'date_of_birth' => '2013-03-21', 'address' => 'Poblacion, Ginatilan, Cebu'],
            ['lrn' => '109876543231', 'first_name' => 'Isabella', 'middle_name' => 'Claire', 'last_name' => 'Castillo', 'gender' => 'Female', 'date_of_birth' => '2013-12-05', 'address' => 'Calabawan, Ginatilan, Cebu'],
            ['lrn' => '109876543232', 'first_name' => 'Nathan', 'middle_name' => 'Ray', 'last_name' => 'Flores', 'gender' => 'Male', 'date_of_birth' => '2013-07-18', 'address' => 'Cagsing, Ginatilan, Cebu'],
        ];

        foreach ($emeraldStudents as $data) {
            $student = Student::updateOrCreate(
                ['lrn' => $data['lrn']],
                array_merge($data, ['class_id' => $class3->id])
            );

            Attendance::updateOrCreate(
                ['student_id' => $student->id, 'attendance_date' => today()],
                [
                    'class_id' => $class3->id,
                    'teacher_id' => $teacher->id,
                    'status' => 'present',
                ]
            );
        }
    }
}
