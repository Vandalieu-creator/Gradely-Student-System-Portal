<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassSettingsController extends Controller
{
    /**
     * Display the teacher's class settings.
     */
    public function index()
    {
        $teacher = auth('teacher')->user();

        abort_unless($teacher, 403);

        $classes = $teacher->classes()
            ->with('students')
            ->withCount('students')
            ->orderBy('grade_level')
            ->orderBy('section')
            ->get();

        return view('teacher.class-settings', compact('classes'));
    }

    /**
     * Create a new class.
     */
    public function store(Request $request)
    {
        $teacher = auth('teacher')->user();

        abort_unless($teacher, 403);

        $validated = $request->validate([
            'grade_level' => ['required', 'string', 'max:255'],
            'section' => ['required', 'string', 'max:255'],
            'room' => ['nullable', 'string', 'max:255'],
            'school_year' => ['required', 'string', 'max:255'],
        ]);

        $validated['class_name'] =
            $validated['grade_level'] . ' - ' . $validated['section'];

        $teacher->classes()->create($validated);

        return redirect()
            ->route('teacher.class-settings')
            ->with('success', 'Class created successfully!');
    }
}
