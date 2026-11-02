<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeacherStudentController extends Controller
{
    /**
     * Display students belonging to a selected class.
     */
public function index(Request $request, SchoolClass $class): View
{
    $teacher = auth('teacher')->user();

    abort_unless($class->teacher_id === $teacher->id, 403);

    $search = $request->input('search');

    $students = $class->students()
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('lrn', 'like', "%{$search}%");
            });
        })
        ->orderBy('last_name')
        ->orderBy('first_name')
        ->get();

    return view('teacher.students.index', compact('class', 'students', 'search'));
}
/**
 * Display archived students belonging to a selected class.
 */
public function archived(SchoolClass $class): View
{
    $teacher = auth('teacher')->user();

    abort_unless($class->teacher_id === $teacher->id, 403);

    $students = $class->students()
        ->onlyTrashed()
        ->orderBy('last_name')
        ->orderBy('first_name')
        ->get();

    return view('teacher.students.archived', compact('class', 'students'));
}

    /**
     * Display the Add Student form.
     */
    public function create(SchoolClass $class): View
    {
        $teacher = auth('teacher')->user();

        abort_unless($class->teacher_id === $teacher->id, 403);

        return view('teacher.students.create', compact('class'));
    }

/**
 * Display the details of a student.
 */
public function show(SchoolClass $class, \App\Models\Student $student): View
{
    $teacher = auth('teacher')->user();

    abort_unless($class->teacher_id === $teacher->id, 403);

    abort_unless($student->class_id === $class->id, 404);

    return view('teacher.students.show', compact('class', 'student'));
}

/**
 * Display the Edit Student form.
 */
public function edit(SchoolClass $class, \App\Models\Student $student): View
{
    $teacher = auth('teacher')->user();

    abort_unless($class->teacher_id === $teacher->id, 403);

    abort_unless($student->class_id === $class->id, 404);

    $classrooms = $teacher->classes()
        ->orderBy('grade_level')
        ->orderBy('class_name')
        ->get();

    return view('teacher.students.edit', compact('class', 'student', 'classrooms'));
}

    /**
     * Save a new student.
     */
    public function store(Request $request, SchoolClass $class): RedirectResponse
    {
        $teacher = auth('teacher')->user();

        abort_unless($class->teacher_id === $teacher->id, 403);

        $validated = $request->validate([
            'lrn' => ['required', 'string', 'max:20', 'unique:students,lrn'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before_or_equal:today'],
            'gender' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);

        $class->students()->create($validated);

        return redirect()
            ->route('teacher.classes.students.index', $class)
            ->with('success', 'Student registered successfully!');
    }
  /**
 * Update an existing student's information.
 */
public function update(Request $request, SchoolClass $class, \App\Models\Student $student): RedirectResponse
{
    $teacher = auth('teacher')->user();

    abort_unless($class->teacher_id === $teacher->id, 403);

    abort_unless($student->class_id === $class->id, 404);

    $validated = $request->validate([
        'lrn' => [
            'required',
            'string',
            'max:20',
            \Illuminate\Validation\Rule::unique('students', 'lrn')->ignore($student->id),
        ],
        'first_name' => ['required', 'string', 'max:255'],
        'middle_name' => ['nullable', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'date_of_birth' => ['required', 'date', 'before_or_equal:today'],
        'gender' => ['required', 'in:Male,Female'],
        'address' => ['nullable', 'string', 'max:1000'],
        'class_id' => [
            'required',
            'integer',
            \Illuminate\Validation\Rule::in($teacher->classes()->pluck('id')->all()),
        ],
    ]);

$student->update($validated);

$student->refresh();

$newClass = SchoolClass::findOrFail($student->class_id);

return redirect()
    ->route('teacher.classes.students.show', [$newClass, $student])
    ->with('success', 'Student information updated successfully!');
}
/**
 * Archive a student without deleting academic records.
 */
public function destroy(
    SchoolClass $class,
    \App\Models\Student $student
): RedirectResponse {
    $teacher = auth('teacher')->user();

    abort_unless($class->teacher_id === $teacher->id, 403);

    abort_unless($student->class_id === $class->id, 404);

    $student->delete();

    return redirect()
        ->route('teacher.classes.students.index', $class)
        ->with('success', 'Student removed from the active list successfully. Their grades and attendance records have been preserved.');
}
/**
 * Restore an archived student to the active classroom list.
 */
public function restore(
    SchoolClass $class,
    int $student
): RedirectResponse {
    $teacher = auth('teacher')->user();

    // Make sure the class belongs to the logged-in teacher.
    abort_unless($class->teacher_id === $teacher->id, 403);

    // Find the archived student.
    $archivedStudent = \App\Models\Student::onlyTrashed()
        ->whereKey($student)
        ->firstOrFail();

    // Make sure the student belongs to this classroom.
    abort_unless(
        (int) $archivedStudent->class_id === (int) $class->id,
        404
    );

    // Restore the student.
    $archivedStudent->restore();

    return redirect()
        ->route('teacher.classes.students.archived', $class)
        ->with('success', 'Student restored to the active classroom list successfully.');
}
}