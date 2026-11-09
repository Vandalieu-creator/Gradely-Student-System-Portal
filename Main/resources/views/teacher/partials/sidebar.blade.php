
@props(['active' => 'dashboard'])

<aside
    class="relative flex flex-col shrink-0 transition-all duration-300 ease-in-out z-40 select-none overflow-hidden"
    :class="sidebarCollapsed ? 'w-[74px]' : 'w-64'"
    style="background: linear-gradient(180deg, #101a2a 0%, #142236 38%, #1a2b44 72%, #3c516f 90%, #a2b5cc 100%); min-height: 100vh;">

    <div class="pointer-events-none absolute bottom-0 left-0 right-0 h-36 bg-gradient-to-t from-slate-200/55 via-slate-300/15 to-transparent z-10"></div>

    <div class="relative z-20 flex flex-col h-screen p-3 sm:p-3.5">

        <!-- TOP SECTION -->
        <div class="space-y-3 pb-3">

            <!-- Collapse Button -->
            <div class="flex justify-end pt-1 pr-1">
                <button type="button"
                    @click="toggleSidebar()"
                    title="Collapse Sidebar"
                    class="h-7 w-7 rounded-lg bg-[#18273b] hover:bg-[#22354f] text-slate-300 hover:text-white flex items-center justify-center transition border border-white/10 shadow-sm">

                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                </button>
            </div>

            <!-- Expanded Teacher Banner -->
            <div x-show="!sidebarCollapsed">
                <div class="w-full bg-[#00adef] text-white flex items-center px-3.5 py-2.5 rounded-2xl shadow-lg border border-sky-400/30">

                    <div class="w-8 h-8 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M12 3 2 8l10 5 10-5-10-5Z"/>
                            <path d="M6 10v6c3 3 9 3 12 0v-6"/>
                            <path d="M22 8v7"/>
                        </svg>
                    </div>

                    <div class="ml-3 min-w-0">
                        <span class="text-sm font-bold tracking-wide block">Teacher</span>
                        <span class="text-[10px] text-sky-100 block truncate max-w-[150px]">
                            {{ auth('teacher')->user()?->name ?? auth('teacher')->user()?->first_name ?? 'Teacher Account' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Collapsed Teacher Icon -->
            <div x-show="sidebarCollapsed" class="flex justify-center">
                <button type="button"
                    @click="toggleSidebar()"
                    title="Expand Sidebar"
                    class="w-12 h-12 rounded-2xl bg-[#00adef] text-white flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </button>
            </div>
        </div>

        <!-- NAVIGATION -->
        <nav class="space-y-1.5 overflow-y-auto overflow-x-hidden">

            <p x-show="!sidebarCollapsed"
                class="px-2 pt-2 pb-1 text-[9px] uppercase tracking-widest font-bold text-slate-500">
                Primary Menu
            </p>

            <!-- Dashboard -->
            <a href="{{ route('teacher.dashboard') }}"
                title="Dashboard"
                class="group flex items-center rounded-xl transition text-sm
                {{ $active === 'dashboard' ? 'bg-[#1b2b42] text-white font-bold border border-white/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}"
                :class="sidebarCollapsed ? 'justify-center p-3' : 'px-3 py-2.5'">

                <i class="fa-solid fa-house w-5 text-center shrink-0 {{ $active === 'dashboard' ? 'text-sky-400' : '' }}"></i>
                <span x-show="!sidebarCollapsed" class="ml-3 tracking-wide">Dashboard</span>
                <span x-show="!sidebarCollapsed && '{{ $active }}' === 'dashboard'"
                    class="ml-auto w-1.5 h-1.5 rounded-full bg-sky-400"></span>
            </a>

            <!-- E-Class Record -->
            <a href="{{ route('teacher.e-class-record') }}"
                title="E-Class Record"
                class="group flex items-center rounded-xl transition text-sm
                {{ $active === 'e-class-record' ? 'bg-[#1b2b42] text-white font-bold border border-white/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}"
                :class="sidebarCollapsed ? 'justify-center p-3' : 'px-3 py-2.5'">

                <i class="fa-regular fa-folder-open w-5 text-center shrink-0 {{ $active === 'e-class-record' ? 'text-sky-400' : '' }}"></i>
                <span x-show="!sidebarCollapsed" class="ml-3 tracking-wide">E-Class Record</span>
                <span x-show="!sidebarCollapsed && '{{ $active }}' === 'e-class-record'"
                    class="ml-auto w-1.5 h-1.5 rounded-full bg-sky-400"></span>
            </a>

            <!-- Phil-IRI Reading -->
            <a href="#" title="Phil-IRI Reading"
                class="group flex items-center rounded-xl px-3 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition"
                :class="sidebarCollapsed ? 'justify-center p-3' : ''">
                <i class="fa-solid fa-book-open w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="ml-3 tracking-wide">Phil-IRI Reading</span>
            </a>

            <!-- Attendance -->
            <a href="#" title="Attendance"
                class="group flex items-center rounded-xl px-3 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition"
                :class="sidebarCollapsed ? 'justify-center p-3' : ''">
                <i class="fa-regular fa-calendar-check w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="ml-3 tracking-wide">Attendance</span>
            </a>

            <!-- My Students -->
            <a href="{{ route('teacher.classes.index') }}" title="My Students"
                class="group flex items-center rounded-xl px-3 py-2.5 text-sm
                {{ $active === 'students' ? 'bg-[#1b2b42] text-white font-bold border border-white/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}"
                :class="sidebarCollapsed ? 'justify-center p-3' : ''">
                <i class="fa-solid fa-users w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="ml-3 tracking-wide">My Students</span>
            </a>

            <!-- DepEd Reports -->
            <a href="#" title="DepEd Reports"
                class="group flex items-center rounded-xl px-3 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition"
                :class="sidebarCollapsed ? 'justify-center p-3' : ''">
                <i class="fa-solid fa-chart-column w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="ml-3 tracking-wide">DepEd Reports</span>
            </a>

            <!-- Class Settings -->
            <a href="#" title="Class Settings"
                class="group flex items-center rounded-xl px-3 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition"
                :class="sidebarCollapsed ? 'justify-center p-3' : ''">
                <i class="fa-solid fa-gear w-5 text-center shrink-0"></i>
                <span x-show="!sidebarCollapsed" class="ml-3 tracking-wide">Class Settings</span>
            </a>

        </nav>

        <!-- LOGOUT SECTION -->
        <div class="pt-3 border-t border-white/10 mt-2">

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center rounded-xl p-2.5 text-slate-300 hover:text-red-300 hover:bg-red-500/10 transition text-xs font-semibold"
                    :class="sidebarCollapsed ? 'justify-center' : 'justify-between'">

                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-right-from-bracket text-sm shrink-0"></i>
                        <span x-show="!sidebarCollapsed">Log Out</span>
                    </div>

                    <span x-show="!sidebarCollapsed" class="text-[10px] opacity-70">Exit</span>
                </button>
            </form>

            <div x-show="!sidebarCollapsed"
                class="mt-2 text-center text-[10px] text-slate-400 font-medium">
                Gradely Teacher Portal
            </div>
        </div>

    </div>
</aside>
