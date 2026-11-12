<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the student's profile.
     */
    public function edit()
    {
        $user = Auth::user();

        $student = $user->student;

        abort_unless($student, 404, 'Student profile not found.');

        return view('student.profile', compact('user', 'student'));
    }

    /**
     * Update the student's personal information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $student = $user->student;

        abort_unless($student, 404, 'Student profile not found.');

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date', 'before_or_equal:today'],
            'gender' => ['nullable', Rule::in(['Male', 'Female'])],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($student, $user, $validated) {
            $student->update($validated);

            $user->update([
                'name' => trim(
                    $validated['first_name'] . ' ' .
                    ($validated['middle_name'] ?? '') . ' ' .
                    $validated['last_name']
                ),
            ]);
        });

        return back()->with('success', 'Your profile has been updated successfully!');
    }

    /**
     * Change the student's password voluntarily.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ]);

        $user = Auth::user();

        $user->update([
            'password' => $validated['password'],
            'password_changed_at' => now(),
        ]);

        return back()->with('password_success', 'Your password has been changed successfully!');
    }
}
