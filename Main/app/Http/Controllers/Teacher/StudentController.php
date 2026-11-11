<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        $teacher = auth('teacher')->user();

        abort_unless($teacher, 403);

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],

            'lrn' => [
                'required',
                'digits:12',
                'unique:students,lrn',
                'unique:users,lrn',
            ],

            'date_of_birth' => ['nullable', 'date', 'before_or_equal:today'],
            'gender' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],

            'class_id' => [
                'required',
                'integer',
                Rule::exists('classes', 'id')
                    ->where('teacher_id', $teacher->id),
            ],
        ]);

        DB::transaction(function () use ($validated) {
            Student::create([
                'lrn' => $validated['lrn'],
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'address' => $validated['address'] ?? null,
                'class_id' => $validated['class_id'],
            ]);

            $fullName = trim(
                $validated['first_name'] . ' ' .
                ($validated['middle_name'] ?? '') . ' ' .
                $validated['last_name']
            );

            \App\Models\User::create([
                'name' => $fullName,
                'lrn' => $validated['lrn'],
                'role' => 'student',
                'password' => Str::random(40),
            ]);
        });

        return redirect()
            ->route('teacher.class-settings')
            ->with('success', 'Student enrolled successfully!');
    }
}
