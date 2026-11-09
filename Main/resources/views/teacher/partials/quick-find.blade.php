<!-- Teacher Quick Find Command Palette (Ctrl+K / Cmd+K) -->
<div x-show="showQuickFind" 
     x-transition.opacity 
     @keydown.window.escape="showQuickFind = false"
     @keydown.window.ctrl.k.prevent="showQuickFind = true"
     @keydown.window.cmd.k.prevent="showQuickFind = true"
     class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-start justify-center pt-20 p-4 z-50 select-none" 
     style="display: none;"
     x-data="{
         search: '',
         selectedIndex: 0,
         items: [
             { title: 'Dashboard Overview', desc: 'Classroom statistics, attendance summary, schedule', category: 'Navigation', icon: 'fa-house', url: '{{ route('teacher.dashboard') }}' },
             { title: 'My Classes', desc: 'Manage classrooms and class enrollments', category: 'Navigation', icon: 'fa-chalkboard-user', url: '{{ route('teacher.classes.index') }}' },
             { title: 'My Students Directory', desc: 'Browse all students, view profiles and LRNs', category: 'Navigation', icon: 'fa-user-group', url: '{{ route('teacher.students.all') }}' },
             { title: 'Daily Attendance', desc: 'Take daily roll call and review logs', category: 'Navigation', icon: 'fa-clipboard-check', url: '{{ route('teacher.attendance.index') }}' },
             { title: 'Class Schedule', desc: 'Weekly timetable and subject schedule', category: 'Navigation', icon: 'fa-calendar-days', url: '{{ route('teacher.schedule.index') }}' },
             { title: 'Assignments Manager', desc: 'Create tasks and track student submissions', category: 'Navigation', icon: 'fa-book-open', url: '{{ route('teacher.assignments.index') }}' },
             { title: 'Learning Materials', desc: 'Curriculum modules, lesson plans, worksheets', category: 'Navigation', icon: 'fa-folder-open', url: '{{ route('teacher.materials.index') }}' },
             { title: 'Grades & Reports', desc: 'Class gradebook, quarterly grades, Form 138 cards', category: 'Navigation', icon: 'fa-award', url: '{{ route('teacher.grades.index') }}' },
             { title: 'Class Announcements', desc: 'Post bulletins and school alerts to classes', category: 'Navigation', icon: 'fa-bullhorn', url: '{{ route('teacher.announcements.index') }}' },
             { title: 'Messages & Inquiries', desc: 'Chat with students and parents', category: 'Navigation', icon: 'fa-comments', url: '{{ route('teacher.messages.index') }}' },
             { title: 'Grade 4 - Diamond (Classroom)', desc: 'Room 204 • 8 Enrolled Students', category: 'Class', icon: 'fa-diamond', url: '{{ route('teacher.classes.index') }}' },
             { title: 'Grade 5 - Sapphire (Classroom)', desc: 'Room 102 • 4 Enrolled Students', category: 'Class', icon: 'fa-gem', url: '{{ route('teacher.classes.index') }}' },
             { title: 'Grade 6 - Emerald (Classroom)', desc: 'Room 301 • 3 Enrolled Students', category: 'Class', icon: 'fa-cube', url: '{{ route('teacher.classes.index') }}' },
             { title: 'Jm Marvie Brizuela', desc: 'LRN: 109876543210 • Grade 4 - Diamond', category: 'Student', icon: 'fa-user', url: '{{ route('teacher.students.all') }}?search=Brizuela' },
             { title: 'Eduard Licatan', desc: 'LRN: 109876543211 • Grade 4 - Diamond', category: 'Student', icon: 'fa-user', url: '{{ route('teacher.students.all') }}?search=Licatan' },
             { title: 'Clint John Orbillo', desc: 'LRN: 109876543212 • Grade 4 - Diamond', category: 'Student', icon: 'fa-user', url: '{{ route('teacher.students.all') }}?search=Orbillo' },
             { title: 'Charles Cabrera', desc: 'LRN: 109876543213 • Grade 4 - Diamond', category: 'Student', icon: 'fa-user', url: '{{ route('teacher.students.all') }}?search=Cabrera' },
             { title: 'Sophia Marie Alcantara', desc: 'LRN: 109876543214 • Grade 4 - Diamond', category: 'Student', icon: 'fa-user', url: '{{ route('teacher.students.all') }}?search=Alcantara' },
             { title: 'Angela Grace Villanueva', desc: 'LRN: 109876543215 • Grade 4 - Diamond', category: 'Student', icon: 'fa-user', url: '{{ route('teacher.students.all') }}?search=Villanueva' },
             { title: '+ Create New Assignment', desc: 'Draft homework or quiz for your students', category: 'Action', icon: 'fa-plus', action: 'assignment' },
             { title: '+ Post Class Announcement', desc: 'Broadcast a notice to parents and students', category: 'Action', icon: 'fa-bullhorn', action: 'announcement' },
             { title: '+ Upload Learning Material', desc: 'Add lesson plan, PDF module, or worksheet', category: 'Action', icon: 'fa-upload', action: 'upload' }
         ],
         get filteredItems() {
             if (!this.search.trim()) return this.items;
             const q = this.search.toLowerCase();
             return this.items.filter(i => 
                 i.title.toLowerCase().includes(q) || 
                 i.desc.toLowerCase().includes(q) || 
                 i.category.toLowerCase().includes(q)
             );
         },
         trigger(item) {
             this.showQuickFind = false;
             if (item.action === 'assignment') {
                 showAssignmentModal = true;
             } else if (item.action === 'announcement') {
                 showAnnouncementModal = true;
             } else if (item.action === 'upload') {
                 showUploadModal = true;
             } else if (item.url) {
                 window.location.href = item.url;
             }
         }
     }">
    
    <div @click.away="showQuickFind = false" 
         class="bg-[#121c2e] border border-slate-700/80 rounded-3xl max-w-xl w-full shadow-2xl overflow-hidden transform transition-all text-slate-200">
        
        <!-- Search Input Bar -->
        <div class="flex items-center px-4 py-3.5 border-b border-slate-700/60 bg-[#162338]">
            <svg class="w-5 h-5 text-sky-400 mr-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7"/>
                <path d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" 
                   x-model="search" 
                   x-ref="quickFindInput"
                   placeholder="Search students, classes, attendance, assignments, or tools..."
                   class="bg-transparent border-none text-white text-sm w-full focus:outline-none placeholder-slate-400 font-medium"
                   autofocus>
            <button @click="showQuickFind = false" class="text-xs bg-slate-700/70 hover:bg-slate-700 px-2 py-1 rounded text-slate-300 font-mono transition cursor-pointer">
                ESC
            </button>
        </div>

        <!-- Search Results List -->
        <div class="max-h-80 overflow-y-auto p-2 space-y-1 custom-scrollbar">
            <template x-for="(item, index) in filteredItems" :key="index">
                <div @click="trigger(item)"
                     class="flex items-center justify-between p-2.5 rounded-2xl hover:bg-white/10 transition cursor-pointer group">
                    <div class="flex items-center space-x-3 min-w-0">
                        <div class="w-8 h-8 rounded-xl bg-slate-800/80 group-hover:bg-[#00adef]/20 flex items-center justify-center text-sky-400 shrink-0 transition border border-white/5">
                            <i :class="'fa-solid ' + item.icon + ' text-xs'"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-white group-hover:text-sky-300 transition truncate" x-text="item.title"></p>
                            <p class="text-[11px] text-slate-400 truncate" x-text="item.desc"></p>
                        </div>
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold uppercase tracking-wider shrink-0"
                          :class="{
                              'bg-sky-500/20 text-sky-300': item.category === 'Navigation',
                              'bg-purple-500/20 text-purple-300': item.category === 'Class',
                              'bg-emerald-500/20 text-emerald-300': item.category === 'Student',
                              'bg-amber-500/20 text-amber-300': item.category === 'Action'
                          }"
                          x-text="item.category">
                    </span>
                </div>
            </template>

            <div x-show="filteredItems.length === 0" class="py-8 text-center text-slate-400 text-xs">
                No matching results for "<span x-text="search" class="text-white font-semibold"></span>"
            </div>
        </div>

        <!-- Palette Footer with Hotkey Tips -->
        <div class="px-4 py-2 bg-[#0c1422] border-t border-slate-700/60 flex items-center justify-between text-[11px] text-slate-400">
            <span>Press <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-slate-300 font-mono text-[10px]">ESC</kbd> to exit</span>
            <span class="flex items-center space-x-1">
                <span>Teacher Quick Palette</span>
                <span class="text-sky-400 font-bold">•</span>
                <span>Gradely Portal</span>
            </span>
        </div>

    </div>
</div>
