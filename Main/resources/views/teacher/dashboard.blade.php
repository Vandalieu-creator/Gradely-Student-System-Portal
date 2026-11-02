
<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-blue-700">
                Gradely Teacher Portal
            </p>
            <h2 class="mt-2 text-2xl font-bold text-slate-900">
                Dashboard
            </h2>
        </div>
    </x-slot>

    @php
        $teacher = auth('teacher')->user();

        // Classes and enrolled students
        $classes = $teacher->classes()
            ->withCount('students')
            ->get();

        $totalClasses = $classes->count();
        $totalStudents = $classes->sum('students_count');

        // Overall general average
        $overallAverage = $teacher->grades()->avg('quarterly_grade');

        // Today's attendance
        $attendanceToday = $teacher->attendances()
            ->whereDate('attendance_date', today())
            ->get();

        $attendanceCount = $attendanceToday->count();

        $presentCount = $attendanceToday->where('status', 'present')->count();
        $lateCount = $attendanceToday->where('status', 'late')->count();
        $absentCount = $attendanceToday->where('status', 'absent')->count();

        $attendanceRate = $attendanceCount > 0
            ? round((($presentCount + $lateCount) / $attendanceCount) * 100, 1)
            : null;

        // Grade records
        $totalGradeRecords = $teacher->grades()->count();
    @endphp

    <div class="min-h-screen bg-slate-50 py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-6 sm:px-8 lg:px-10">

            <!-- Dashboard Heading -->
            <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
                <div>
                    <h3 class="text-3xl font-bold tracking-tight text-slate-900">
                        Welcome, {{ $teacher->first_name }}!
                    </h3>

                    <p class="mt-2 text-base text-slate-600">
                        Here's an overview of your classroom and student records.
                    </p>

                    <p class="mt-3 text-sm font-semibold text-slate-600">
                        <span class="text-teal-600">Gradely Teacher Portal</span>
                        <span class="mx-2 text-slate-300">•</span>
                        Employee ID: {{ $teacher->employee_id }}
                    </p>
                </div>

                <div class="text-sm font-medium text-slate-500">
                    {{ now()->format('l, F d, Y') }}
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">

                <!-- Total Enrolled Students -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-500">
                            Total Enrolled Students
                        </p>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>

                    <h4 class="mt-5 text-4xl font-extrabold tracking-tight text-slate-900">
                        {{ $totalStudents }}
                    </h4>

                    <p class="mt-3 text-sm text-slate-500">
                        <span class="font-semibold text-blue-700">
                            {{ $totalClasses }} classes
                        </span>
                        <span class="ml-1">under your account</span>
                    </p>
                </div>

                <!-- Overall General Average -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-500">
                            Overall Gen. Average
                        </p>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-50 text-teal-600">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0118 16.5c0 1.7-2.686 3.5-6 3.5s-6-1.8-6-3.5c0-2.1.55-4.05 1.84-5.922L12 14z"/>
                            </svg>
                        </div>
                    </div>

                    <h4 class="mt-5 text-4xl font-extrabold tracking-tight text-slate-900">
                        {{ $overallAverage !== null ? number_format($overallAverage, 1) : '—' }}
                    </h4>

                    <p class="mt-3 text-sm text-slate-500">
                        {{ $totalGradeRecords }} grade records available
                    </p>
                </div>

                <!-- Attendance Rate Today -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-500">
                            Attendance Rate Today
                        </p>

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"/>
                            </svg>
                        </div>
                    </div>

                    <h4 class="mt-5 text-4xl font-extrabold tracking-tight text-slate-900">
                        {{ $attendanceRate !== null ? $attendanceRate . '%' : '—' }}
                    </h4>

                    <p class="mt-3 text-sm text-slate-500">
                        @if ($attendanceCount > 0)
                            <span class="font-semibold text-amber-700">
                                {{ $absentCount }} absent
                            </span>
                            <span class="ml-1">in today's recorded attendance</span>
                        @else
                            No attendance recorded today
                        @endif
                    </p>
                </div>

            </div>

            <!-- Main Dashboard Content -->
            <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-5">

                <!-- Alerts and Action Required -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm xl:col-span-3">

                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-slate-900">
                            Alerts & Action Required
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Important information about your teaching records.
                        </p>
                    </div>

                    <div class="space-y-4">

                        <!-- Attendance Alert -->
                        @if ($attendanceCount === 0)
                            <div class="flex gap-4 rounded-xl border border-blue-200 border-l-4 border-l-blue-600 bg-blue-50 p-5">
                                <div class="mt-0.5 text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-6 w-6"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M12 9v3m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z"/>
                                    </svg>
                                </div>

                                <div>
                                    <h4 class="font-bold text-slate-900">
                                        Attendance Not Yet Recorded
                                    </h4>

                                    <p class="mt-1 text-sm leading-5 text-slate-600">
                                        No attendance records have been entered for today.
                                        Remember to update your classroom attendance.
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="flex gap-4 rounded-xl border border-teal-200 border-l-4 border-l-teal-600 bg-teal-50 p-5">
                                <div class="mt-0.5 text-teal-600">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-6 w-6"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>

                                <div>
                                    <h4 class="font-bold text-slate-900">
                                        Today's Attendance Summary
                                    </h4>

                                    <p class="mt-1 text-sm leading-5 text-slate-600">
                                        {{ $attendanceCount }} attendance records:
                                        {{ $presentCount }} present,
                                        {{ $lateCount }} late,
                                        and {{ $absentCount }} absent.
                                    </p>
                                </div>
                            </div>
                        @endif

                        <!-- Grade Records Alert -->
                        <div class="flex gap-4 rounded-xl border border-amber-200 border-l-4 border-l-amber-500 bg-amber-50 p-5">
                            <div class="mt-0.5 text-amber-600">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-6 w-6"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 9v3m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                </svg>
                            </div>

                            <div>
                                <h4 class="font-bold text-slate-900">
                                    Grade Records Overview
                                </h4>

                                <p class="mt-1 text-sm leading-5 text-slate-600">
                                    You currently have {{ $totalGradeRecords }}
                                    grade records saved in Gradely.
                                    Keep student academic records updated.
                                </p>
                            </div>
                        </div>

                        <!-- Class Alert -->
                        @if ($totalClasses === 0)
                            <div class="flex gap-4 rounded-xl border border-red-200 border-l-4 border-l-red-500 bg-red-50 p-5">
                                <div class="mt-0.5 text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-6 w-6"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M12 9v3m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z"/>
                                    </svg>
                                </div>

                                <div>
                                    <h4 class="font-bold text-slate-900">
                                        No Classes Created
                                    </h4>

                                    <p class="mt-1 text-sm leading-5 text-slate-600">
                                        You don't have any classes yet.
                                        Create your first class to begin organizing students.
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="flex gap-4 rounded-xl border border-sky-200 border-l-4 border-l-sky-500 bg-sky-50 p-5">
                                <div class="mt-0.5 text-sky-600">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-6 w-6"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                                    </svg>
                                </div>

                                <div>
                                    <h4 class="font-bold text-slate-900">
                                        Classroom Overview
                                    </h4>

                                    <p class="mt-1 text-sm leading-5 text-slate-600">
                                        You currently manage {{ $totalClasses }}
                                        {{ Str::plural('class', $totalClasses) }}
                                        with {{ $totalStudents }}
                                        enrolled {{ Str::plural('student', $totalStudents) }}.
                                    </p>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm xl:col-span-2">

                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-slate-900">
                            Quick Actions
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Shortcuts to your classroom activities.
                        </p>
                    </div>

                    <div class="space-y-4">

                        <!-- My Classes -->
                        <a href="{{ route('teacher.classes.index') }}"
                           class="group flex items-center gap-4 rounded-xl border border-slate-200 p-4 transition hover:border-teal-300 hover:bg-teal-50">

                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-teal-50 text-teal-600">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-6 w-6"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"/>
                                </svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <h4 class="font-bold text-slate-900">
                                    My Classes
                                </h4>

                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                    View your classrooms and students
                                </p>
                            </div>

                            <span class="text-xl text-slate-400 transition group-hover:translate-x-1 group-hover:text-teal-700">
                                ›
                            </span>
                        </a>

                        <!-- Create Class -->
                        <a href="{{ route('teacher.classes.create') }}"
                           class="group flex items-center gap-4 rounded-xl border border-slate-200 p-4 transition hover:border-sky-300 hover:bg-sky-50">

                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-6 w-6"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <h4 class="font-bold text-slate-900">
                                    Create New Class
                                </h4>

                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                    Set up a new classroom
                                </p>
                            </div>

                            <span class="text-xl text-slate-400 transition group-hover:translate-x-1 group-hover:text-sky-700">
                                ›
                            </span>
                        </a>

                    </div>

                    <!-- Teacher Information -->
                    <div class="mt-6 rounded-xl bg-slate-50 p-5">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">
                            Account Information
                        </p>

                        <p class="mt-3 font-semibold text-slate-900">
                            {{ $teacher->first_name }} {{ $teacher->last_name }}
                        </p>

                        <p class="mt-1 text-sm text-slate-500">
                            Employee ID: {{ $teacher->employee_id }}
                        </p>

                        <p class="mt-1 text-sm text-slate-500">
                            Teacher Account
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
