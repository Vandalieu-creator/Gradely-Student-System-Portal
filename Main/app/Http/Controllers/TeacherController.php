<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeacherController extends Controller
{
    /**
     * Helper to retrieve currently authenticated teacher with fallback.
     */
    protected function getTeacher(): Teacher
    {
        $teacher = auth('teacher')->user();
        if (!$teacher) {
            $teacher = Teacher::first();
        }
        return $teacher;
    }

    /**
     * Teacher Main Dashboard
     */
    public function dashboard(): View
    {
        $teacher = $this->getTeacher();

        $classes = $teacher->classes()->withCount('students')->get();
        $totalClasses = $classes->count();
        $totalStudents = $classes->sum('students_count');

        $overallAverage = $teacher->grades()->avg('quarterly_grade');

        $attendanceToday = $teacher->attendances()
            ->whereDate('attendance_date', today())
            ->get();

        $attendanceCount = $attendanceToday->count();
        $presentCount = $attendanceToday->where('status', 'present')->count();
        $lateCount = $attendanceToday->where('status', 'late')->count();
        $absentCount = $attendanceToday->where('status', 'absent')->count();

        $attendanceRate = $attendanceCount > 0
            ? round((($presentCount + $lateCount) / $attendanceCount) * 100, 1)
            : 96.5;

        $recentStudents = Student::whereIn('class_id', $classes->pluck('id'))
            ->latest()
            ->take(6)
            ->get();

        return view('teacher.dashboard', compact(
            'teacher',
            'classes',
            'totalClasses',
            'totalStudents',
            'overallAverage',
            'attendanceToday',
            'attendanceCount',
            'presentCount',
            'lateCount',
            'absentCount',
            'attendanceRate',
            'recentStudents'
        ));
    }

    /**
     * My Students Directory (All assigned students)
     */
    public function students(Request $request): View
    {
        $teacher = $this->getTeacher();
        $classes = $teacher->classes()->get();

        $classFilter = $request->query('class');
        $search = $request->query('search');

        $studentsQuery = Student::whereIn('class_id', $classes->pluck('id'))
            ->with('schoolClass');

        if ($classFilter) {
            $selectedClass = $classes->firstWhere('class_name', $classFilter);
            if ($selectedClass) {
                $studentsQuery->where('class_id', $selectedClass->id);
            }
        }

        if ($search) {
            $studentsQuery->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('lrn', 'like', "%{$search}%");
            });
        }

        $students = $studentsQuery->orderBy('last_name')->orderBy('first_name')->get();

        return view('teacher.students.all', compact('teacher', 'classes', 'students', 'classFilter', 'search'));
    }

    /**
     * Attendance Management & Roll Call
     */
    public function attendance(Request $request): View
    {
        $teacher = $this->getTeacher();
        $classes = $teacher->classes()->get();

        $selectedClassId = $request->query('class_id', $classes->first()->id ?? null);
        $selectedDate = $request->query('date', today()->format('Y-m-d'));

        $selectedClass = $classes->firstWhere('id', $selectedClassId);

        $students = $selectedClass 
            ? $selectedClass->students()->orderBy('last_name')->orderBy('first_name')->get() 
            : collect();

        // Get existing attendance for this class and date
        $attendanceRecords = Attendance::where('class_id', $selectedClassId)
            ->whereDate('attendance_date', $selectedDate)
            ->get()
            ->keyBy('student_id');

        $presentCount = $attendanceRecords->where('status', 'present')->count();
        $lateCount = $attendanceRecords->where('status', 'late')->count();
        $absentCount = $attendanceRecords->where('status', 'absent')->count();
        $excusedCount = $attendanceRecords->where('status', 'excused')->count();

        return view('teacher.attendance.index', compact(
            'teacher',
            'classes',
            'selectedClass',
            'selectedClassId',
            'selectedDate',
            'students',
            'attendanceRecords',
            'presentCount',
            'lateCount',
            'absentCount',
            'excusedCount'
        ));
    }

    /**
     * Save Attendance Roll Call
     */
    public function saveAttendance(Request $request): RedirectResponse
    {
        $teacher = $this->getTeacher();

        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'attendance_date' => 'required|date',
            'attendance' => 'required|array',
        ]);

        $classId = $request->input('class_id');
        $date = $request->input('attendance_date');
        $attendanceData = $request->input('attendance', []);

        foreach ($attendanceData as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'attendance_date' => $date,
                ],
                [
                    'class_id' => $classId,
                    'teacher_id' => $teacher->id,
                    'status' => in_array($status, ['present', 'late', 'absent', 'excused']) ? $status : 'present',
                ]
            );
        }

        return redirect()->route('teacher.attendance.index', [
            'class_id' => $classId,
            'date' => $date,
        ])->with('success', 'Attendance for ' . date('F d, Y', strtotime($date)) . ' saved successfully!');
    }

    /**
     * Class Schedule & Timetable
     */
    public function schedule(Request $request): View
    {
        $teacher = $this->getTeacher();
        $classes = $teacher->classes()->get();

        return view('teacher.schedule.index', compact('teacher', 'classes'));
    }

    /**
     * Assignments Management
     */
    public function assignments(Request $request): View
    {
        $teacher = $this->getTeacher();
        $classes = $teacher->classes()->get();

        return view('teacher.assignments.index', compact('teacher', 'classes'));
    }

    /**
     * Learning Materials Repository
     */
    public function materials(Request $request): View
    {
        $teacher = $this->getTeacher();
        $classes = $teacher->classes()->get();

        return view('teacher.materials.index', compact('teacher', 'classes'));
    }

    /**
     * Grades & Reports Matrix
     */
    public function grades(Request $request): View
    {
        $teacher = $this->getTeacher();
        $classes = $teacher->classes()->get();

        $selectedClassId = $request->query('class_id', $classes->first()->id ?? null);
        $selectedQuarter = $request->query('quarter', '1st');
        $selectedSubject = $request->query('subject', 'Mathematics');

        $selectedClass = $classes->firstWhere('id', $selectedClassId);

        $students = $selectedClass 
            ? $selectedClass->students()->orderBy('last_name')->orderBy('first_name')->get() 
            : collect();

        $grades = Grade::where('class_id', $selectedClassId)
            ->where('quarter', $selectedQuarter)
            ->where('subject', $selectedSubject)
            ->get()
            ->keyBy('student_id');

        return view('teacher.grades.index', compact(
            'teacher',
            'classes',
            'selectedClass',
            'selectedClassId',
            'selectedQuarter',
            'selectedSubject',
            'students',
            'grades'
        ));
    }

    /**
     * Announcements Bulletin
     */
    public function announcements(Request $request): View
    {
        $teacher = $this->getTeacher();
        $classes = $teacher->classes()->get();

        return view('teacher.announcements.index', compact('teacher', 'classes'));
    }

    /**
     * Messages & Communication Center
     */
    public function messages(Request $request): View
    {
        $teacher = $this->getTeacher();
        $classes = $teacher->classes()->get();

        return view('teacher.messages.index', compact('teacher', 'classes'));
    }
}
