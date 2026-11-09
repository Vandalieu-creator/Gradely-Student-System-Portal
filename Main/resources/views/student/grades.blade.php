<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ginatilan Elementary School - View My Grades</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Alpine.js for interactive quarter switching -->
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
<body class="bg-gradient-to-br from-teal-300 via-sky-400 to-pink-200 min-h-screen text-darkText font-sans antialiased overflow-x-hidden"
      x-data="{ 
          selectedQuarter: new URLSearchParams(window.location.search).get('quarter') || null,
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
    @include('student.partials.student-modals')

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
                            <img src="https://scontent.fcgy1-3.fna.fbcdn.net/v/t39.30808-6/306785656_399144949050859_6940190266702559829_n.jpg?stp=dst-jpg_tt6&cstp=mx828x826&ctp=s828x826&_nc_cat=107&_nc_map=urlgen_bucketless&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeF9qZjwNm8ws90wGeOqub0Eo6zNz6rPh_OjrM3Pqs-H8wS5n8vDVhoVtTSS4_xuRAJgS26g3wgxBi6xKpoNHqQ5&_nc_ohc=FW-j_FEzrbcQ7kNvwEwT63b&_nc_oc=AdrKR7rNle1H8gKGVImclHZmMCgu58CsqQTjszwsTg1EfbYrGyXL7wR3C1jQ81nAnu0&_nc_zt=23&_nc_ht=scontent.fcgy1-3.fna&_nc_gid=sIjMlVk-b2AmePncb3Dw0A&_nc_ss=7b2a8&oh=00_AQMDhpAOFSUOYgN6PLYNdW2XC2g2FOQwICPTaKPcFaF_LQ&oe=6AD7D0A2" alt="School Logo" class="w-16 h-16 rounded-full border-2 border-white shadow-md object-cover bg-white">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-800">View My Grades 📊</h1>
                                <p class="text-xs text-teal-800 font-semibold uppercase tracking-wider">Ginatilan Elementary School</p>
                            </div>
                        </div>

                        <!-- Back to Dashboard Link -->
                        <a href="{{ route('student.dashboard') }}" class="bg-white/80 hover:bg-white text-slate-700 font-medium px-4 py-2 rounded-2xl border border-white shadow-sm transition flex items-center space-x-2 text-sm">
                            <i class="fa-solid fa-arrow-left text-xs"></i>
                            <span>Back to Dashboard</span>
                        </a>
                    </header>

                    <!-- STEP 1: Quarter Selection Buttons -->
                    <section class="bg-white/60 border border-white p-6 rounded-3xl text-center shadow-xs">
                        <h2 class="text-lg font-bold text-slate-800 mb-2">Select Grading Period</h2>
                        <p class="text-xs text-slate-600 mb-6">Choose a quarter below to reveal your report card for that period:</p>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                            
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

                            <!-- 4th Quarter -->
                            <button @click="selectedQuarter = 'q4'" 
                                    :class="selectedQuarter === 'q4' ? 'bg-teal-600 text-white shadow-lg scale-105 border-teal-700' : 'bg-white/80 text-slate-700 hover:bg-white border-white'"
                                    class="p-4 rounded-2xl border-2 font-bold text-sm sm:text-base transition duration-200 flex flex-col items-center gap-1 shadow-xs cursor-pointer">
                                <span class="text-2xl">🏆</span>
                                <span>4th Quarter</span>
                            </button>

                        </div>
                    </section>

                    <!-- STEP 2: Placeholder state before selecting a quarter -->
                    <div x-show="!selectedQuarter" class="bg-white/40 border border-white p-12 rounded-3xl text-center shadow-xs flex flex-col items-center justify-center">
                        <div class="w-16 h-16 bg-teal-100 text-teal-700 rounded-full flex items-center justify-center text-3xl mb-3 shadow-xs">
                            👆
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">Please Select a Quarter First</h3>
                        <p class="text-xs text-slate-600 max-w-sm mt-1">Click on any quarter button above to view your academic performance and grades for that period.</p>
                    </div>

                    <!-- STEP 3: Grades Tables (Revealed after selecting a quarter) -->
                    <div x-show="selectedQuarter" x-transition.opacity class="bg-white/80 border border-white p-6 rounded-3xl shadow-sm">
                        
                        <div class="flex items-center justify-between mb-4 border-b border-slate-200 pb-3">
                            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-graduation-cap text-teal-600"></i>
                                <span x-text="selectedQuarter === 'q1' ? '1st Quarter Report Card' : (selectedQuarter === 'q2' ? '2nd Quarter Report Card' : (selectedQuarter === 'q3' ? '3rd Quarter Report Card' : '4th Quarter Report Card'))"></span>
                            </h3>
                            <span class="bg-teal-100 text-teal-800 font-bold px-3 py-1 rounded-full text-xs">School Year 2025-2026</span>
                        </div>

                        <!-- Grades Table -->
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
                                    
                                    <!-- Row 1: Mathematics -->
                                    <tr class="hover:bg-white/60 transition">
                                        <td class="py-3 px-4 font-bold text-slate-800">Mathematics</td>
                                        <td class="py-3 px-4 text-slate-600">Mrs. Miller</td>
                                        <td class="py-3 px-4 text-center font-bold text-teal-700 text-base">92</td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="bg-emerald-100 text-emerald-700 text-xs px-2.5 py-1 rounded-full font-bold">Passed</span>
                                        </td>
                                    </tr>

                                    <!-- Row 2: Science -->
                                    <tr class="hover:bg-white/60 transition">
                                        <td class="py-3 px-4 font-bold text-slate-800">Science</td>
                                        <td class="py-3 px-4 text-slate-600">Mr. Garcia</td>
                                        <td class="py-3 px-4 text-center font-bold text-teal-700 text-base">88</td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="bg-emerald-100 text-emerald-700 text-xs px-2.5 py-1 rounded-full font-bold">Passed</span>
                                        </td>
                                    </tr>

                                    <!-- Row 3: English / Reading -->
                                    <tr class="hover:bg-white/60 transition">
                                        <td class="py-3 px-4 font-bold text-slate-800">English / Reading</td>
                                        <td class="py-3 px-4 text-slate-600">Ms. Lopez</td>
                                        <td class="py-3 px-4 text-center font-bold text-teal-700 text-base">95</td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="bg-emerald-100 text-emerald-700 text-xs px-2.5 py-1 rounded-full font-bold">Passed</span>
                                        </td>
                                    </tr>

                                    <!-- Row 4: Filipino -->
                                    <tr class="hover:bg-white/60 transition">
                                        <td class="py-3 px-4 font-bold text-slate-800">Filipino</td>
                                        <td class="py-3 px-4 text-slate-600">Mrs. Santos</td>
                                        <td class="py-3 px-4 text-center font-bold text-teal-700 text-base">90</td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="bg-emerald-100 text-emerald-700 text-xs px-2.5 py-1 rounded-full font-bold">Passed</span>
                                        </td>
                                    </tr>

                                    <!-- Row 5: MAPEH -->
                                    <tr class="hover:bg-white/60 transition">
                                        <td class="py-3 px-4 font-bold text-slate-800">MAPEH</td>
                                        <td class="py-3 px-4 text-slate-600">Mr. Cruz</td>
                                        <td class="py-3 px-4 text-center font-bold text-teal-700 text-base">94</td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="bg-emerald-100 text-emerald-700 text-xs px-2.5 py-1 rounded-full font-bold">Passed</span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <!-- General Average Summary Banner -->
                        <div class="mt-6 p-4 rounded-2xl bg-teal-600 text-white flex justify-between items-center shadow-md">
                            <div>
                                <p class="text-xs text-white/80 font-bold uppercase tracking-wider">Quarterly Average</p>
                                <h4 class="text-2xl font-bold">91.8% &mdash; Outstanding! 🌟</h4>
                            </div>
                            <button onclick="window.print()" class="bg-white/20 hover:bg-white/30 text-white font-medium text-xs px-4 py-2 rounded-xl transition flex items-center space-x-2 cursor-pointer">
                                <i class="fa-solid fa-print"></i>
                                <span>Print Card</span>
                            </button>
                        </div>

                    </div>

                </div>
            </main>
        </div>

    </div>

</body>
</html>
