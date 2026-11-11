<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    /**
     * Send a message from the authenticated teacher to a student.
     */
    public function store(Request $request): RedirectResponse
    {
        $teacher = auth('teacher')->user();

        abort_unless($teacher, 403);

        $validated = $request->validate([
            'lrn' => ['required', 'digits:12'],
            'body' => ['required', 'string', 'max:5000'],
        ]);

        // Find the student, ensuring they belong to this teacher.
        $student = Student::query()
            ->where('lrn', $validated['lrn'])
            ->whereHas('schoolClass', function ($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })
            ->firstOrFail();

        // Find the student's login account using their LRN.
        $studentUser = User::where('lrn', $student->lrn)
            ->where('role', 'student')
            ->firstOrFail();

        // Ensure the teacher has a linked user account.
        abort_unless(
            $teacher->user_id &&
            User::whereKey($teacher->user_id)->exists(),
            403,
            'Your teacher account is not linked to a user account.'
        );

        // Save the message.
        Message::create([
            'teacher_id' => $teacher->id,
            'student_id' => $student->id,
            'sender_id' => $teacher->user_id,
            'sender_type' => 'teacher',
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Message sent successfully!');
    }
}
