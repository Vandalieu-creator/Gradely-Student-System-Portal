<x-teacher-layout active="students" title="Enrolled Students — {{ $class->class_name }}">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 max-w-7xl mx-auto">
            <div class="flex items-center space-x-3">
                <a href="{{ route('teacher.classes.index') }}" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                        {{ $class->class_name }} Roster
                    </h1>
                    <p class="text-xs font-semibold text-slate-500">
                        {{ $class->grade_level }} • Section: {{ $class->section }} • Room: {{ $class->room ?? 'Not assigned' }}
                    </p>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('teacher.classes.students.archived', $class) }}"
                   class="px-4 py-2.5 rounded-xl border border-amber-300 bg-amber-50 hover:bg-amber-100 text-amber-800 text-xs font-bold transition shadow-2xs">
                    Archived ({{ $class->students()->onlyTrashed()->count() }})
                </a>
                <a href="{{ route('teacher.classes.students.create', $class) }}"
                   class="px-4 py-2.5 rounded-xl bg-[#172554] hover:bg-[#1e3a8a] text-white text-xs font-bold shadow-md transition">
                    + Register Student
                </a>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6">

        <!-- Search and Action Bar -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <form method="GET" action="{{ route('teacher.classes.students.index', $class) }}" class="flex-1 max-w-md relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text"
                       name="search"
                       value="{{ $search ?? '' }}"
                       placeholder="Search by student name or LRN..."
                       class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 bg-slate-50">
            </form>

            <div class="flex items-center space-x-2">
                <span class="px-3.5 py-1.5 rounded-xl bg-sky-50 text-sky-700 text-xs font-bold border border-sky-200">
                    {{ $students->count() }} Enrolled Students
                </span>
                <a href="{{ route('teacher.attendance.index') }}?class_id={{ $class->id }}" class="px-3.5 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold border border-amber-200 transition">
                    Take Attendance
                </a>
            </div>
        </div>

        <!-- Student Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-xs">
            @if ($students->isEmpty())
                <div class="px-6 py-16 text-center">
                    <h4 class="text-xl font-bold text-slate-900">No Students Yet</h4>
                    <p class="mt-2 text-xs text-slate-500 max-w-md mx-auto">There are currently no students enrolled in this class. Click below to add your first student.</p>
                    <a href="{{ route('teacher.classes.students.create', $class) }}" class="mt-4 inline-flex items-center space-x-1.5 px-5 py-2.5 rounded-xl bg-[#172554] text-white text-xs font-bold shadow-sm">
                        <span>+ Register Student</span>
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] border-b border-slate-200">
                            <tr>
                                <th class="py-3 px-4">#</th>
                                <th class="py-3 px-4">Student Full Name</th>
                                <th class="py-3 px-4">LRN</th>
                                <th class="py-3 px-4">Gender</th>
                                <th class="py-3 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($students as $index => $student)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-4 font-mono text-slate-400">{{ $index + 1 }}</td>
                                    <td class="py-3.5 px-4 font-bold text-slate-900">
                                        <div class="flex items-center space-x-2.5">
                                            <div class="w-7 h-7 rounded-full bg-sky-100 text-sky-700 font-bold text-xs flex items-center justify-center">
                                                {{ substr($student->first_name, 0, 1) }}
                                            </div>
                                            <span>{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-slate-500">{{ $student->lrn }}</td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $student->gender === 'Female' ? 'bg-pink-50 text-pink-700' : 'bg-blue-50 text-blue-700' }}">
                                            {{ $student->gender ?? 'Not specified' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right space-x-1.5">
                                        <a href="{{ route('teacher.classes.students.show', [$class, $student]) }}"
                                           class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                            View
                                        </a>
                                        <a href="{{ route('teacher.classes.students.edit', [$class, $student]) }}"
                                           class="px-3 py-1.5 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-700 text-xs font-bold transition">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

</x-teacher-layout>
