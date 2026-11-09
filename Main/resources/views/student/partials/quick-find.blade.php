<!-- Quick Find Modal Component -->
<div x-show="showQuickFind" 
     x-transition.opacity 
     @keydown.window.escape="showQuickFind = false"
     @keydown.window.cmd.k.prevent="showQuickFind = true"
     @keydown.window.ctrl.k.prevent="showQuickFind = true"
     class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-start justify-center pt-20 p-4 z-50 select-none" 
     style="display: none;">
    
    <div @click.away="showQuickFind = false" 
         class="bg-[#121c2e] text-white rounded-3xl p-5 sm:p-6 max-w-xl w-full shadow-2xl border border-slate-700/80 space-y-4 transform transition-all">
        
        <!-- Search Input Bar -->
        <div class="relative flex items-center">
            <svg class="w-5 h-5 text-sky-400 absolute left-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7"/>
                <path d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" 
                   x-model="quickSearchQuery" 
                   x-ref="quickSearchInput"
                   x-init="$watch('showQuickFind', value => { if (value) setTimeout(() => $refs.quickSearchInput?.focus(), 100); })"
                   placeholder="Quick search subjects, homework, grades, teacher, schedule..." 
                   class="w-full pl-12 pr-10 py-3.5 rounded-2xl bg-[#1b2b42] border border-slate-600/70 text-sm text-white placeholder-slate-400 focus:outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-400/20 font-medium">
            
            <button @click="showQuickFind = false; quickSearchQuery = ''" class="absolute right-3.5 text-slate-400 hover:text-white text-sm font-bold p-1 cursor-pointer">
                ✕
            </button>
        </div>

        <!-- Quick Suggestions List -->
        <div class="space-y-1.5 max-h-72 overflow-y-auto pr-1 text-sm custom-scrollbar">
            
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3 pt-2">Suggestions & Actions</p>

            <!-- 1. Dashboard -->
            <a href="{{ route('student.dashboard') }}" 
               @click="showQuickFind = false"
               x-show="!quickSearchQuery || 'dashboard home'.includes(quickSearchQuery.toLowerCase())"
               class="flex items-center justify-between p-3 rounded-2xl hover:bg-white/10 transition group cursor-pointer">
                <div class="flex items-center space-x-3">
                    <span class="w-8 h-8 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center">
                        <i class="fa-solid fa-house text-xs"></i>
                    </span>
                    <div>
                        <p class="font-bold text-white text-xs sm:text-sm">Student Dashboard</p>
                        <p class="text-[11px] text-slate-400">Overview, stars, and subjects</p>
                    </div>
                </div>
                <span class="text-[11px] text-slate-400 group-hover:text-sky-300">Jump &rarr;</span>
            </a>

            <!-- 2. View My Grades / Report Card -->
            <a href="{{ route('student.grades') }}" 
               @click="showQuickFind = false"
               x-show="!quickSearchQuery || 'grades report card grading marks scores'.includes(quickSearchQuery.toLowerCase())"
               class="flex items-center justify-between p-3 rounded-2xl hover:bg-white/10 transition group cursor-pointer">
                <div class="flex items-center space-x-3">
                    <span class="w-8 h-8 rounded-xl bg-teal-500/20 text-teal-400 flex items-center justify-center">
                        <i class="fa-solid fa-graduation-cap text-xs"></i>
                    </span>
                    <div>
                        <p class="font-bold text-white text-xs sm:text-sm">View Report Card & Grades</p>
                        <p class="text-[11px] text-slate-400">Quarter 1 to 4 academic grades</p>
                    </div>
                </div>
                <span class="text-[11px] text-teal-300 font-bold">91.8% Avg</span>
            </a>

            <!-- 3. Daily Class Schedule (Opens Schedule Modal) -->
            <div @click="showQuickFind = false; showScheduleModal = true" 
                 x-show="!quickSearchQuery || 'schedule class time periods routine bell timetable'.includes(quickSearchQuery.toLowerCase())"
                 class="flex items-center justify-between p-3 rounded-2xl hover:bg-white/10 transition cursor-pointer group">
                <div class="flex items-center space-x-3">
                    <span class="w-8 h-8 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center">
                        📅
                    </span>
                    <div>
                        <p class="font-bold text-white text-xs sm:text-sm">Daily Class Schedule</p>
                        <p class="text-[11px] text-slate-400">Grade 4 - Diamond timetable & periods</p>
                    </div>
                </div>
                <span class="text-[11px] text-indigo-400 font-bold">Open &rarr;</span>
            </div>

            <!-- 4. Math Homework -->
            <div @click="showQuickFind = false; window.location.href = '{{ route('student.dashboard') }}#homework'" 
                 x-show="!quickSearchQuery || 'math worksheet adding subtracting homework'.includes(quickSearchQuery.toLowerCase())"
                 class="flex items-center justify-between p-3 rounded-2xl hover:bg-white/10 transition cursor-pointer group">
                <div class="flex items-center space-x-3">
                    <span class="w-8 h-8 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center">
                        🔢
                    </span>
                    <div>
                        <p class="font-bold text-white text-xs sm:text-sm">Math Worksheet #4</p>
                        <p class="text-[11px] text-slate-400">Adding and Subtracting &bull; Completed ✓</p>
                    </div>
                </div>
                <span class="text-[11px] text-emerald-400 font-bold">+10 ⭐</span>
            </div>

            <!-- 5. Art Homework Task (Opens Modal) -->
            <div @click="showQuickFind = false; showModal = true" 
                 x-show="!quickSearchQuery || 'draw animal art homework mapeh task'.includes(quickSearchQuery.toLowerCase())"
                 class="flex items-center justify-between p-3 rounded-2xl hover:bg-white/10 transition cursor-pointer group">
                <div class="flex items-center space-x-3">
                    <span class="w-8 h-8 rounded-xl bg-orange-500/20 text-orange-400 flex items-center justify-center">
                        🎨
                    </span>
                    <div>
                        <p class="font-bold text-white text-xs sm:text-sm">Draw Your Favorite Animal</p>
                        <p class="text-[11px] text-slate-400">MAPEH Art Assignment &bull; Today's Task</p>
                    </div>
                </div>
                <span class="text-[11px] text-orange-400 font-bold">Start &rarr;</span>
            </div>

            <!-- 6. Ask Teacher Mrs. Miller (Opens Chat Modal) -->
            <div @click="showQuickFind = false; showTeacherModal = true" 
                 x-show="!quickSearchQuery || 'teacher mrs miller ask help message question support'.includes(quickSearchQuery.toLowerCase())"
                 class="flex items-center justify-between p-3 rounded-2xl hover:bg-white/10 transition cursor-pointer group">
                <div class="flex items-center space-x-3">
                    <span class="w-8 h-8 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center">
                        💬
                    </span>
                    <div>
                        <p class="font-bold text-white text-xs sm:text-sm">Ask Mrs. Miller</p>
                        <p class="text-[11px] text-slate-400">Homeroom Teacher &bull; Send a question</p>
                    </div>
                </div>
                <span class="text-[11px] text-sky-400 font-bold">Chat &rarr;</span>
            </div>

            <!-- 7. Student Help & FAQs (Opens Help Modal) -->
            <div @click="showQuickFind = false; showHelpModal = true" 
                 x-show="!quickSearchQuery || 'help faq guide rules stars standing support'.includes(quickSearchQuery.toLowerCase())"
                 class="flex items-center justify-between p-3 rounded-2xl hover:bg-white/10 transition cursor-pointer group">
                <div class="flex items-center space-x-3">
                    <span class="w-8 h-8 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center">
                        🌟
                    </span>
                    <div>
                        <p class="font-bold text-white text-xs sm:text-sm">Student Guide & FAQs</p>
                        <p class="text-[11px] text-slate-400">How to earn stars, check grades, etc.</p>
                    </div>
                </div>
                <span class="text-[11px] text-purple-400 font-bold">View &rarr;</span>
            </div>

            <!-- 8. Subjects Overview -->
            <div @click="showQuickFind = false; window.location.href = '{{ route('student.dashboard') }}#subjects'" 
                 x-show="!quickSearchQuery || 'subjects science math english filipino mapeh esp curriculum'.includes(quickSearchQuery.toLowerCase())"
                 class="flex items-center justify-between p-3 rounded-2xl hover:bg-white/10 transition cursor-pointer group">
                <div class="flex items-center space-x-3">
                    <span class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center">
                        📚
                    </span>
                    <div>
                        <p class="font-bold text-white text-xs sm:text-sm">Curriculum & Subjects</p>
                        <p class="text-[11px] text-slate-400">All 7 elementary learning areas</p>
                    </div>
                </div>
                <span class="text-[11px] text-emerald-400 font-bold">View &rarr;</span>
            </div>

        </div>

        <!-- Footer Shortcuts Info -->
        <div class="pt-3 border-t border-slate-700/60 flex items-center justify-between text-[11px] text-slate-400">
            <span>Press <kbd class="px-1.5 py-0.5 rounded bg-slate-800 border border-slate-700 text-slate-300">ESC</kbd> to close</span>
            <span>Ginatilan Elementary Portal</span>
        </div>

    </div>
</div>
