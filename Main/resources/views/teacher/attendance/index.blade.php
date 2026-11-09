<x-teacher-layout active="attendance" title="Attendance Roll Call">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 max-w-7xl mx-auto">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 shadow-xs">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                        <path d="m9 16 2 2 4-4"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                        Daily Roll Call & Attendance
                    </h1>
                    <p class="text-xs font-semibold text-slate-500">
                        Record and monitor classroom daily student attendance
                    </p>
                </div>
            </div>

            <!-- Date & Class filter bar -->
            <form method="GET" action="{{ route('teacher.attendance.index') }}" class="flex flex-wrap items-center gap-2">
                <select name="class_id" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 bg-white shadow-2xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ $selectedClassId == $c->id ? 'selected' : '' }}>
                            {{ $c->class_name }}
                        </option>
                    @endforeach
                </select>

                <input type="date" 
                       name="date" 
                       value="{{ $selectedDate }}" 
                       onchange="this.form.submit()"
                       class="px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 bg-white shadow-2xs focus:outline-none focus:ring-2 focus:ring-amber-500">
            </form>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6"
         x-data="{
             attendance: {
                 @foreach($students as $st)
                     '{{ $st->id }}': '{{ $attendanceRecords[$st->id]->status ?? 'present' }}',
                 @endforeach
             },
             markAll(status) {
                 for (let key in this.attendance) {
                     this.attendance[key] = status;
                 }
                 notify('All students marked as ' + status.toUpperCase() + '!', 'Batch Attendance');
             },
             get countPresent() {
                 return Object.values(this.attendance).filter(s => s === 'present').length;
             },
             get countLate() {
                 return Object.values(this.attendance).filter(s => s === 'late').length;
             },
             get countAbsent() {
                 return Object.values(this.attendance).filter(s => s === 'absent').length;
             },
             get countExcused() {
                 return Object.values(this.attendance).filter(s => s === 'excused').length;
             }
         }">

        <!-- Success Toast Alert -->
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3.5 text-sm font-semibold text-emerald-800 flex items-center space-x-2">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Summary KPI Metrics Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Present</span>
                    <p class="text-2xl font-extrabold text-emerald-600" x-text="countPresent"></p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    ✓
                </div>
            </div>

            <div class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Late</span>
                    <p class="text-2xl font-extrabold text-amber-600" x-text="countLate"></p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                    ⏰
                </div>
            </div>

            <div class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Absent</span>
                    <p class="text-2xl font-extrabold text-rose-600" x-text="countAbsent"></p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                    ✕
                </div>
            </div>

            <div class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Excused</span>
                    <p class="text-2xl font-extrabold text-sky-600" x-text="countExcused"></p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold">
                    📋
                </div>
            </div>
        </div>

        <!-- Attendance Form Container -->
        <form method="POST" action="{{ route('teacher.attendance.store') }}" class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-xs">
            @csrf
            <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
            <input type="hidden" name="attendance_date" value="{{ $selectedDate }}">

            <!-- Action Bar -->
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">
                        {{ $selectedClass->class_name ?? 'Classroom' }} — {{ date('F d, Y (l)', strtotime($selectedDate)) }}
                    </h3>
                    <p class="text-xs text-slate-500">
                        {{ $students->count() }} students enrolled in this section
                    </p>
                </div>

                <div class="flex items-center space-x-2">
                    <button type="button" 
                            @click="markAll('present')" 
                            class="px-3.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold transition border border-emerald-200 cursor-pointer">
                        Mark All Present
                    </button>
                    <button type="submit" 
                            class="px-5 py-2 rounded-xl bg-[#172554] hover:bg-[#1e3a8a] text-white text-xs font-bold shadow-md transition flex items-center space-x-1.5 cursor-pointer">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Save Attendance</span>
                    </button>
                </div>
            </div>

            <!-- Student Roll Call Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">#</th>
                            <th class="py-3 px-4">Student Name</th>
                            <th class="py-3 px-4">LRN</th>
                            <th class="py-3 px-4">Gender</th>
                            <th class="py-3 px-4 text-center">Attendance Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($students as $index => $student)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 font-mono text-slate-400">{{ $index + 1 }}</td>
                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                    <div class="flex items-center space-x-2.5">
                                        <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold text-xs flex items-center justify-center">
                                            {{ substr($student->first_name, 0, 1) }}
                                        </div>
                                        <span>{{ $student->last_name }}, {{ $student->first_name }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-slate-500">{{ $student->lrn }}</td>
                                <td class="py-3.5 px-4">{{ $student->gender ?? '—' }}</td>
                                <td class="py-3.5 px-4">
                                    <input type="hidden" name="attendance[{{ $student->id }}]" :value="attendance['{{ $student->id }}']">
                                    <div class="flex items-center justify-center space-x-1.5">
                                        
                                        <!-- Present -->
                                        <button type="button" 
                                                @click="attendance['{{ $student->id }}'] = 'present'"
                                                :class="attendance['{{ $student->id }}'] === 'present' ? 'bg-emerald-600 text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                                class="px-3 py-1 rounded-lg text-xs transition cursor-pointer">
                                            Present
                                        </button>

                                        <!-- Late -->
                                        <button type="button" 
                                                @click="attendance['{{ $student->id }}'] = 'late'"
                                                :class="attendance['{{ $student->id }}'] === 'late' ? 'bg-amber-500 text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                                class="px-3 py-1 rounded-lg text-xs transition cursor-pointer">
                                            Late
                                        </button>

                                        <!-- Absent -->
                                        <button type="button" 
                                                @click="attendance['{{ $student->id }}'] = 'absent'"
                                                :class="attendance['{{ $student->id }}'] === 'absent' ? 'bg-rose-600 text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                                class="px-3 py-1 rounded-lg text-xs transition cursor-pointer">
                                            Absent
                                        </button>

                                        <!-- Excused -->
                                        <button type="button" 
                                                @click="attendance['{{ $student->id }}'] = 'excused'"
                                                :class="attendance['{{ $student->id }}'] === 'excused' ? 'bg-sky-600 text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                                class="px-3 py-1 rounded-lg text-xs transition cursor-pointer">
                                            Excused
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    No students enrolled in this classroom.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Bottom Save Bar -->
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-500">
                    Changes will be saved to DepEd attendance records for S.Y. 2026-2027.
                </span>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-[#172554] hover:bg-[#1e3a8a] text-white text-xs font-bold shadow-md transition flex items-center space-x-1.5 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Save Daily Attendance</span>
                </button>
            </div>
        </form>

    </div>

</x-teacher-layout>
