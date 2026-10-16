<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. STUDENT LOGIN -> Queries 'users' table by LRN
        if ($request->input('login_type') === 'student' || $request->filled('lrn')) {
            $request->validate([
                'lrn' => ['required', 'string'],
            ], [
                'lrn.required' => 'Please enter your 12-digit LRN.',
            ]);

            $user = User::where('lrn', $request->lrn)->first();

            if (! $user) {
                return back()->withErrors([
                    'lrn' => 'No student found with this LRN.',
                ])->onlyInput('lrn');
            }

            Auth::login($user, false);
            $request->session()->regenerate();

            return redirect()->route('student.dashboard');
        }

        // 2. TEACHER LOGIN -> Queries 'teachers' table by employee_id directly
        if ($request->input('login_type') === 'teacher' || $request->filled('employee_id')) {
            $request->validate([
                'employee_id' => ['required', 'string'],
                'password'    => ['required', 'string'],
            ]);

            // Query teachers table directly
            $teacher = Teacher::where('employee_id', $request->employee_id)->first();

            if ($teacher && Hash::check($request->password, $teacher->password)) {
                // Log teacher in
                Auth::login($teacher, false);
                $request->session()->regenerate();

                return redirect()->intended('/teacher/dashboard');
            }

            return back()->withErrors([
                'employee_id' => 'Invalid Employee ID or password.',
            ])->onlyInput('employee_id');
        }

        return back();
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}