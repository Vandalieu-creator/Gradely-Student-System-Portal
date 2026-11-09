<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ginatilan Elementary School - Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Alpine.js for Modals & Interactive Logic -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        skyBg: '#E0F2FE',
                        cardBg: '#FFFFFF',
                        kidPurple: '#C084FC',
                        kidPink: '#F472B6',
                        kidYellow: '#FDE047',
                        kidGreen: '#4ADE80',
                        kidOrange: '#FB923C',
                        kidBlue: '#38BDF8',
                        darkText: '#1E293B'
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
<body class="bg-skyBg min-h-screen text-darkText font-sans antialiased overflow-x-hidden"
      x-data="{ 
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

    <!-- Quick Find Global Modal (Ctrl+K / Cmd+K) -->
    @include('student.partials.quick-find')

    <!-- Layout Wrapper with Sidebar -->
    <div class="min-h-screen flex flex-row relative">

        <!-- Desktop Sidebar (Sticky left) -->
        <div class="hidden md:block shrink-0 sticky top-0 h-screen">
            @include('student.partials.sidebar', ['active' => 'dashboard'])
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
                @include('student.partials.sidebar', ['active' => 'dashboard'])
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
                    <div class="bg-white/15 px-3 py-1 rounded-xl text-xs font-bold text-amber-300 flex items-center space-x-1">
                        <span>⭐</span>
                        <span x-text="stars"></span>
                    </div>
                </div>
            </div>

            <!-- Page Main Content -->
            <main class="flex-1 p-3 sm:p-6 lg:p-8 flex justify-center items-start">
                <div class="w-full max-w-6xl bg-white/90 backdrop-blur-md rounded-[3rem] shadow-xl p-5 sm:p-8 border-4 border-white flex flex-col gap-6 relative">

                    <!-- Top School Header & Student Welcome Banner -->
                    <header class="bg-gradient-to-r from-kidPink via-kidPurple to-kidBlue rounded-[2.5rem] p-6 text-white flex flex-col sm:flex-row items-center justify-between gap-4 shadow-md relative overflow-hidden">
                        
                        <div class="flex items-center space-x-4 z-10">
                            <!-- School Logo & Student Avatar -->
                            <div class="relative flex items-center -space-x-3">
                                <img src="https://scontent.fcgy1-3.fna.fbcdn.net/v/t39.30808-6/306785656_399144949050859_6940190266702559829_n.jpg?stp=dst-jpg_tt6&cstp=mx828x826&ctp=s828x826&_nc_cat=107&_nc_map=urlgen_bucketless&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeF9qZjwNm8ws90wGeOqub0Eo6zNz6rPh_OjrM3Pqs-H8wS5n8vDVhoVtTSS4_xuRAJgS26g3wgxBi6xKpoNHqQ5&_nc_ohc=FW-j_FEzrbcQ7kNvwEwT63b&_nc_oc=AdrKR7rNle1H8gKGVImclHZmMCgu58CsqQTjszwsTg1EfbYrGyXL7wR3C1jQ81nAnu0&_nc_zt=23&_nc_ht=scontent.fcgy1-3.fna&_nc_gid=sIjMlVk-b2AmePncb3Dw0A&_nc_ss=7b2a8&oh=00_AQMDhpAOFSUOYgN6PLYNdW2XC2g2FOQwICPTaKPcFaF_LQ&oe=6AD7D0A2" alt="Ginatilan Elementary School Logo" class="w-20 h-20 rounded-full border-4 border-white shadow-md object-cover bg-white z-10">
                                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80" alt="Student Avatar" class="w-16 h-16 rounded-full border-4 border-white shadow-md object-cover">
                            </div>

                            <div>
                                <!-- School Name Badge -->
                                <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full border border-white/30 text-xs font-bold uppercase tracking-wider mb-1">
                                    <i class="fa-solid fa-school text-kidYellow"></i>
                                    <span>Ginatilan Elementary School</span>
                                </div>
                                
                                <h1 class="text-3xl sm:text-4xl font-bold">Hi, {{ Auth::user()->name ?? 'Super Star' }}! 👋</h1>
                                <p class="text-white/90 text-sm sm:text-base">Ready for another fun learning day?</p>
                            </div>
                        </div>

                        <!-- Stars Badge & Quick Find Action Button -->
                        <div class="flex items-center gap-3 z-10">
                            <div class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-2xl flex items-center space-x-2 border border-white/30">
                                <span class="text-2xl">⭐</span>
                                <div>
                                    <p class="text-xs text-white/80 uppercase font-bold">My Stars</p>
                                    <p class="text-xl font-bold leading-tight" x-text="stars + ' Stars'"></p>
                                </div>
                            </div>

                            <button @click="showQuickFind = true" 
                                    class="bg-white/20 hover:bg-white/30 text-white px-3.5 py-3 rounded-2xl font-bold transition flex items-center space-x-2 border border-white/30 text-xs cursor-pointer">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span class="hidden sm:inline">Quick Find</span>
                            </button>
                        </div>
                    </header>

                    <!-- Quick Subject Cards -->
                    <section id="subjects">
                        <h2 class="text-xl font-bold text-darkText mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-book-open text-kidBlue"></i> My Subjects
                        </h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-3">
                            
                            <!-- Math -->
                            <div class="bg-kidYellow/20 border-2 border-kidYellow p-3 rounded-3xl shadow-sm flex flex-col items-center justify-center text-center h-28 hover:scale-105 transition-transform duration-200 cursor-pointer">
                                <div class="w-12 h-12 bg-kidYellow rounded-2xl flex items-center justify-center text-xl text-darkText mb-1 shadow-sm">🔢</div>
                                <h3 class="font-bold text-sm text-darkText">Math</h3>
                            </div>

                            <!-- Science -->
                            <div class="bg-kidGreen/20 border-2 border-kidGreen p-3 rounded-3xl shadow-sm flex flex-col items-center justify-center text-center h-28 hover:scale-105 transition-transform duration-200 cursor-pointer">
                                <div class="w-12 h-12 bg-kidGreen rounded-2xl flex items-center justify-center text-xl text-white mb-1 shadow-sm">🔬</div>
                                <h3 class="font-bold text-sm text-darkText">Science</h3>
                            </div>

                            <!-- English -->
                            <div class="bg-kidPink/20 border-2 border-kidPink p-3 rounded-3xl shadow-sm flex flex-col items-center justify-center text-center h-28 hover:scale-105 transition-transform duration-200 cursor-pointer">
                                <div class="w-12 h-12 bg-kidPink rounded-2xl flex items-center justify-center text-xl text-white mb-1 shadow-sm">📚</div>
                                <h3 class="font-bold text-sm text-darkText">English</h3>
                            </div>

                            <!-- Filipino -->
                            <div class="bg-kidPurple/20 border-2 border-kidPurple p-3 rounded-3xl shadow-sm flex flex-col items-center justify-center text-center h-28 hover:scale-105 transition-transform duration-200 cursor-pointer">
                                <div class="w-12 h-12 bg-kidPurple rounded-2xl flex items-center justify-center text-xl text-white mb-1 shadow-sm">✍️</div>
                                <h3 class="font-bold text-sm text-darkText">Filipino</h3>
                            </div>

                            <!-- Araling Panlipunan -->
                            <div class="bg-orange-100 border-2 border-kidOrange p-3 rounded-3xl shadow-sm flex flex-col items-center justify-center text-center h-28 hover:scale-105 transition-transform duration-200 cursor-pointer">
                                <div class="w-12 h-12 bg-kidOrange rounded-2xl flex items-center justify-center text-xl text-white mb-1 shadow-sm">🌏</div>
                                <h3 class="font-bold text-xs text-darkText leading-tight">Araling Panlipunan</h3>
                            </div>

                            <!-- MAPEH -->
                            <div class="bg-emerald-100 border-2 border-teal-400 p-3 rounded-3xl shadow-sm flex flex-col items-center justify-center text-center h-28 hover:scale-105 transition-transform duration-200 cursor-pointer">
                                <div class="w-12 h-12 bg-teal-400 rounded-2xl flex items-center justify-center text-xl text-white mb-1 shadow-sm">🎨</div>
                                <h3 class="font-bold text-sm text-darkText">MAPEH</h3>
                            </div>

                            <!-- Edukasyon sa Pagpapakatao (EsP) -->
                            <div class="bg-sky-100 border-2 border-kidBlue p-3 rounded-3xl shadow-sm flex flex-col items-center justify-center text-center h-28 hover:scale-105 transition-transform duration-200 cursor-pointer">
                                <div class="w-12 h-12 bg-kidBlue rounded-2xl flex items-center justify-center text-xl text-white mb-1 shadow-sm">🤝</div>
                                <h3 class="font-bold text-sm text-darkText">EsP</h3>
                            </div>

                        </div>
                    </section>

                    <!-- Main Content Area -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- Today's Homework Checklist (Left 2 Columns) -->
                        <div id="homework" class="md:col-span-2 bg-slate-50 border-2 border-slate-100 p-6 rounded-3xl flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-xl font-bold text-darkText flex items-center gap-2">
                                        <i class="fa-solid fa-list-check text-kidOrange"></i> Today's Homework
                                    </h2>
                                    <span class="bg-kidOrange/20 text-kidOrange font-bold px-3 py-1 rounded-full text-xs" 
                                          x-text="taskDone ? '3 / 3 Done' : '2 / 3 Done'"></span>
                                </div>

                                <div class="space-y-3">
                                    <!-- Homework 1 -->
                                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <span class="w-8 h-8 bg-kidGreen text-white rounded-full flex items-center justify-center font-bold text-sm">✓</span>
                                            <div>
                                                <h4 class="font-bold text-sm text-gray-800 line-through">Math Worksheet #4</h4>
                                                <p class="text-xs text-gray-500">Adding and Subtracting</p>
                                            </div>
                                        </div>
                                        <span class="text-xs font-bold text-kidGreen bg-kidGreen/10 px-3 py-1 rounded-xl">+10 ⭐</span>
                                    </div>

                                    <!-- Homework 2 -->
                                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <span class="w-8 h-8 bg-kidGreen text-white rounded-full flex items-center justify-center font-bold text-sm">✓</span>
                                            <div>
                                                <h4 class="font-bold text-sm text-gray-800 line-through">Read "The Hungry Caterpillar"</h4>
                                                <p class="text-xs text-gray-500">10 mins reading time</p>
                                            </div>
                                        </div>
                                        <span class="text-xs font-bold text-kidGreen bg-kidGreen/10 px-3 py-1 rounded-xl">+15 ⭐</span>
                                    </div>

                                    <!-- Homework 3 (Interactive) -->
                                    <div class="bg-white p-4 rounded-2xl shadow-sm transition-all duration-300"
                                         :class="taskDone ? 'border border-gray-100' : 'border-2 border-kidOrange/40'">
                                        
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <span class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300"
                                                      :class="taskDone ? 'bg-kidGreen text-white' : 'bg-gray-200 text-gray-400'"
                                                      x-text="taskDone ? '✓' : '3'"></span>
                                                <div>
                                                    <h4 class="font-bold text-sm" 
                                                        :class="taskDone ? 'text-gray-800 line-through' : 'text-darkText'">Draw Your Favorite Animal</h4>
                                                    <p class="text-xs text-gray-500">Art Class Assignment (MAPEH)</p>
                                                </div>
                                            </div>

                                            <template x-if="!taskDone">
                                                <button @click="showModal = true" 
                                                        class="bg-kidOrange hover:bg-orange-500 text-white font-bold text-xs px-4 py-2 rounded-xl shadow-sm transition cursor-pointer">
                                                    Start Now!
                                                </button>
                                            </template>

                                            <template x-if="taskDone">
                                                <span class="text-xs font-bold text-kidGreen bg-kidGreen/10 px-3 py-1 rounded-xl">+20 ⭐</span>
                                            </template>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Daily Progress Bar -->
                            <div class="mt-6 pt-4 border-t border-gray-200">
                                <div class="flex justify-between items-center mb-1 text-xs font-bold text-gray-600">
                                    <span>Daily Goal Progress</span>
                                    <span x-text="taskDone ? '100%' : '66%'"></span>
                                </div>
                                <div class="w-full bg-gray-200 h-4 rounded-full overflow-hidden p-0.5">
                                    <div class="bg-gradient-to-r from-kidYellow to-kidGreen h-full rounded-full transition-all duration-500" 
                                         :style="taskDone ? 'width: 100%' : 'width: 66%'"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Badges & Teachers -->
                        <div class="flex flex-col gap-6">

                            <!-- View My Grades Widget -->
                            <div class="bg-teal-50 border-2 border-teal-200 p-5 rounded-3xl flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="font-bold text-base text-slate-800 flex items-center gap-2">
                                            <i class="fa-solid fa-graduation-cap text-teal-600"></i> View My Grades
                                        </h3>
                                        <span class="bg-teal-600 text-white font-bold text-[10px] px-2.5 py-0.5 rounded-full uppercase">Report Card</span>
                                    </div>
                                    <p class="text-xs text-slate-600 mb-4">
                                        Check your quarterly grades and academic standing from 1st to 4th Quarter.
                                    </p>
                                </div>

                                <a href="{{ route('student.grades') }}" 
                                class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm py-2.5 px-4 rounded-xl text-center shadow-md hover:shadow-lg transition flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-file-invoice"></i>
                                    <span>View Report Card</span>
                                </a>
                            </div>

                            <!-- Teacher Helper Widget -->
                            <div class="bg-kidBlue/10 border-2 border-kidBlue/30 p-5 rounded-3xl">
                                <h3 class="font-bold text-base text-darkText mb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-user-ninja text-kidBlue"></i> My Teacher
                                </h3>
                                <div class="bg-white p-3 rounded-2xl shadow-xs flex items-center justify-between border border-sky-100">
                                    <div class="flex items-center space-x-3">
                                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" class="w-10 h-10 rounded-full object-cover border-2 border-kidBlue">
                                        <div>
                                            <h4 class="font-bold text-xs text-darkText">Mrs. Miller</h4>
                                            <p class="text-[10px] text-gray-500">Homeroom Teacher</p>
                                        </div>
                                    </div>
                                    <!-- Ask Help Button triggers Teacher Modal -->
                                    <button @click="showTeacherModal = true" 
                                            class="bg-kidBlue text-white font-bold text-xs px-3 py-1.5 rounded-xl hover:bg-sky-500 transition cursor-pointer shadow-sm">
                                        Ask Help
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- School Footer -->
                    <footer class="text-center text-xs text-gray-500 pt-2 border-t border-gray-100">
                        Ginatilan Elementary School Student Portal &copy; 2026 &bull; Learning Made Fun!
                    </footer>

                </div>
            </main>
        </div>

    </div>

</body>
</html>
