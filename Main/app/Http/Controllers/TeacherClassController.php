<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherClassController extends Controller
{
    // Display the teacher's classes.
    public function index(): View
    {
        $teacher = auth('teacher')->user();

        $classes = $teacher->classes()
            ->withCount('students')
            ->latest()
            ->get();

        return view('teacher.classes.index', compact('classes'));
    }

    // Display the create class form.
    public function create(): View
    {
        return view('teacher.classes.create');
    }

    // Save a new class.
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'class_name' => ['required', 'string', 'max:255'],
            'grade_level' => ['required', 'string', 'max:50'],
            'section' => ['required', 'string', 'max:100'],
            'school_year' => ['required', 'string', 'max:20'],
            'room' => ['nullable', 'string', 'max:100'],
        ]);

        $teacher = auth('teacher')->user();

        $teacher->classes()->create($validated);

        return redirect()
            ->route('teacher.classes.index')
            ->with('success', 'Class created successfully!');
    }
}