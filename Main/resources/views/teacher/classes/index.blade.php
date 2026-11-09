<x-teacher-layout active="classes" title="My Classes">

    <!-- Top Navigation Bar -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 max-w-7xl mx-auto">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 shadow-xs">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 6v8"/>
                        <path d="M4 12h5"/>
                        <path d="M4 14l-1.5 6"/>
                        <path d="M9 14l-1.5 6"/>
                        <path d="M12 9h8"/>
                        <path d="M13 9v11"/>
                        <path d="M19 9v11"/>
                        <path d="M6.5 17h10"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                        My Classes
                    </h1>
                    <p class="text-xs font-semibold text-slate-500">
                        Manage your classrooms and monitor student enrollment
                    </p>
                </div>
            </div>

            <!-- Action button -->
            <a href="{{ route('teacher.classes.create') }}"
               class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-[#172554] hover:bg-[#1e3a8a] text-white text-xs font-bold shadow-sm transition">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Create New Class</span>
            </a>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6">

        <!-- Page Introduction -->
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                    Classroom Overview
                </h2>
                <p class="mt-1 text-sm text-slate-600">
                    View and manage the classrooms assigned to your teaching account.
                </p>
            </div>

            <div class="flex items-center space-x-2">
                <span class="rounded-full border border-slate-200 bg-white px-3.5 py-1.5 text-xs font-bold text-slate-700 shadow-2xs">
                    {{ $classes->count() }} Total Classes
                </span>
                <span class="rounded-full border border-sky-200 bg-sky-50 px-3.5 py-1.5 text-xs font-bold text-sky-700 shadow-2xs">
                    {{ $classes->sum('students_count') }} Students Enrolled
                </span>
            </div>
        </div>

        <!-- Statistics Banner Cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Total Classrooms
                    </p>
                    <p class="mt-2 text-3xl font-extrabold text-slate-900">
                        {{ $classes->count() }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500 font-medium">
                        Active teaching sections
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i class="fa-solid fa-chalkboard-user text-xl"></i>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-xs flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Total Enrolled Students
                    </p>
                    <p class="mt-2 text-3xl font-extrabold text-slate-900">
                        {{ $classes->sum('students_count') }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500 font-medium">
                        Across all grade levels
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3.5 text-sm font-semibold text-emerald-800 flex items-center space-x-2">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Class Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($classes as $class)
                <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xs hover:shadow-md transition flex flex-col justify-between group">

                    <!-- Card Header -->
                    <div class="p-6 border-b border-slate-100">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-lg bg-sky-50 text-sky-700 border border-sky-200">
                                {{ $class->grade_level }}
                            </span>
                            <span class="text-xs font-semibold text-slate-400 font-mono">
                                S.Y. {{ $class->school_year }}
                            </span>
                        </div>

                        <h3 class="mt-3 text-xl font-bold text-slate-900 group-hover:text-sky-600 transition">
                            {{ $class->class_name }}
                        </h3>

                        <p class="mt-1 text-xs text-slate-500 flex items-center space-x-1.5">
                            <i class="fa-solid fa-location-dot text-slate-400"></i>
                            <span>{{ $class->room ?? 'Building Room Not Assigned' }}</span>
                        </p>
                    </div>

                    <!-- Details Stats -->
                    <div class="px-6 py-4 bg-slate-50/50 grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <span class="text-slate-400 font-semibold block text-[10px] uppercase">Section</span>
                            <span class="font-bold text-slate-800">{{ $class->section }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-semibold block text-[10px] uppercase">Enrolled</span>
                            <span class="font-bold text-slate-800">{{ $class->students_count }} Students</span>
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div class="p-4 border-t border-slate-100 flex items-center justify-between bg-white">
                        <a href="{{ route('teacher.attendance.index') }}?class_id={{ $class->id }}" 
                           class="text-xs font-bold text-slate-600 hover:text-sky-600 transition flex items-center space-x-1">
                            <i class="fa-solid fa-clipboard-check text-[11px]"></i>
                            <span>Roll Call</span>
                        </a>

                        <a href="{{ route('teacher.classes.students.index', $class) }}"
                           class="px-4 py-2 rounded-xl bg-[#172554] hover:bg-[#1e3a8a] text-white text-xs font-bold shadow-xs transition">
                            Manage Roster →
                        </a>
                    </div>

                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full rounded-3xl border border-slate-200 bg-white px-6 py-16 text-center shadow-xs">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto text-2xl mb-4">
                        <i class="fa-solid fa-chalkboard"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900">No Classes Found</h4>
                    <p class="mx-auto mt-2 max-w-md text-xs text-slate-500">
                        You have not created any classes yet. Click the button below to add your first classroom.
                    </p>
                    <a href="{{ route('teacher.classes.create') }}" class="mt-5 inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-[#172554] text-white text-xs font-bold shadow-sm">
                        <span>+ Create Classroom</span>
                    </a>
                </div>
            @endforelse
        </div>

    </div>

</x-teacher-layout>
