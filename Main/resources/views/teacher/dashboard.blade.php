<x-teacher-layout active="dashboard" title="Teacher Dashboard">

    <!-- Top Navigation / Header Bar -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 max-w-7xl mx-auto">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-[#00adef] to-sky-400 text-white flex items-center justify-center shadow-md shadow-sky-500/20">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 4.5c1.2-1.5 2.8-2.5 4.5-2.5 0 2-1 3.5-2.5 4.5"/>
                        <path d="M8.5 7.5C5.5 7.5 3 9.8 3 13.5c0 4.5 3.2 8.5 6 8.5 1.4 0 2.2-.8 3-0.8s1.6.8 3 .8c2.8 0 6-4 6-8.5 0-3.7-2.5-6-5.5-6-1.5 0-2.8.8-3.5 1.5-.7-.7-2-1.5-3.5-1.5z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                        Teacher Dashboard
                    </h1>
                    <p class="text-xs font-semibold text-slate-500">
                        Ginatilan Elementary School <span class="text-slate-300">•</span> S.Y. 2026-2027
                    </p>
                </div>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex items-center space-x-2.5">
                <button type="button" 
                        @click="showQuickFind = true"
                        class="hidden sm:flex items-center space-x-2 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer border border-slate-200/60">
                    <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
                    <span>Quick Find</span>
                    <kbd class="px-1.5 py-0.5 rounded bg-white text-slate-500 font-mono text-[10px] shadow-2xs border border-slate-200">⌘K</kbd>
                </button>

                <button type="button" 
                        @click="showAnnouncementModal = true"
                        class="flex items-center space-x-1.5 px-3.5 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-bold transition cursor-pointer border border-amber-200">
                    <i class="fa-solid fa-bullhorn text-xs"></i>
                    <span>Announce</span>
                </button>

                <a href="{{ route('teacher.attendance.index') }}" 
                   class="flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-[#00adef] hover:bg-[#009fdc] text-white text-xs font-bold shadow-md shadow-sky-500/20 transition cursor-pointer">
                    <i class="fa-solid fa-clipboard-check text-xs"></i>
                    <span>Roll Call</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Dashboard Container -->
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6">

        <!-- Welcome Hero Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#101a2a] via-[#172554] to-[#1e3a8a] text-white p-6 sm:p-8 shadow-xl border border-slate-700/50">
            <!-- Decorative Background Element -->
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 text-sky-300 text-xs font-bold tracking-wide backdrop-blur-xs border border-white/10">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Faculty Portal Active</span>
                        <span class="text-white/40">•</span>
                        <span>Employee ID: {{ $teacher->employee_id }}</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                        Welcome back, {{ $teacher->first_name }} {{ $teacher->last_name }}! 👋
                    </h2>

                    <p class="text-sm text-slate-300 max-w-2xl leading-relaxed">
                        You have <span class="text-sky-300 font-bold">{{ $totalClasses }} assigned classes</span> with <span class="text-sky-300 font-bold">{{ $totalStudents }} active students</span>. Homeroom advisory for <span class="text-emerald-300 font-bold">Grade 4 - Diamond</span>.
                    </p>
                </div>

                <!-- Live Date & Shift Status -->
                <div class="shrink-0 bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/10 text-center sm:text-right">
                    <p class="text-xs uppercase font-bold tracking-wider text-sky-200">Current Session</p>
                    <p class="text-lg font-bold text-white mt-0.5">{{ now()->format('l') }}</p>
                    <p class="text-xs text-slate-300 font-medium">{{ now()->format('F d, Y') }}</p>
                    <div class="mt-2 inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-lg bg-emerald-500/20 text-emerald-300 text-[11px] font-bold">
                        <i class="fa-solid fa-clock text-[10px]"></i>
                        <span>Morning Period Ongoing</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4 Key Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Card 1: Total Enrolled Students -->
            <a href="{{ route('teacher.my-students') }}" 
               class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md hover:border-sky-300 transition group block">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Students</span>
                    <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-user-group text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline space-x-2">
                    <span class="text-3xl font-extrabold text-slate-900">{{ $totalStudents }}</span>
                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">100% Active</span>
                </div>
                <p class="text-xs text-slate-400 mt-2 font-medium">Across {{ $totalClasses }} classroom sections</p>
            </a>

            <!-- Card 2: Assigned Classes -->
            <a href="{{ route('teacher.my-students') }}" 
               class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md hover:border-indigo-300 transition group block">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">My Classes</span>
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-chalkboard-user text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline space-x-2">
                    <span class="text-3xl font-extrabold text-slate-900">{{ $totalClasses }}</span>
                    <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full">3 Levels</span>
                </div>
                <p class="text-xs text-slate-400 mt-2 font-medium">Grades 4, 5, and 6 sections</p>
            </a>

            <!-- Card 3: Today's Attendance -->
            <a href="{{ route('teacher.attendance.index') }}" 
               class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md hover:border-amber-300 transition group block">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Today's Attendance</span>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-clipboard-check text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline space-x-2">
                    <span class="text-3xl font-extrabold text-slate-900">{{ $attendanceRate }}%</span>
                    <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">
                        {{ $presentCount }} Present
                    </span>
                </div>
                <p class="text-xs text-slate-400 mt-2 font-medium">
                    {{ $lateCount }} late, {{ $absentCount }} absent recorded
                </p>
            </a>

            <!-- Card 4: General Grade Average -->
            <a href="{{ route('teacher.grades.index') }}" 
               class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md hover:border-teal-300 transition group block">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Class Gen. Average</span>
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-award text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline space-x-2">
                    <span class="text-3xl font-extrabold text-slate-900">
                        {{ $overallAverage ? number_format($overallAverage, 1) : '91.8' }}%
                    </span>
                    <span class="text-xs font-semibold text-teal-600 bg-teal-50 px-2 py-0.5 rounded-full">Quarter 1</span>
                </div>
                <p class="text-xs text-slate-400 mt-2 font-medium">Outstanding academic standing</p>
            </a>

        </div>

        <!-- Middle Grid: Classes Overview & Quick Attendance Roll Call -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Assigned Classes Quick List (2 cols) -->
            <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Assigned Classrooms</h3>
                        <p class="text-xs text-slate-500">Your current teaching sections and schedules</p>
                    </div>
                    <a href="{{ route('teacher.my-students') }}" class="text-xs font-bold text-sky-600 hover:text-sky-700 transition">
                        View All Classes →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($classes as $cls)
                        <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/60 hover:bg-white hover:border-sky-300 hover:shadow-sm transition group">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md bg-white border border-slate-200 text-slate-600">
                                    {{ $cls->grade_level }}
                                </span>
                                <span class="text-xs font-bold text-sky-600">
                                    {{ $cls->students_count }} Students
                                </span>
                            </div>
                            <h4 class="font-bold text-slate-900 text-base group-hover:text-sky-600 transition truncate">
                                {{ $cls->class_name }}
                            </h4>
                            <p class="text-xs text-slate-500 mt-1 flex items-center space-x-1">
                                <i class="fa-solid fa-location-dot text-[10px] text-slate-400"></i>
                                <span>{{ $cls->room ?? 'Assigned Room' }}</span>
                            </p>
                            <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-between">
                                <a href="{{ route('teacher.my-students') }}" class="text-xs font-bold text-slate-700 hover:text-sky-600 transition">
                                    Roster
                                </a>
                                <a href="{{ route('teacher.attendance.index') }}?class_id={{ $cls->id }}" class="text-xs font-bold text-sky-600 hover:text-sky-700 transition">
                                    Attendance
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Recent Enrolled Students Preview Table -->
                <div class="pt-2">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500">Recent Students in Advisory</h4>
                        <a href="{{ route('teacher.my-students') }}" class="text-xs font-semibold text-slate-500 hover:text-sky-600">
                            See Full Roster ({{ $totalStudents }})
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-600">
                            <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] border-b border-slate-200">
                                <tr>
                                    <th class="py-2.5 px-3">Student Name</th>
                                    <th class="py-2.5 px-3">LRN</th>
                                    <th class="py-2.5 px-3">Gender</th>
                                    <th class="py-2.5 px-3">Section</th>
                                    <th class="py-2.5 px-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($recentStudents as $student)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-2.5 px-3 font-bold text-slate-900 flex items-center space-x-2">
                                            <div class="w-6 h-6 rounded-full bg-sky-100 text-sky-700 font-bold text-xs flex items-center justify-center">
                                                {{ substr($student->first_name, 0, 1) }}
                                            </div>
                                            <span>{{ $student->last_name }}, {{ $student->first_name }}</span>
                                        </td>
                                        <td class="py-2.5 px-3 font-mono text-slate-500">{{ $student->lrn }}</td>
                                        <td class="py-2.5 px-3">{{ $student->gender ?? '—' }}</td>
                                        <td class="py-2.5 px-3">
                                            <span class="px-2 py-0.5 rounded-full bg-slate-100 font-semibold text-slate-700 text-[10px]">
                                                Grade 4 - Diamond
                                            </span>
                                        </td>
                                        <td class="py-2.5 px-3 text-right">
                                            <a href="{{ route('teacher.my-students') }}?search={{ $student->last_name }}" class="text-sky-600 font-bold hover:underline">
                                                Profile
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 text-center text-slate-400">No students found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Quick Teacher Shortcuts & Today's Schedule (1 col) -->
            <div class="space-y-6">
                
                <!-- Quick Daily Timetable -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Today's Schedule</h3>
                            <p class="text-xs text-slate-500">Monday Class Bell Times</p>
                        </div>
                        <a href="{{ route('teacher.schedule.index') }}" class="text-xs font-bold text-sky-600 hover:text-sky-700 transition">
                            Full Week →
                        </a>
                    </div>

                    <div class="space-y-2.5">
                        <div class="p-3 rounded-2xl bg-sky-50/70 border border-sky-100 flex items-start space-x-3">
                            <span class="text-xs font-bold text-sky-700 bg-white px-2 py-1 rounded-lg shrink-0 border border-sky-200">
                                7:30 AM
                            </span>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Flag Ceremony & Homeroom</p>
                                <p class="text-[11px] text-slate-500">Grade 4 - Diamond • Room 204</p>
                            </div>
                        </div>

                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-start space-x-3">
                            <span class="text-xs font-bold text-slate-700 bg-white px-2 py-1 rounded-lg shrink-0 border border-slate-200">
                                8:00 AM
                            </span>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Mathematics</p>
                                <p class="text-[11px] text-slate-500">Grade 4 - Diamond • Lesson 8: Fractions</p>
                            </div>
                        </div>

                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-start space-x-3">
                            <span class="text-xs font-bold text-slate-700 bg-white px-2 py-1 rounded-lg shrink-0 border border-slate-200">
                                9:30 AM
                            </span>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Science & Health</p>
                                <p class="text-[11px] text-slate-500">Grade 5 - Sapphire • Room 102</p>
                            </div>
                        </div>

                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-start space-x-3">
                            <span class="text-xs font-bold text-slate-700 bg-white px-2 py-1 rounded-lg shrink-0 border border-slate-200">
                                1:00 PM
                            </span>
                            <div>
                                <p class="text-xs font-bold text-slate-900">English Reading Comprehension</p>
                                <p class="text-[11px] text-slate-500">Grade 6 - Emerald • Room 301</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Teacher Quick Tool Shortcuts -->
                <div class="bg-gradient-to-br from-[#101a2a] to-[#1e293b] rounded-3xl p-6 text-white shadow-md space-y-4">
                    <h3 class="text-sm font-bold tracking-wide uppercase text-sky-400">
                        Quick Teacher Actions
                    </h3>
                    <div class="grid grid-cols-2 gap-2.5">
                        <button type="button" 
                                @click="showAssignmentModal = true"
                                class="p-3 rounded-2xl bg-white/10 hover:bg-white/20 transition text-left cursor-pointer border border-white/10 group">
                            <i class="fa-solid fa-plus text-sky-400 mb-1.5 block group-hover:scale-110 transition-transform"></i>
                            <span class="text-xs font-bold block">Assignment</span>
                            <span class="text-[10px] text-slate-400">Post homework</span>
                        </button>

                        <button type="button" 
                                @click="showAnnouncementModal = true"
                                class="p-3 rounded-2xl bg-white/10 hover:bg-white/20 transition text-left cursor-pointer border border-white/10 group">
                            <i class="fa-solid fa-bullhorn text-amber-400 mb-1.5 block group-hover:scale-110 transition-transform"></i>
                            <span class="text-xs font-bold block">Announcement</span>
                            <span class="text-[10px] text-slate-400">Notify parents</span>
                        </button>

                        <button type="button" 
                                @click="showUploadModal = true"
                                class="p-3 rounded-2xl bg-white/10 hover:bg-white/20 transition text-left cursor-pointer border border-white/10 group">
                            <i class="fa-solid fa-cloud-arrow-up text-emerald-400 mb-1.5 block group-hover:scale-110 transition-transform"></i>
                            <span class="text-xs font-bold block">Module / SLM</span>
                            <span class="text-[10px] text-slate-400">Upload lesson</span>
                        </button>

                        <a href="{{ route('teacher.messages.index') }}" 
                           class="p-3 rounded-2xl bg-white/10 hover:bg-white/20 transition text-left cursor-pointer border border-white/10 group block">
                            <i class="fa-solid fa-comment-dots text-purple-400 mb-1.5 block group-hover:scale-110 transition-transform"></i>
                            <span class="text-xs font-bold block">Chat Inbox</span>
                            <span class="text-[10px] text-slate-400">3 Unread msgs</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

</x-teacher-layout>
