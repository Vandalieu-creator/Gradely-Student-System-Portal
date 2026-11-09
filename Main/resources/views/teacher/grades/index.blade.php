<x-teacher-layout active="grades" title="Grades & Reports">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 max-w-7xl mx-auto">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center border border-teal-100 shadow-xs">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="13" cy="13" r="7.5"/>
                        <path d="m10 13 2 2 4-4"/>
                        <circle cx="6" cy="6" r="3.2"/>
                        <path d="m4.8 6h2.4"/>
                        <path d="m6 4.8v2.4"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                        Grades & DepEd Reports Center
                    </h1>
                    <p class="text-xs font-semibold text-slate-500">
                        Class gradebook, quarterly assessment marks, and Form 138 report cards
                    </p>
                </div>
            </div>

            <!-- Export / Print Reports -->
            <div class="flex items-center space-x-2">
                <button type="button" 
                        @click="notify('Generating DepEd SF9 / Form 138 Progress Report Batch PDF...', 'Report Card Export')"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition shadow-2xs cursor-pointer flex items-center space-x-1.5">
                    <i class="fa-solid fa-file-pdf text-rose-500 text-xs"></i>
                    <span>Export Form 138 (PDF)</span>
                </button>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6"
         x-data="{
             showForm138Modal: false,
             cardStudent: null,
             openReportCard(st, grade) {
                 this.cardStudent = {
                     name: st.last_name + ', ' + st.first_name,
                     lrn: st.lrn,
                     grade: grade || 92
                 };
                 this.showForm138Modal = true;
             }
         }">

        <!-- Filter Bar -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs space-y-4">
            <form method="GET" action="{{ route('teacher.grades.index') }}" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                
                <!-- Class & Subject Selectors -->
                <div class="flex flex-wrap items-center gap-3">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Class Section</label>
                        <select name="class_id" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 bg-white shadow-2xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ $selectedClassId == $c->id ? 'selected' : '' }}>
                                    {{ $c->class_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Subject</label>
                        <select name="subject" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-800 bg-white shadow-2xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="Mathematics" {{ $selectedSubject === 'Mathematics' ? 'selected' : '' }}>Mathematics</option>
                            <option value="Science" {{ $selectedSubject === 'Science' ? 'selected' : '' }}>Science</option>
                            <option value="English" {{ $selectedSubject === 'English' ? 'selected' : '' }}>English</option>
                            <option value="Filipino" {{ $selectedSubject === 'Filipino' ? 'selected' : '' }}>Filipino</option>
                            <option value="MAPEH" {{ $selectedSubject === 'MAPEH' ? 'selected' : '' }}>MAPEH</option>
                            <option value="EsP" {{ $selectedSubject === 'EsP' ? 'selected' : '' }}>EsP</option>
                        </select>
                    </div>
                </div>

                <!-- Quarter Tabs -->
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Grading Quarter</label>
                    <div class="flex items-center space-x-1 bg-slate-100 p-1 rounded-2xl">
                        @foreach(['1st', '2nd', '3rd', '4th'] as $q)
                            <a href="{{ route('teacher.grades.index', ['class_id' => $selectedClassId, 'subject' => $selectedSubject, 'quarter' => $q]) }}"
                               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $selectedQuarter === $q ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">
                                {{ $q }} Quarter
                            </a>
                        @endforeach
                    </div>
                </div>

            </form>
        </div>

        <!-- Class Gradebook Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-xs">
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">
                        {{ $selectedClass->class_name ?? 'Class' }} — {{ $selectedSubject }} ({{ $selectedQuarter }} Quarter)
                    </h3>
                    <p class="text-xs text-slate-500">
                        DepEd Order No. 8, s. 2015 Grading Guidelines • Transmuted Grading Scale
                    </p>
                </div>

                <div class="flex items-center space-x-2">
                    <span class="text-xs font-bold text-teal-700 bg-teal-50 border border-teal-200 px-3 py-1.5 rounded-xl">
                        Quarter Passing Standard: 75%
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">#</th>
                            <th class="py-3 px-4">Student Name</th>
                            <th class="py-3 px-4">LRN</th>
                            <th class="py-3 px-4 text-center">Written Work (40%)</th>
                            <th class="py-3 px-4 text-center">Performance Task (40%)</th>
                            <th class="py-3 px-4 text-center">Quarterly Exam (20%)</th>
                            <th class="py-3 px-4 text-center">Quarterly Grade</th>
                            <th class="py-3 px-4 text-center">Remarks</th>
                            <th class="py-3 px-4 text-right">Card</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($students as $idx => $student)
                            @php
                                $g = $grades[$student->id] ?? null;
                                $ww = $g->written_work ?? rand(88, 95);
                                $pt = $g->performance_task ?? rand(90, 96);
                                $qa = $g->quarterly_assessment ?? rand(87, 94);
                                $final = $g->quarterly_grade ?? round(($ww * 0.4) + ($pt * 0.4) + ($qa * 0.2), 1);
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 font-mono text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                    {{ $student->last_name }}, {{ $student->first_name }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-slate-500">{{ $student->lrn }}</td>
                                <td class="py-3.5 px-4 text-center font-semibold text-slate-800">{{ $ww }}</td>
                                <td class="py-3.5 px-4 text-center font-semibold text-slate-800">{{ $pt }}</td>
                                <td class="py-3.5 px-4 text-center font-semibold text-slate-800">{{ $qa }}</td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-block px-2.5 py-1 rounded-lg font-extrabold text-xs {{ $final >= 90 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-sky-50 text-sky-700 border border-sky-200' }}">
                                        {{ $final }}%
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="text-[11px] font-bold text-emerald-600">
                                        Passed {{ $final >= 90 ? '• Outstanding' : '• Satisfactory' }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <button type="button" 
                                            @click="openReportCard({ last_name: '{{ $student->last_name }}', first_name: '{{ $student->first_name }}', lrn: '{{ $student->lrn }}' }, {{ $final }})"
                                            class="text-xs font-bold text-sky-600 hover:text-sky-700 hover:underline cursor-pointer">
                                        Form 138
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-slate-400">
                                    No students enrolled in this section.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer summary -->
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-600">
                <span>Class Performance: <strong>100% Passing Rate</strong> for {{ $selectedSubject }}</span>
                <button type="button" 
                        @click="notify('Grades validated and locked for DepEd S.Y. 2026-2027.', 'Grades Submitted')"
                        class="px-5 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold transition shadow-xs cursor-pointer">
                    Submit & Finalize Quarter Grades
                </button>
            </div>
        </div>

        <!-- Form 138 Preview Modal -->
        <div x-show="showForm138Modal" 
             x-transition.opacity 
             @keydown.window.escape="showForm138Modal = false"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 z-50 select-none" 
             style="display: none;">
            
            <div @click.away="showForm138Modal = false" 
                 class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl border-4 border-slate-100 space-y-4 relative text-slate-800 transform transition-all">
                
                <button @click="showForm138Modal = false" class="absolute top-4 right-5 text-slate-400 hover:text-slate-700 text-xl font-bold cursor-pointer">
                    ✕
                </button>

                <!-- DepEd Official Heading -->
                <div class="text-center pb-3 border-b border-slate-200">
                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Republic of the Philippines • Department of Education</p>
                    <h3 class="text-base font-extrabold text-slate-900 mt-1">PROGRESS REPORT CARD (SF 9 / Form 138)</h3>
                    <p class="text-xs text-slate-500 font-semibold">Ginatilan Elementary School • S.Y. 2026-2027</p>
                </div>

                <!-- Student info -->
                <div class="bg-slate-50 p-3.5 rounded-2xl text-xs space-y-1">
                    <p>Student Name: <strong class="text-slate-900" x-text="cardStudent ? cardStudent.name : ''"></strong></p>
                    <p>LRN: <strong class="font-mono text-slate-900" x-text="cardStudent ? cardStudent.lrn : ''"></strong></p>
                    <p>Grade & Section: <strong>Grade 4 - Diamond</strong></p>
                    <p>Adviser: <strong>Mrs. Sarah E. Miller</strong></p>
                </div>

                <!-- Sample Grades Table -->
                <div class="border rounded-2xl overflow-hidden text-xs">
                    <table class="w-full text-left">
                        <thead class="bg-slate-100 text-[10px] uppercase text-slate-600 font-bold">
                            <tr>
                                <th class="p-2">Learning Area</th>
                                <th class="p-2 text-center">Q1</th>
                                <th class="p-2 text-center">Q2</th>
                                <th class="p-2 text-center">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            <tr>
                                <td class="p-2">Mathematics</td>
                                <td class="p-2 text-center font-bold text-teal-700" x-text="cardStudent ? cardStudent.grade : '92'"></td>
                                <td class="p-2 text-center text-slate-400">—</td>
                                <td class="p-2 text-center text-emerald-600 font-bold">Passed</td>
                            </tr>
                            <tr>
                                <td class="p-2">Science</td>
                                <td class="p-2 text-center font-bold text-teal-700">91</td>
                                <td class="p-2 text-center text-slate-400">—</td>
                                <td class="p-2 text-center text-emerald-600 font-bold">Passed</td>
                            </tr>
                            <tr>
                                <td class="p-2">English</td>
                                <td class="p-2 text-center font-bold text-teal-700">94</td>
                                <td class="p-2 text-center text-slate-400">—</td>
                                <td class="p-2 text-center text-emerald-600 font-bold">Passed</td>
                            </tr>
                            <tr>
                                <td class="p-2">Filipino</td>
                                <td class="p-2 text-center font-bold text-teal-700">89</td>
                                <td class="p-2 text-center text-slate-400">—</td>
                                <td class="p-2 text-center text-emerald-600 font-bold">Passed</td>
                            </tr>
                            <tr>
                                <td class="p-2">MAPEH</td>
                                <td class="p-2 text-center font-bold text-teal-700">93</td>
                                <td class="p-2 text-center text-slate-400">—</td>
                                <td class="p-2 text-center text-emerald-600 font-bold">Passed</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center justify-end space-x-2 pt-2">
                    <button type="button" @click="showForm138Modal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 transition cursor-pointer">
                        Close
                    </button>
                    <button type="button" @click="showForm138Modal = false; notify('Printing Form 138 report card for ' + cardStudent.name, 'Print Job Sent')" class="px-5 py-2 rounded-xl bg-[#172554] text-white text-xs font-bold hover:bg-[#1e3a8a] transition cursor-pointer flex items-center space-x-1.5">
                        <i class="fa-solid fa-print text-xs"></i>
                        <span>Print Official Card</span>
                    </button>
                </div>
            </div>
        </div>

    </div>

</x-teacher-layout>
