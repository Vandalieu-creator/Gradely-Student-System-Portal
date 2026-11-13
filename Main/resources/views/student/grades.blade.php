<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ginatilan Elementary School - View My Grades</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Alpine.js for interactive grade & quarter switching -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandTeal: '#459885',
                        brandTealHover: '#377A6B',
                        darkText: '#2D3748',
                        kidPurple: '#C084FC',
                        kidPink: '#F472B6',
                        kidYellow: '#FDE047',
                        kidGreen: '#4ADE80',
                        kidOrange: '#FB923C',
                        kidBlue: '#38BDF8'
                    },
                    fontFamily: {
                        sans: ['Fredoka', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }
    </style>
</head>
@php
    $studentRecord = \App\Models\Student::with(['schoolClass.teacher'])
        ->where('lrn', Auth::user()->lrn ?? '')
        ->first();

    $gradeLevel = $studentRecord?->schoolClass?->grade_level ?? 'Grade 1';
    $sectionName = $studentRecord?->schoolClass?->section ?? 'Section A';
    $adviser = $studentRecord?->schoolClass?->teacher;
    $adviserName = $adviser
        ? trim($adviser->first_name . ' ' . $adviser->last_name)
        : 'Unassigned Teacher';

    $currentGradeNum = (int) preg_replace('/\D/', '', $gradeLevel) ?: 1;
@endphp
<body class="bg-gradient-to-br from-teal-300 via-sky-400 to-pink-200 min-h-screen text-darkText font-sans antialiased overflow-x-hidden"
      x-data="{ 
          selectedGrade: new URLSearchParams(window.location.search).get('grade') || null,
          selectedQuarter: ['q1', 'q2', 'q3'].includes(new URLSearchParams(window.location.search).get('quarter')) ? new URLSearchParams(window.location.search).get('quarter') : null,
          showModal: false, 
          showTeacherModal: false,
          showScheduleModal: false,
          showHelpModal: false,
          showToast: false,
          teacherMessage: '',
          taskDone: false, 
          stars: 125,
          sidebarCollapsed: localStorage.getItem('gradely_student_sidebar_collapsed') === 'true',
          mobileSidebarOpen: false,
          showQuickFind: false,
          quickSearchQuery: '',
          adviserName: @js($adviserName),
          currentSection: @js($sectionName),
          currentGradeNum: @js($currentGradeNum),

          // Grade 1 to Grade 6 Data dynamically synced with student's current Grade, Section & Teacher
          gradeLevels: [
              {
                  id: 'g1',
                  num: 1,
                  label: 'Grade 1',
                  schoolYear: {{ $currentGradeNum >= 1 ? "'2026-2027'" : 'null' }},
                  section: {{ $currentGradeNum === 1 ? \Illuminate\Support\Js::from($sectionName) : 'null' }},
                  status: {{ $currentGradeNum === 1 ? "'Current'" : ($currentGradeNum > 1 ? "'Completed'" : "'Upcoming'") }},
                  icon: '🌟',
                  subjects: {
                      q1: [
                          { name: 'Mathematics', teacher: @js($adviserName), grade: 92, remarks: 'Passed' },
                          { name: 'Mother Tongue', teacher: @js($adviserName), grade: 91, remarks: 'Passed' },
                          { name: 'Filipino', teacher: @js($adviserName), grade: 90, remarks: 'Passed' },
                          { name: 'Araling Panlipunan', teacher: @js($adviserName), grade: 93, remarks: 'Passed' },
                          { name: 'MAPEH', teacher: @js($adviserName), grade: 94, remarks: 'Passed' }
                      ],
                      q2: [
                          { name: 'Mathematics', teacher: @js($adviserName), grade: 94, remarks: 'Passed' },
                          { name: 'Mother Tongue', teacher: @js($adviserName), grade: 92, remarks: 'Passed' },
                          { name: 'Filipino', teacher: @js($adviserName), grade: 91, remarks: 'Passed' },
                          { name: 'Araling Panlipunan', teacher: @js($adviserName), grade: 94, remarks: 'Passed' },
                          { name: 'MAPEH', teacher: @js($adviserName), grade: 95, remarks: 'Passed' }
                      ],
                      q3: []
                  }
              },
              {
                  id: 'g2',
                  num: 2,
                  label: 'Grade 2',
                  schoolYear: {{ $currentGradeNum === 2 ? "'2026-2027'" : 'null' }},
                  section: {{ $currentGradeNum === 2 ? \Illuminate\Support\Js::from($sectionName) : 'null' }},
                  status: {{ $currentGradeNum === 2 ? "'Current'" : ($currentGradeNum > 2 ? "'Completed'" : "'Upcoming'") }},
                  icon: '📚',
                  subjects: { q1: [], q2: [], q3: [] }
              },
              {
                  id: 'g3',
                  num: 3,
                  label: 'Grade 3',
                  schoolYear: {{ $currentGradeNum === 3 ? "'2026-2027'" : 'null' }},
                  section: {{ $currentGradeNum === 3 ? \Illuminate\Support\Js::from($sectionName) : 'null' }},
                  status: {{ $currentGradeNum === 3 ? "'Current'" : ($currentGradeNum > 3 ? "'Completed'" : "'Upcoming'") }},
                  icon: '✏️',
                  subjects: { q1: [], q2: [], q3: [] }
              },
              {
                  id: 'g4',
                  num: 4,
                  label: 'Grade 4',
                  schoolYear: {{ $currentGradeNum === 4 ? "'2026-2027'" : 'null' }},
                  section: {{ $currentGradeNum === 4 ? \Illuminate\Support\Js::from($sectionName) : 'null' }},
                  status: {{ $currentGradeNum === 4 ? "'Current'" : ($currentGradeNum > 4 ? "'Completed'" : "'Upcoming'") }},
                  icon: '📘',
                  subjects: { q1: [], q2: [], q3: [] }
              },
              {
                  id: 'g5',
                  num: 5,
                  label: 'Grade 5',
                  schoolYear: {{ $currentGradeNum === 5 ? "'2026-2027'" : 'null' }},
                  section: {{ $currentGradeNum === 5 ? \Illuminate\Support\Js::from($sectionName) : 'null' }},
                  status: {{ $currentGradeNum === 5 ? "'Current'" : ($currentGradeNum > 5 ? "'Completed'" : "'Upcoming'") }},
                  icon: '🔬',
                  subjects: { q1: [], q2: [], q3: [] }
              },
              {
                  id: 'g6',
                  num: 6,
                  label: 'Grade 6',
                  schoolYear: {{ $currentGradeNum === 6 ? "'2026-2027'" : 'null' }},
                  section: {{ $currentGradeNum === 6 ? \Illuminate\Support\Js::from($sectionName) : 'null' }},
                  status: {{ $currentGradeNum === 6 ? "'Current'" : "'Upcoming'" }},
                  icon: '🎓',
                  subjects: { q1: [], q2: [], q3: [] }
              }
          ],

          selectGrade(gradeId) {
              this.selectedGrade = gradeId;
              this.selectedQuarter = null;
          },

          get currentGradeObj() {
              return this.gradeLevels.find(g => g.id === this.selectedGrade) || null;
          },

          get currentSubjects() {
              if (!this.currentGradeObj || !this.selectedQuarter) return [];
              return this.currentGradeObj.subjects[this.selectedQuarter] || [];
          },

          get quarterlyAverage() {
              const list = this.currentSubjects;
              if (!list.length) return null;
              const sum = list.reduce((acc, item) => acc + Number(item.grade), 0);
              return (sum / list.length).toFixed(1);
          },

          toggleSidebar() {
              this.sidebarCollapsed = !this.sidebarCollapsed;
              localStorage.setItem('gradely_student_sidebar_collapsed', this.sidebarCollapsed);
          },
          sendTeacherMessage() {
              if (this.teacherMessage.trim() === '') return;
              this.showTeacherModal = false;
              this.teacherMessage = '';
              this.showToast = true;
              setTimeout(() => { this.showToast = false; }, 3500);
          }
      }">

    <!-- Global Modals (Teacher Chat, Homework, Schedule, Guide, Toast) -->
    @include('student.partials.student-modals', [
        'adviserName' => $adviserName,
        'gradeLevel' => $gradeLevel,
        'sectionName' => $sectionName,
    ])

    <!-- Quick Find Global Modal -->
    @include('student.partials.quick-find')

    <!-- Layout Wrapper with Sidebar -->
    <div class="min-h-screen flex flex-row relative">

        <!-- Desktop Sidebar (Sticky left) -->
        <div class="hidden md:block shrink-0 sticky top-0 h-screen">
            @include('student.partials.sidebar', ['active' => 'grades'])
        </div>

        <!-- Mobile Drawer Sidebar (< md) -->
        <div x-show="mobileSidebarOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="md:hidden fixed inset-0 z-50 flex"
             style="display: none;">
            
            <!-- Backdrop -->
            <div @click="mobileSidebarOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-xs"></div>

            <!-- Drawer Container -->
            <div class="relative flex-1 flex flex-col max-w-[270px] w-full h-full z-10 shadow-2xl">
                <!-- Mobile Close Button -->
                <button @click="mobileSidebarOpen = false" 
                        class="absolute top-3 right-3 z-50 h-8 w-8 rounded-full bg-slate-800/80 text-white flex items-center justify-center border border-white/20 cursor-pointer shadow-md">
                    ✕
                </button>
                @include('student.partials.sidebar', ['active' => 'grades'])
            </div>
        </div>

        <!-- Main Content Column -->
        <div class="flex-1 flex flex-col min-w-0 min-h-screen">
            
            <!-- Mobile Header Bar (< md) -->
            <div class="md:hidden flex items-center justify-between px-4 py-3 bg-[#101a2a] text-white shadow-md sticky top-0 z-30 border-b border-white/10">
                <div class="flex items-center space-x-3">
                    <button @click="mobileSidebarOpen = true" 
                            class="p-2 rounded-xl bg-white/10 hover:bg-white/20 text-white cursor-pointer focus:outline-none">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    
                    <div class="flex items-center space-x-2 bg-[#00adef] px-3 py-1.5 rounded-xl text-white shadow-xs">
                        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 4.5c1.2-1.5 2.8-2.5 4.5-2.5 0 2-1 3.5-2.5 4.5"/>
                            <path d="M8.5 7.5C5.5 7.5 3 9.8 3 13.5c0 4.5 3.2 8.5 6 8.5 1.4 0 2.2-.8 3-0.8s1.6.8 3 .8c2.8 0 6-4 6-8.5 0-3.7-2.5-6-5.5-6-1.5 0-2.8.8-3.5 1.5-.7-.7-2-1.5-3.5-1.5z"/>
                        </svg>
                        <span class="text-xs font-bold">Student</span>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <button @click="showQuickFind = true" class="p-2 rounded-xl bg-white/10 text-slate-300 hover:text-white cursor-pointer">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Page Main Content -->
            <main class="flex-1 p-3 sm:p-6 lg:p-8 flex justify-center items-start">
                <div class="w-full max-w-5xl bg-white/70 backdrop-blur-xl rounded-[2.5rem] shadow-2xl p-6 sm:p-8 border border-white flex flex-col gap-6">

                    <!-- Header Bar -->
                    <header class="bg-white/80 backdrop-blur-md rounded-[2rem] p-6 text-darkText flex flex-col sm:flex-row items-center justify-between gap-4 border border-white shadow-sm">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('images/school-logo2.png') }}" alt="School Logo" class="w-16 h-16 rounded-full border-2 border-white shadow-md object-cover bg-white">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-800">View My Grades 📊</h1>
                                <p class="text-xs text-teal-800 font-semibold uppercase tracking-wider">
                                    Ginatilan Elementary School &bull; {{ $gradeLevel }} - {{ $sectionName }}
                                </p>
                            </div>
                        </div>

                        <!-- Back to Dashboard Link -->
                        <a href="{{ route('student.dashboard') }}" class="bg-white/80 hover:bg-white text-slate-700 font-medium px-4 py-2 rounded-2xl border border-white shadow-sm transition flex items-center space-x-2 text-sm">
                            <i class="fa-solid fa-arrow-left text-xs"></i>
                            <span>Back to Dashboard</span>
                        </a>
                    </header>

                    <!-- STEP 1: Grade Level & School Year Selection (Grades 1 to 6) -->
                    <section class="bg-white/60 border border-white p-6 rounded-3xl text-center shadow-xs">
                        <div class="inline-flex items-center gap-1.5 bg-teal-100 text-teal-800 text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full mb-2">
                            <i class="fa-solid fa-layer-group"></i>
                            <span>Step 1 of 2</span>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800 mb-1">Select Grade Level & School Year</h2>
                        <p class="text-xs text-slate-600 mb-5">Choose your current grade or a previous school year to view your report cards:</p>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                            <template x-for="grade in gradeLevels" :key="grade.id">
                                <button @click="selectGrade(grade.id)"
                                        :class="selectedGrade === grade.id 
                                            ? 'bg-teal-600 text-white shadow-lg scale-[1.02] border-teal-700' 
                                            : (grade.status === 'Upcoming' ? 'bg-white/50 text-slate-500 hover:bg-white/80 border-white/80' : 'bg-white/85 text-slate-700 hover:bg-white border-white')"
                                        class="p-4 rounded-2xl border-2 transition duration-200 flex flex-col items-center gap-1.5 shadow-xs cursor-pointer relative">
                                    
                                    <!-- Status Pill (Current vs Past SY vs Upcoming) -->
                                    <span :class="selectedGrade === grade.id 
                                            ? 'bg-white/20 text-white' 
                                            : (grade.status === 'Current' ? 'bg-amber-100 text-amber-800' : (grade.status === 'Completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200/70 text-slate-500'))"
                                          class="text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full"
                                          x-text="grade.status === 'Current' ? 'Current Grade' : (grade.status === 'Completed' ? 'Past SY' : 'Not Yet Enrolled')">
                                    </span>

                                    <span class="text-2xl mt-0.5" :class="grade.status === 'Upcoming' && selectedGrade !== grade.id ? 'opacity-60' : ''" x-text="grade.icon"></span>
                                    <span class="font-bold text-base" x-text="grade.label"></span>
                                    <span :class="selectedGrade === grade.id ? 'text-teal-100' : 'text-slate-500'"
                                          class="text-xs font-medium"
                                          x-text="grade.schoolYear ? ('SY ' + grade.schoolYear + ' • ' + grade.section) : 'No records yet'">
                                    </span>
                                </button>
                            </template>
                        </div>
                    </section>

                    <!-- Placeholder before selecting a Grade Level -->
                    <div x-show="!selectedGrade" class="bg-white/40 border border-white p-12 rounded-3xl text-center shadow-xs flex flex-col items-center justify-center">
                        <div class="w-16 h-16 bg-teal-100 text-teal-700 rounded-full flex items-center justify-center text-3xl mb-3 shadow-xs">
                            🎓
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">Please Select Your Grade Level First</h3>
                        <p class="text-xs text-slate-600 max-w-sm mt-1">Pick a grade level above to unlock the 1st to 3rd Quarter report cards for that school year.</p>
                    </div>

                    <!-- STEP 2: Quarter Selection Buttons (Revealed after choosing a Grade Level) -->
                    <section x-show="selectedGrade" x-transition.opacity class="bg-white/60 border border-white p-6 rounded-3xl text-center shadow-xs">
                        <div class="inline-flex items-center gap-1.5 bg-sky-100 text-sky-800 text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full mb-2">
                            <i class="fa-solid fa-calendar-check"></i>
                            <span x-text="'Step 2 of 2 • ' + (currentGradeObj ? currentGradeObj.label + (currentGradeObj.schoolYear ? ' (SY ' + currentGradeObj.schoolYear + ')' : '') : '')"></span>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800 mb-1">Select Grading Period</h2>
                        <p class="text-xs text-slate-600 mb-6">Choose a quarter below to reveal your report card for <span class="font-bold text-slate-800" x-text="currentGradeObj ? currentGradeObj.label : ''"></span>:</p>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                            
                            <!-- 1st Quarter -->
                            <button @click="selectedQuarter = 'q1'" 
                                    :class="selectedQuarter === 'q1' ? 'bg-teal-600 text-white shadow-lg scale-105 border-teal-700' : 'bg-white/80 text-slate-700 hover:bg-white border-white'"
                                    class="p-4 rounded-2xl border-2 font-bold text-sm sm:text-base transition duration-200 flex flex-col items-center gap-1 shadow-xs cursor-pointer">
                                <span class="text-2xl">🥇</span>
                                <span>1st Quarter</span>
                            </button>

                            <!-- 2nd Quarter -->
                            <button @click="selectedQuarter = 'q2'" 
                                    :class="selectedQuarter === 'q2' ? 'bg-teal-600 text-white shadow-lg scale-105 border-teal-700' : 'bg-white/80 text-slate-700 hover:bg-white border-white'"
                                    class="p-4 rounded-2xl border-2 font-bold text-sm sm:text-base transition duration-200 flex flex-col items-center gap-1 shadow-xs cursor-pointer">
                                <span class="text-2xl">🥈</span>
                                <span>2nd Quarter</span>
                            </button>

                            <!-- 3rd Quarter -->
                            <button @click="selectedQuarter = 'q3'" 
                                    :class="selectedQuarter === 'q3' ? 'bg-teal-600 text-white shadow-lg scale-105 border-teal-700' : 'bg-white/80 text-slate-700 hover:bg-white border-white'"
                                    class="p-4 rounded-2xl border-2 font-bold text-sm sm:text-base transition duration-200 flex flex-col items-center gap-1 shadow-xs cursor-pointer">
                                <span class="text-2xl">🥉</span>
                                <span>3rd Quarter</span>
                            </button>

                        </div>
                    </section>

                    <!-- Placeholder state after selecting Grade Level, before selecting a Quarter -->
                    <div x-show="selectedGrade && !selectedQuarter" class="bg-white/40 border border-white p-12 rounded-3xl text-center shadow-xs flex flex-col items-center justify-center">
                        <div class="w-16 h-16 bg-teal-100 text-teal-700 rounded-full flex items-center justify-center text-3xl mb-3 shadow-xs">
                            👆
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">Please Select a Quarter First</h3>
                        <p class="text-xs text-slate-600 max-w-sm mt-1">Click on any quarter button above to view your academic performance and grades for that period.</p>
                    </div>

                    <!-- STEP 3: Grades Tables (Revealed after selecting both Grade Level and Quarter) -->
                    <div x-show="selectedGrade && selectedQuarter" x-transition.opacity class="bg-white/80 border border-white p-6 rounded-3xl shadow-sm">
                        
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-4 border-b border-slate-200 pb-3">
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-graduation-cap text-teal-600"></i>
                                <span x-text="(currentGradeObj ? currentGradeObj.label + ' — ' : '') + (selectedQuarter === 'q1' ? '1st Quarter Report Card' : (selectedQuarter === 'q2' ? '2nd Quarter Report Card' : '3rd Quarter Report Card'))"></span>
                            </h3>
                            <span class="bg-teal-100 text-teal-800 font-bold px-3 py-1 rounded-full text-xs"
                                  x-text="currentGradeObj && currentGradeObj.schoolYear ? 'School Year ' + currentGradeObj.schoolYear : 'Upcoming Grade Level'">
                            </span>
                        </div>

                        <!-- Empty State if Grade Level is upcoming or Quarter has no grades yet -->
                        <div x-show="currentSubjects.length === 0" class="py-10 text-center">
                            <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-2xl mx-auto mb-3">
                                <span x-text="currentGradeObj && currentGradeObj.status === 'Upcoming' ? '🔒' : '⏳'"></span>
                            </div>
                            <h4 class="font-bold text-slate-800"
                                x-text="currentGradeObj && currentGradeObj.status === 'Upcoming' ? 'Not Enrolled in ' + currentGradeObj.label + ' Yet' : 'No Grades Posted Yet'">
                            </h4>
                            <p class="text-xs text-slate-500 mt-1"
                               x-text="currentGradeObj && currentGradeObj.status === 'Upcoming' ? 'Your report card for this grade level will appear once you advance to ' + currentGradeObj.label + '.' : 'Grades for this quarter have not been finalized by your teacher yet.'">
                            </p>
                        </div>

                        <!-- Grades Table -->
                        <div x-show="currentSubjects.length > 0">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm text-slate-700">
                                    <thead>
                                        <tr class="bg-teal-50/80 text-teal-800 text-xs uppercase font-bold border-b border-teal-100">
                                            <th class="py-3 px-4">Subject</th>
                                            <th class="py-3 px-4">Teacher</th>
                                            <th class="py-3 px-4 text-center">Grade</th>
                                            <th class="py-3 px-4 text-center">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 font-medium">
                                        <template x-for="(subj, index) in currentSubjects" :key="index">
                                            <tr class="hover:bg-white/60 transition">
                                                <td class="py-3 px-4 font-bold text-slate-800" x-text="subj.name"></td>
                                                <td class="py-3 px-4 text-slate-600" x-text="subj.teacher"></td>
                                                <td class="py-3 px-4 text-center font-bold text-teal-700 text-base" x-text="subj.grade"></td>
                                                <td class="py-3 px-4 text-center">
                                                    <span :class="subj.grade >= 75 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'"
                                                          class="text-xs px-2.5 py-1 rounded-full font-bold"
                                                          x-text="subj.remarks">
                                                    </span>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>

                            <!-- General Average Summary Banner -->
                            <div class="mt-6 p-4 rounded-2xl bg-teal-600 text-white flex justify-between items-center shadow-md">
                                <div>
                                    <p class="text-xs text-white/80 font-bold uppercase tracking-wider">Quarterly Average</p>
                                    <h4 class="text-2xl font-bold" x-text="quarterlyAverage + '% — ' + (quarterlyAverage >= 90 ? 'Outstanding! 🌟' : (quarterlyAverage >= 85 ? 'Very Satisfactory! 👏' : 'Satisfactory! 👍'))"></h4>
                                </div>
                                <button onclick="window.print()" class="bg-white/20 hover:bg-white/30 text-white font-medium text-xs px-4 py-2 rounded-xl transition flex items-center space-x-2 cursor-pointer">
                                    <i class="fa-solid fa-print"></i>
                                    <span>Print Card</span>
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </main>
        </div>

    </div>

</body>
</html>