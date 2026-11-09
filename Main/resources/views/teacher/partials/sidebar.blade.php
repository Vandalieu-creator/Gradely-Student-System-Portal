@props(['active' => 'dashboard'])

<!-- Teacher Navigation Sidebar Component -->
<aside class="relative flex flex-col justify-between shrink-0 transition-all duration-300 ease-in-out z-40 select-none overflow-hidden"
       :class="sidebarCollapsed ? 'w-[74px]' : 'w-64'"
       style="background: linear-gradient(180deg, #101a2a 0%, #142236 38%, #1a2b44 72%, #3c516f 90%, #a2b5cc 100%); min-height: 100vh;">

    <!-- Bottom Misty Gradient Overlay (matching reference image) -->
    <div class="pointer-events-none absolute bottom-0 left-0 right-0 h-36 bg-gradient-to-t from-slate-200/55 via-slate-300/15 to-transparent z-10"></div>

    <div class="relative z-20 flex flex-col h-full p-3 sm:p-3.5">

        <!-- ============================================================== -->
        <!-- TOP SECTION: Collapse Toggle & Cyan Apple Teacher Banner       -->
        <!-- ============================================================== -->

        <!-- EXPANDED TOP BAR -->
        <div x-show="!sidebarCollapsed" class="space-y-3 pb-3">
            
            <!-- Top Right Collapse Button (<) -->
            <div class="flex justify-end pt-1 pr-1">
                <button type="button" 
                        @click="toggleSidebar()" 
                        title="Collapse Sidebar"
                        class="h-7 w-7 rounded-lg bg-[#18273b] hover:bg-[#22354f] text-slate-300 hover:text-white flex items-center justify-center transition border border-white/10 shadow-sm cursor-pointer group">
                    <svg class="w-3.5 h-3.5 transform group-hover:-translate-x-0.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                </button>
            </div>

            <!-- Cyan "Teacher" Banner Pill with Apple Icon & Dropdown Caret -->
            <div class="relative" x-data="{ openRoleMenu: false }">
                <button type="button" 
                        @click="openRoleMenu = !openRoleMenu"
                        @click.away="openRoleMenu = false"
                        class="w-full bg-[#00adef] hover:bg-[#009fdc] text-white flex items-center justify-between px-3.5 py-2.5 rounded-2xl shadow-lg transition duration-200 cursor-pointer border border-sky-400/30 group">
                    
                    <div class="flex items-center space-x-3">
                        <!-- Apple Outline Icon -->
                        <div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 4.5c1.2-1.5 2.8-2.5 4.5-2.5 0 2-1 3.5-2.5 4.5"/>
                                <path d="M8.5 7.5C5.5 7.5 3 9.8 3 13.5c0 4.5 3.2 8.5 6 8.5 1.4 0 2.2-.8 3-0.8s1.6.8 3 .8c2.8 0 6-4 6-8.5 0-3.7-2.5-6-5.5-6-1.5 0-2.8.8-3.5 1.5-.7-.7-2-1.5-3.5-1.5z"/>
                            </svg>
                        </div>

                        <!-- Role Label -->
                        <div class="text-left">
                            <span class="text-sm font-bold tracking-wide block leading-tight">Teacher</span>
                            <span class="text-[10px] text-sky-100 font-medium block opacity-90 truncate max-w-[110px]">
                                {{ Auth::guard('teacher')->user()->first_name ?? 'Faculty' }} {{ Auth::guard('teacher')->user()->last_name ?? 'Member' }}
                            </span>
                        </div>
                    </div>

                    <!-- Small Caret Down (▼) -->
                    <svg class="w-2.5 h-2.5 text-white/90 group-hover:translate-y-0.5 transition-transform" 
                         :class="openRoleMenu ? 'rotate-180' : ''"
                         viewBox="0 0 10 6" fill="currentColor">
                        <path d="M0 0l5 6 5-6z"/>
                    </svg>
                </button>

                <!-- Teacher Profile Quick Dropdown -->
                <div x-show="openRoleMenu" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-[-5px]"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-[-5px]"
                     class="absolute top-full left-0 right-0 mt-2 bg-[#121c2e] border border-slate-700/80 rounded-2xl shadow-2xl p-3 z-50 text-slate-200 text-xs"
                     style="display: none;">
                    
                    <div class="pb-2 border-b border-slate-700/60 mb-2">
                        <p class="font-bold text-white text-sm">
                            {{ Auth::guard('teacher')->user()->first_name ?? 'Teacher' }} {{ Auth::guard('teacher')->user()->last_name ?? '' }}
                        </p>
                        <p class="text-[11px] text-slate-400 font-mono">
                            ID: {{ Auth::guard('teacher')->user()->employee_id ?? 'T-2026-001' }}
                        </p>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded-full bg-sky-500/20 text-sky-300 font-bold text-[10px]">
                            Advisory: Grade 4 - Diamond
                        </span>
                    </div>

                    <div class="space-y-1">
                        <a href="{{ route('teacher.dashboard') }}" class="flex items-center space-x-2 p-2 rounded-xl hover:bg-white/10 transition text-slate-200">
                            <i class="fa-solid fa-house text-sky-400 text-xs"></i>
                            <span>Teacher Dashboard</span>
                        </a>
                        <a href="{{ route('teacher.classes.index') }}" class="flex items-center space-x-2 p-2 rounded-xl hover:bg-white/10 transition text-slate-200">
                            <i class="fa-solid fa-chalkboard-user text-teal-400 text-xs"></i>
                            <span>Manage My Classes</span>
                        </a>
                        <a href="{{ route('teacher.schedule.index') }}" class="flex items-center space-x-2 p-2 rounded-xl hover:bg-white/10 transition text-slate-200">
                            <i class="fa-solid fa-calendar-days text-indigo-400 text-xs"></i>
                            <span>Weekly Class Schedule</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="pt-1 border-t border-slate-700/60 mt-1">
                            @csrf
                            <button type="submit" class="w-full flex items-center space-x-2 p-2 rounded-xl hover:bg-red-500/20 text-red-400 transition cursor-pointer text-left">
                                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                <span>Log Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <!-- COLLAPSED TOP BAR -->
        <div x-show="sidebarCollapsed" class="flex flex-col items-center space-y-3 pb-3" style="display: none;">
            
            <!-- Apple Icon Squircle Button -->
            <button type="button" 
                    @click="toggleSidebar()" 
                    title="Expand Sidebar"
                    class="w-12 h-12 rounded-2xl bg-[#00adef] hover:bg-[#009fdc] text-white flex items-center justify-center shadow-lg transition duration-200 cursor-pointer border border-sky-400/40 group">
                <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 4.5c1.2-1.5 2.8-2.5 4.5-2.5 0 2-1 3.5-2.5 4.5"/>
                    <path d="M8.5 7.5C5.5 7.5 3 9.8 3 13.5c0 4.5 3.2 8.5 6 8.5 1.4 0 2.2-.8 3-0.8s1.6.8 3 .8c2.8 0 6-4 6-8.5 0-3.7-2.5-6-5.5-6-1.5 0-2.8.8-3.5 1.5-.7-.7-2-1.5-3.5-1.5z"/>
                </svg>
            </button>

            <!-- Expand Toggle (>) Button -->
            <button type="button" 
                    @click="toggleSidebar()" 
                    title="Expand Sidebar"
                    class="h-6 w-6 rounded-md bg-[#18273b] hover:bg-[#22354f] text-slate-400 hover:text-white flex items-center justify-center transition border border-white/10 shadow-xs cursor-pointer group">
                <svg class="w-3 h-3 transform group-hover:translate-x-0.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m9 18 6-6-6-6"/>
                </svg>
            </button>

        </div>

        <!-- ============================================================== -->
        <!-- NAVIGATION MENU ITEMS                                          -->
        <!-- ============================================================== -->
        <nav class="flex-1 space-y-1.5 overflow-y-auto overflow-x-hidden pr-0.5 custom-scrollbar">

            <!-- 0. QUICK FIND -->
            <div class="relative group">
                <button type="button" 
                        @click="showQuickFind = true"
                        class="w-full flex items-center rounded-xl transition duration-200 font-medium text-sm text-slate-300 hover:text-white hover:bg-white/5 cursor-pointer text-left"
                        :class="sidebarCollapsed ? 'justify-center p-3' : 'justify-between px-3 py-2.5'">
                    
                    <div class="flex items-center space-x-3.5">
                        <!-- Magnifying Glass Icon -->
                        <svg class="w-5 h-5 shrink-0 text-slate-300 group-hover:text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="7"/>
                            <path d="M21 21l-4.35-4.35"/>
                        </svg>

                        <!-- Label -->
                        <span x-show="!sidebarCollapsed" class="whitespace-nowrap tracking-wide">Quick Find</span>
                    </div>

                    <!-- Shortcut badge -->
                    <span x-show="!sidebarCollapsed" class="text-[10px] bg-white/10 px-1.5 py-0.5 rounded text-slate-400 font-mono">⌘K</span>
                </button>

                <!-- Tooltip when Collapsed -->
                <div x-show="sidebarCollapsed" 
                     class="opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 absolute left-full top-1/2 -translate-y-1/2 ml-3 bg-[#0d1624] text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg shadow-xl border border-slate-700 whitespace-nowrap z-50 flex items-center">
                    <span>Quick Find (⌘K)</span>
                    <div class="absolute -left-1 top-1/2 -translate-y-1/2 w-2 h-2 bg-[#0d1624] border-l border-b border-slate-700 transform rotate-45"></div>
                </div>
            </div>

            <!-- Divider Line -->
            <div class="border-b border-white/10 my-2"></div>

            <div x-show="!sidebarCollapsed" class="px-3 pt-1 pb-1">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Main Menu</span>
            </div>

            <!-- 1. DASHBOARD -->
            <div class="relative group">
                <a href="{{ route('teacher.dashboard') }}" 
                   class="flex items-center rounded-xl transition duration-200 font-medium text-sm cursor-pointer {{ $active === 'dashboard' ? 'bg-[#1b2b42] text-white font-bold shadow-xs border border-white/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}"
                   :class="sidebarCollapsed ? 'justify-center p-3' : 'justify-between px-3 py-2.5'">
                    
                    <div class="flex items-center space-x-3.5">
                        <!-- House Icon -->
                        <svg class="w-5 h-5 shrink-0 {{ $active === 'dashboard' ? 'text-sky-400' : 'text-slate-300 group-hover:text-white' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 10.5L12 3l9 7.5V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V10.5z"/>
                            <path d="M9 22V12h6v10"/>
                        </svg>

                        <!-- Label -->
                        <span x-show="!sidebarCollapsed" class="whitespace-nowrap tracking-wide">Dashboard</span>
                    </div>

                    <!-- Active Dot Indicator -->
                    <div x-show="!sidebarCollapsed && '{{ $active }}' === 'dashboard'" class="w-1.5 h-1.5 rounded-full bg-sky-400"></div>
                </a>

                <!-- Tooltip when Collapsed -->
                <div x-show="sidebarCollapsed" 
                     class="opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 absolute left-full top-1/2 -translate-y-1/2 ml-3 bg-[#0d1624] text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg shadow-xl border border-slate-700 whitespace-nowrap z-50 flex items-center">
                    <span>Dashboard</span>
                    <div class="absolute -left-1 top-1/2 -translate-y-1/2 w-2 h-2 bg-[#0d1624] border-l border-b border-slate-700 transform rotate-45"></div>
                </div>
            </div>

            <!-- 2. MY CLASSES (Accordion) -->
            <div class="relative group" x-data="{ openMenu: {{ $active === 'classes' ? 'true' : 'false' }} }">
                <div class="flex items-center rounded-xl transition duration-200 font-medium text-sm cursor-pointer {{ $active === 'classes' ? 'bg-[#1b2b42] text-white font-bold shadow-xs border border-white/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}"
                     :class="sidebarCollapsed ? 'justify-center p-3' : 'justify-between px-3 py-2.5'">
                    
                    <a href="{{ route('teacher.classes.index') }}" class="flex items-center space-x-3.5 flex-1 min-w-0">
                        <!-- School combo desk-chair outline icon (matching reference image) -->
                        <svg class="w-5 h-5 shrink-0 {{ $active === 'classes' ? 'text-sky-400' : 'text-slate-300 group-hover:text-white' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 6v8"/>
                            <path d="M4 12h5"/>
                            <path d="M4 14l-1.5 6"/>
                            <path d="M9 14l-1.5 6"/>
                            <path d="M12 9h8"/>
                            <path d="M13 9v11"/>
                            <path d="M19 9v11"/>
                            <path d="M6.5 17h10"/>
                        </svg>

                        <!-- Label -->
                        <span x-show="!sidebarCollapsed" class="whitespace-nowrap tracking-wide">My Classes</span>
                    </a>

                    <!-- Downward Small Caret (▼) toggle -->
                    <button type="button" 
                            x-show="!sidebarCollapsed" 
                            @click.stop="openMenu = !openMenu" 
                            class="p-1 rounded hover:bg-white/10 transition">
                        <svg class="w-2.5 h-2.5 text-slate-400 group-hover:text-slate-200 transition-transform duration-200" 
                             :class="openMenu ? 'rotate-180 text-white' : ''" 
                             viewBox="0 0 10 6" fill="currentColor">
                            <path d="M0 0l5 6 5-6z"/>
                        </svg>
                    </button>
                </div>

                <!-- Submenu when Expanded -->
                <div x-show="!sidebarCollapsed && openMenu" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="pl-11 pr-2 py-1 space-y-1 text-xs" 
                     style="display: none;">
                    <a href="{{ route('teacher.classes.index') }}" class="block py-1.5 text-slate-300 hover:text-white transition">
                        📚 All Assigned Classes
                    </a>
                    <a href="{{ route('teacher.classes.create') }}" class="block py-1.5 text-sky-300 hover:text-white transition font-medium">
                        ➕ Create New Class
                    </a>
                </div>

                <!-- Tooltip when Collapsed -->
                <div x-show="sidebarCollapsed" 
                     class="opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 absolute left-full top-1/2 -translate-y-1/2 ml-3 bg-[#0d1624] text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg shadow-xl border border-slate-700 whitespace-nowrap z-50 flex items-center">
                    <span>My Classes</span>
                    <div class="absolute -left-1 top-1/2 -translate-y-1/2 w-2 h-2 bg-[#0d1624] border-l border-b border-slate-700 transform rotate-45"></div>
                </div>
            </div>

            <!-- 3. MY STUDENTS (Accordion) -->
            <div class="relative group" x-data="{ openMenu: {{ $active === 'students' ? 'true' : 'false' }} }">
                <div class="flex items-center rounded-xl transition duration-200 font-medium text-sm cursor-pointer {{ $active === 'students' ? 'bg-[#1b2b42] text-white font-bold shadow-xs border border-white/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}"
                     :class="sidebarCollapsed ? 'justify-center p-3' : 'justify-between px-3 py-2.5'">
                    
                    <a href="{{ route('teacher.students.all') }}" class="flex items-center space-x-3.5 flex-1 min-w-0">
                        <!-- Group of Users Outline Icon -->
                        <svg class="w-5 h-5 shrink-0 {{ $active === 'students' ? 'text-sky-400' : 'text-slate-300 group-hover:text-white' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>

                        <!-- Label -->
                        <span x-show="!sidebarCollapsed" class="whitespace-nowrap tracking-wide">My Students</span>
                    </a>

                    <!-- Downward Small Caret (▼) toggle -->
                    <button type="button" 
                            x-show="!sidebarCollapsed" 
                            @click.stop="openMenu = !openMenu" 
                            class="p-1 rounded hover:bg-white/10 transition">
                        <svg class="w-2.5 h-2.5 text-slate-400 group-hover:text-slate-200 transition-transform duration-200" 
                             :class="openMenu ? 'rotate-180 text-white' : ''" 
                             viewBox="0 0 10 6" fill="currentColor">
                            <path d="M0 0l5 6 5-6z"/>
                        </svg>
                    </button>
                </div>

                <!-- Submenu when Expanded -->
                <div x-show="!sidebarCollapsed && openMenu" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="pl-11 pr-2 py-1 space-y-1 text-xs" 
                     style="display: none;">
                    <a href="{{ route('teacher.students.all') }}" class="block py-1.5 text-slate-300 hover:text-white transition">
                        👥 Student Directory
                    </a>
                    <a href="{{ route('teacher.students.all') }}?class=Grade+4+-+Diamond" class="block py-1.5 text-slate-300 hover:text-white transition">
                        💎 Grade 4 - Diamond
                    </a>
                    <a href="{{ route('teacher.students.all') }}?class=Grade+5+-+Sapphire" class="block py-1.5 text-slate-300 hover:text-white transition">
                        🔷 Grade 5 - Sapphire
                    </a>
                </div>

                <!-- Tooltip when Collapsed -->
                <div x-show="sidebarCollapsed" 
                     class="opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 absolute left-full top-1/2 -translate-y-1/2 ml-3 bg-[#0d1624] text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg shadow-xl border border-slate-700 whitespace-nowrap z-50 flex items-center">
                    <span>My Students</span>
                    <div class="absolute -left-1 top-1/2 -translate-y-1/2 w-2 h-2 bg-[#0d1624] border-l border-b border-slate-700 transform rotate-45"></div>
                </div>
            </div>

            <!-- 4. ATTENDANCE (Accordion) -->
            <div class="relative group" x-data="{ openMenu: {{ $active === 'attendance' ? 'true' : 'false' }} }">
                <div class="flex items-center rounded-xl transition duration-200 font-medium text-sm cursor-pointer {{ $active === 'attendance' ? 'bg-[#1b2b42] text-white font-bold shadow-xs border border-white/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}"
                     :class="sidebarCollapsed ? 'justify-center p-3' : 'justify-between px-3 py-2.5'">
                    
                    <a href="{{ route('teacher.attendance.index') }}" class="flex items-center space-x-3.5 flex-1 min-w-0">
                        <!-- Attendance Checklist / Calendar Icon -->
                        <svg class="w-5 h-5 shrink-0 {{ $active === 'attendance' ? 'text-amber-400' : 'text-slate-300 group-hover:text-white' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                            <path d="m9 16 2 2 4-4"/>
                        </svg>

                        <!-- Label -->
                        <span x-show="!sidebarCollapsed" class="whitespace-nowrap tracking-wide">Attendance</span>
                    </a>

                    <!-- Downward Small Caret (▼) toggle -->
                    <button type="button" 
                            x-show="!sidebarCollapsed" 
                            @click.stop="openMenu = !openMenu" 
                            class="p-1 rounded hover:bg-white/10 transition">
                        <svg class="w-2.5 h-2.5 text-slate-400 group-hover:text-slate-200 transition-transform duration-200" 
                             :class="openMenu ? 'rotate-180 text-white' : ''" 
                             viewBox="0 0 10 6" fill="currentColor">
                            <path d="M0 0l5 6 5-6z"/>
                        </svg>
                    </button>
                </div>

                <!-- Submenu when Expanded -->
                <div x-show="!sidebarCollapsed && openMenu" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="pl-11 pr-2 py-1 space-y-1 text-xs" 
                     style="display: none;">
                    <a href="{{ route('teacher.attendance.index') }}" class="block py-1.5 text-amber-300 hover:text-white font-medium transition">
                        📋 Today's Roll Call
                    </a>
                    <a href="{{ route('teacher.attendance.index') }}#history" class="block py-1.5 text-slate-300 hover:text-white transition">
                        📊 Attendance History & Logs
                    </a>
                </div>

                <!-- Tooltip when Collapsed -->
                <div x-show="sidebarCollapsed" 
                     class="opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 absolute left-full top-1/2 -translate-y-1/2 ml-3 bg-[#0d1624] text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg shadow-xl border border-slate-700 whitespace-nowrap z-50 flex items-center">
                    <span>Attendance</span>
                    <div class="absolute -left-1 top-1/2 -translate-y-1/2 w-2 h-2 bg-[#0d1624] border-l border-b border-slate-700 transform rotate-45"></div>
                </div>
            </div>

            <!-- 5. CLASS SCHEDULE (Accordion) -->
            <div class="relative group" x-data="{ openMenu: {{ $active === 'schedule' ? 'true' : 'false' }} }">
                <div class="flex items-center rounded-xl transition duration-200 font-medium text-sm cursor-pointer {{ $active === 'schedule' ? 'bg-[#1b2b42] text-white font-bold shadow-xs border border-white/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}"
                     :class="sidebarCollapsed ? 'justify-center p-3' : 'justify-between px-3 py-2.5'">
                    
                    <a href="{{ route('teacher.schedule.index') }}" class="flex items-center space-x-3.5 flex-1 min-w-0">
                        <!-- Clock / Calendar Timetable Icon -->
                        <svg class="w-5 h-5 shrink-0 {{ $active === 'schedule' ? 'text-indigo-400' : 'text-slate-300 group-hover:text-white' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>

                        <!-- Label -->
                        <span x-show="!sidebarCollapsed" class="whitespace-nowrap tracking-wide">Class Schedule</span>
                    </a>

                    <!-- Downward Small Caret (▼) toggle -->
                    <button type="button" 
                            x-show="!sidebarCollapsed" 
                            @click.stop="openMenu = !openMenu" 
                            class="p-1 rounded hover:bg-white/10 transition">
                        <svg class="w-2.5 h-2.5 text-slate-400 group-hover:text-slate-200 transition-transform duration-200" 
                             :class="openMenu ? 'rotate-180 text-white' : ''" 
                             viewBox="0 0 10 6" fill="currentColor">
                            <path d="M0 0l5 6 5-6z"/>
                        </svg>
                    </button>
                </div>

                <!-- Submenu when Expanded -->
                <div x-show="!sidebarCollapsed && openMenu" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="pl-11 pr-2 py-1 space-y-1 text-xs" 
                     style="display: none;">
                    <a href="{{ route('teacher.schedule.index') }}" class="block py-1.5 text-indigo-300 hover:text-white font-medium transition">
                        📅 Weekly Timetable (Mon-Fri)
                    </a>
                    <a href="{{ route('teacher.schedule.index') }}#bell" class="block py-1.5 text-slate-300 hover:text-white transition">
                        🔔 School Bell Schedule
                    </a>
                </div>

                <!-- Tooltip when Collapsed -->
                <div x-show="sidebarCollapsed" 
                     class="opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 absolute left-full top-1/2 -translate-y-1/2 ml-3 bg-[#0d1624] text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg shadow-xl border border-slate-700 whitespace-nowrap z-50 flex items-center">
                    <span>Class Schedule</span>
                    <div class="absolute -left-1 top-1/2 -translate-y-1/2 w-2 h-2 bg-[#0d1624] border-l border-b border-slate-700 transform rotate-45"></div>
                </div>
            </div>

            <!-- 6. ASSIGNMENTS (Accordion - Matching Reference Image Icon) -->
            <div class="relative group" x-data="{ openMenu: {{ $active === 'assignments' ? 'true' : 'false' }} }">
                <div class="flex items-center rounded-xl transition duration-200 font-medium text-sm cursor-pointer {{ $active === 'assignments' ? 'bg-[#1b2b42] text-white font-bold shadow-xs border border-white/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}"
                     :class="sidebarCollapsed ? 'justify-center p-3' : 'justify-between px-3 py-2.5'">
                    
                    <a href="{{ route('teacher.assignments.index') }}" class="flex items-center space-x-3.5 flex-1 min-w-0">
                        <!-- Desktop monitor with document icon (matching reference image) -->
                        <svg class="w-5 h-5 shrink-0 {{ $active === 'assignments' ? 'text-orange-400' : 'text-slate-300 group-hover:text-white' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="13" rx="2"/>
                            <path d="M8 20h8"/>
                            <path d="M12 16v4"/>
                            <rect x="7" y="6" width="10" height="7" rx="1"/>
                            <path d="M9.5 8.5h5"/>
                            <path d="M9.5 10.5h3.5"/>
                        </svg>

                        <!-- Label -->
                        <span x-show="!sidebarCollapsed" class="whitespace-nowrap tracking-wide">Assignments</span>
                    </a>

                    <!-- Downward Small Caret (▼) toggle -->
                    <button type="button" 
                            x-show="!sidebarCollapsed" 
                            @click.stop="openMenu = !openMenu" 
                            class="p-1 rounded hover:bg-white/10 transition">
                        <svg class="w-2.5 h-2.5 text-slate-400 group-hover:text-slate-200 transition-transform duration-200" 
                             :class="openMenu ? 'rotate-180 text-white' : ''" 
                             viewBox="0 0 10 6" fill="currentColor">
                            <path d="M0 0l5 6 5-6z"/>
                        </svg>
                    </button>
                </div>

                <!-- Submenu when Expanded -->
                <div x-show="!sidebarCollapsed && openMenu" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="pl-11 pr-2 py-1 space-y-1 text-xs" 
                     style="display: none;">
                    <a href="{{ route('teacher.assignments.index') }}" class="block py-1.5 text-slate-300 hover:text-white transition">
                        📝 Active Tasks & Deadlines
                    </a>
                    <button type="button" @click="showAssignmentModal = true" class="block py-1.5 text-orange-300 hover:text-white transition text-left w-full cursor-pointer font-medium">
                        ➕ Create New Assignment
                    </button>
                </div>

                <!-- Tooltip when Collapsed -->
                <div x-show="sidebarCollapsed" 
                     class="opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 absolute left-full top-1/2 -translate-y-1/2 ml-3 bg-[#0d1624] text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg shadow-xl border border-slate-700 whitespace-nowrap z-50 flex items-center">
                    <span>Assignments</span>
                    <div class="absolute -left-1 top-1/2 -translate-y-1/2 w-2 h-2 bg-[#0d1624] border-l border-b border-slate-700 transform rotate-45"></div>
                </div>
            </div>

            <!-- 7. LEARNING MATERIALS (Accordion - Matching Reference Image Icon) -->
            <div class="relative group" x-data="{ openMenu: {{ $active === 'materials' ? 'true' : 'false' }} }">
                <div class="flex items-center rounded-xl transition duration-200 font-medium text-sm cursor-pointer {{ $active === 'materials' ? 'bg-[#1b2b42] text-white font-bold shadow-xs border border-white/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}"
                     :class="sidebarCollapsed ? 'justify-center p-3' : 'justify-between px-3 py-2.5'">
                    
                    <a href="{{ route('teacher.materials.index') }}" class="flex items-center space-x-3.5 flex-1 min-w-0">
                        <!-- Open book icon (matching reference image) -->
                        <svg class="w-5 h-5 shrink-0 {{ $active === 'materials' ? 'text-emerald-400' : 'text-slate-300 group-hover:text-white' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5v-13A2.5 2.5 0 0 1 6.5 4H12v15H6.5A2.5 2.5 0 0 0 4 19.5z"/>
                            <path d="M20 19.5v-13A2.5 2.5 0 0 0 17.5 4H12v15h5.5a2.5 2.5 0 0 1 2.5 2.5z"/>
                            <path d="M6.5 8h3.5"/>
                            <path d="M6.5 11h3.5"/>
                            <path d="M14 8h3.5"/>
                            <path d="M14 11h3.5"/>
                        </svg>

                        <!-- Label -->
                        <span x-show="!sidebarCollapsed" class="whitespace-nowrap tracking-wide">Learning Materials</span>
                    </a>

                    <!-- Downward Small Caret (▼) toggle -->
                    <button type="button" 
                            x-show="!sidebarCollapsed" 
                            @click.stop="openMenu = !openMenu" 
                            class="p-1 rounded hover:bg-white/10 transition">
                        <svg class="w-2.5 h-2.5 text-slate-400 group-hover:text-slate-200 transition-transform duration-200" 
                             :class="openMenu ? 'rotate-180 text-white' : ''" 
                             viewBox="0 0 10 6" fill="currentColor">
                            <path d="M0 0l5 6 5-6z"/>
                        </svg>
                    </button>
                </div>

                <!-- Submenu when Expanded -->
                <div x-show="!sidebarCollapsed && openMenu" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="pl-11 pr-2 py-1 space-y-1 text-xs" 
                     style="display: none;">
                    <a href="{{ route('teacher.materials.index') }}" class="block py-1.5 text-slate-300 hover:text-white transition">
                        📖 Lesson Plans & Modules
                    </a>
                    <button type="button" @click="showUploadModal = true" class="block py-1.5 text-emerald-300 hover:text-white transition text-left w-full cursor-pointer font-medium">
                        📤 Upload New Material
                    </button>
                </div>

                <!-- Tooltip when Collapsed -->
                <div x-show="sidebarCollapsed" 
                     class="opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 absolute left-full top-1/2 -translate-y-1/2 ml-3 bg-[#0d1624] text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg shadow-xl border border-slate-700 whitespace-nowrap z-50 flex items-center">
                    <span>Learning Materials</span>
                    <div class="absolute -left-1 top-1/2 -translate-y-1/2 w-2 h-2 bg-[#0d1624] border-l border-b border-slate-700 transform rotate-45"></div>
                </div>
            </div>

            <!-- 8. GRADES & REPORTS (Accordion - Matching Reference Image Icon) -->
            <div class="relative group" x-data="{ openMenu: {{ $active === 'grades' ? 'true' : 'false' }} }">
                <div class="flex items-center rounded-xl transition duration-200 font-medium text-sm cursor-pointer {{ $active === 'grades' ? 'bg-[#1b2b42] text-white font-bold shadow-xs border border-white/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}"
                     :class="sidebarCollapsed ? 'justify-center p-3' : 'justify-between px-3 py-2.5'">
                    
                    <a href="{{ route('teacher.grades.index') }}" class="flex items-center space-x-3.5 flex-1 min-w-0">
                        <!-- Circle checkmark & badge icon (matching reference image) -->
                        <svg class="w-5 h-5 shrink-0 {{ $active === 'grades' ? 'text-teal-400' : 'text-slate-300 group-hover:text-white' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="13" cy="13" r="7.5"/>
                            <path d="m10 13 2 2 4-4"/>
                            <circle cx="6" cy="6" r="3.2"/>
                            <path d="m4.8 6h2.4"/>
                            <path d="m6 4.8v2.4"/>
                        </svg>

                        <!-- Label -->
                        <span x-show="!sidebarCollapsed" class="whitespace-nowrap tracking-wide">Grades & Reports</span>
                    </a>

                    <!-- Downward Small Caret (▼) toggle -->
                    <button type="button" 
                            x-show="!sidebarCollapsed" 
                            @click.stop="openMenu = !openMenu" 
                            class="p-1 rounded hover:bg-white/10 transition">
                        <svg class="w-2.5 h-2.5 text-slate-400 group-hover:text-slate-200 transition-transform duration-200" 
                             :class="openMenu ? 'rotate-180 text-white' : ''" 
                             viewBox="0 0 10 6" fill="currentColor">
                            <path d="M0 0l5 6 5-6z"/>
                        </svg>
                    </button>
                </div>

                <!-- Submenu when Expanded -->
                <div x-show="!sidebarCollapsed && openMenu" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="pl-11 pr-2 py-1 space-y-1 text-xs" 
                     style="display: none;">
                    <a href="{{ route('teacher.grades.index') }}" class="block py-1.5 text-teal-300 hover:text-white font-medium transition">
                        📊 Class Gradebook
                    </a>
                    <a href="{{ route('teacher.grades.index') }}#form138" class="block py-1.5 text-slate-300 hover:text-white transition">
                        📄 DepEd Form 138 Cards
                    </a>
                </div>

                <!-- Tooltip when Collapsed -->
                <div x-show="sidebarCollapsed" 
                     class="opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 absolute left-full top-1/2 -translate-y-1/2 ml-3 bg-[#0d1624] text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg shadow-xl border border-slate-700 whitespace-nowrap z-50 flex items-center">
                    <span>Grades & Reports</span>
                    <div class="absolute -left-1 top-1/2 -translate-y-1/2 w-2 h-2 bg-[#0d1624] border-l border-b border-slate-700 transform rotate-45"></div>
                </div>
            </div>

            <!-- 9. ANNOUNCEMENTS (Accordion) -->
            <div class="relative group" x-data="{ openMenu: {{ $active === 'announcements' ? 'true' : 'false' }} }">
                <div class="flex items-center rounded-xl transition duration-200 font-medium text-sm cursor-pointer {{ $active === 'announcements' ? 'bg-[#1b2b42] text-white font-bold shadow-xs border border-white/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}"
                     :class="sidebarCollapsed ? 'justify-center p-3' : 'justify-between px-3 py-2.5'">
                    
                    <a href="{{ route('teacher.announcements.index') }}" class="flex items-center space-x-3.5 flex-1 min-w-0">
                        <!-- Bullhorn / Megaphone Icon -->
                        <svg class="w-5 h-5 shrink-0 {{ $active === 'announcements' ? 'text-amber-400' : 'text-slate-300 group-hover:text-white' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 5L6 9H2v6h4l5 4V5z"/>
                            <path d="M15.54 8.46a5 5 0 0 1 0 7.07"/>
                            <path d="M19.07 4.93a10 10 0 0 1 0 14.14"/>
                        </svg>

                        <!-- Label -->
                        <span x-show="!sidebarCollapsed" class="whitespace-nowrap tracking-wide">Announcements</span>
                    </a>

                    <!-- Downward Small Caret (▼) toggle -->
                    <button type="button" 
                            x-show="!sidebarCollapsed" 
                            @click.stop="openMenu = !openMenu" 
                            class="p-1 rounded hover:bg-white/10 transition">
                        <svg class="w-2.5 h-2.5 text-slate-400 group-hover:text-slate-200 transition-transform duration-200" 
                             :class="openMenu ? 'rotate-180 text-white' : ''" 
                             viewBox="0 0 10 6" fill="currentColor">
                            <path d="M0 0l5 6 5-6z"/>
                        </svg>
                    </button>
                </div>

                <!-- Submenu when Expanded -->
                <div x-show="!sidebarCollapsed && openMenu" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="pl-11 pr-2 py-1 space-y-1 text-xs" 
                     style="display: none;">
                    <a href="{{ route('teacher.announcements.index') }}" class="block py-1.5 text-slate-300 hover:text-white transition">
                        📢 Class Bulletin Board
                    </a>
                    <button type="button" @click="showAnnouncementModal = true" class="block py-1.5 text-amber-300 hover:text-white transition text-left w-full cursor-pointer font-medium">
                        ➕ Post New Announcement
                    </button>
                </div>

                <!-- Tooltip when Collapsed -->
                <div x-show="sidebarCollapsed" 
                     class="opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 absolute left-full top-1/2 -translate-y-1/2 ml-3 bg-[#0d1624] text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg shadow-xl border border-slate-700 whitespace-nowrap z-50 flex items-center">
                    <span>Announcements</span>
                    <div class="absolute -left-1 top-1/2 -translate-y-1/2 w-2 h-2 bg-[#0d1624] border-l border-b border-slate-700 transform rotate-45"></div>
                </div>
            </div>

            <!-- 10. MESSAGES (Accordion - Matching Reference Image Icon) -->
            <div class="relative group" x-data="{ openMenu: {{ $active === 'messages' ? 'true' : 'false' }} }">
                <div class="flex items-center rounded-xl transition duration-200 font-medium text-sm cursor-pointer {{ $active === 'messages' ? 'bg-[#1b2b42] text-white font-bold shadow-xs border border-white/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}"
                     :class="sidebarCollapsed ? 'justify-center p-3' : 'justify-between px-3 py-2.5'">
                    
                    <a href="{{ route('teacher.messages.index') }}" class="flex items-center space-x-3.5 flex-1 min-w-0">
                        <!-- Chat bubble with three dots icon (matching reference image) -->
                        <svg class="w-5 h-5 shrink-0 {{ $active === 'messages' ? 'text-sky-400' : 'text-slate-300 group-hover:text-white' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            <circle cx="8" cy="12" r="1" fill="currentColor"/>
                            <circle cx="12" cy="12" r="1" fill="currentColor"/>
                            <circle cx="16" cy="12" r="1" fill="currentColor"/>
                        </svg>

                        <!-- Label -->
                        <span x-show="!sidebarCollapsed" class="whitespace-nowrap tracking-wide">Messages</span>
                    </a>

                    <div x-show="!sidebarCollapsed" class="flex items-center space-x-2">
                        <span class="px-1.5 py-0.5 rounded-full bg-sky-500/30 text-sky-300 font-bold text-[10px]">3</span>
                        <!-- Downward Small Caret (▼) toggle -->
                        <button type="button" 
                                @click.stop="openMenu = !openMenu" 
                                class="p-1 rounded hover:bg-white/10 transition">
                            <svg class="w-2.5 h-2.5 text-slate-400 group-hover:text-slate-200 transition-transform duration-200" 
                                 :class="openMenu ? 'rotate-180 text-white' : ''" 
                                 viewBox="0 0 10 6" fill="currentColor">
                                <path d="M0 0l5 6 5-6z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Submenu when Expanded -->
                <div x-show="!sidebarCollapsed && openMenu" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="pl-11 pr-2 py-1 space-y-1 text-xs" 
                     style="display: none;">
                    <a href="{{ route('teacher.messages.index') }}" class="block py-1.5 text-sky-300 hover:text-white font-medium transition">
                        💬 Parent & Student Inbox
                    </a>
                    <button type="button" @click="showMessageModal = true" class="block py-1.5 text-slate-300 hover:text-white transition text-left w-full cursor-pointer">
                        ✉️ Compose New Message
                    </button>
                </div>

                <!-- Tooltip when Collapsed -->
                <div x-show="sidebarCollapsed" 
                     class="opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 absolute left-full top-1/2 -translate-y-1/2 ml-3 bg-[#0d1624] text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg shadow-xl border border-slate-700 whitespace-nowrap z-50 flex items-center">
                    <span>Messages</span>
                    <div class="absolute -left-1 top-1/2 -translate-y-1/2 w-2 h-2 bg-[#0d1624] border-l border-b border-slate-700 transform rotate-45"></div>
                </div>
            </div>

        </nav>

        <!-- ============================================================== -->
        <!-- BOTTOM LOGOUT & SCHOOL BRAND                                   -->
        <!-- ============================================================== -->
        <div class="pt-3 border-t border-white/10 mt-2">
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        title="Log Out of Teacher Account"
                        class="w-full flex items-center rounded-xl p-2.5 text-slate-300 hover:text-red-300 hover:bg-red-500/10 transition duration-150 cursor-pointer text-xs font-semibold"
                        :class="sidebarCollapsed ? 'justify-center' : 'justify-between'">
                    
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-right-from-bracket text-sm shrink-0"></i>
                        <span x-show="!sidebarCollapsed" class="tracking-wide">Log Out</span>
                    </div>

                    <span x-show="!sidebarCollapsed" class="text-[10px] opacity-70">Exit</span>
                </button>
            </form>

            <div x-show="!sidebarCollapsed" class="mt-2 text-center text-[10px] text-slate-400 font-medium">
                Gradely Teacher Portal
            </div>
        </div>

    </div>
</aside>
