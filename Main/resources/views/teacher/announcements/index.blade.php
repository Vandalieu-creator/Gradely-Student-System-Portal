<x-teacher-layout active="announcements" title="Announcements Bulletin">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 max-w-7xl mx-auto">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 shadow-xs">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 5L6 9H2v6h4l5 4V5z"/>
                        <path d="M15.54 8.46a5 5 0 0 1 0 7.07"/>
                        <path d="M19.07 4.93a10 10 0 0 1 0 14.14"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                        Class Announcements Bulletin
                    </h1>
                    <p class="text-xs font-semibold text-slate-500">
                        Post bulletins, examination schedules, and urgent notices for students & parents
                    </p>
                </div>
            </div>

            <!-- Post Announcement button -->
            <button type="button" 
                    @click="showAnnouncementModal = true"
                    class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold shadow-md shadow-amber-600/20 transition cursor-pointer">
                <i class="fa-solid fa-bullhorn text-xs"></i>
                <span>Post Announcement</span>
            </button>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6"
         x-data="{
             selectedCategory: 'all',
             announcements: [
                 {
                     id: 1,
                     title: 'First Periodical Examination Schedule & Guidelines',
                     category: 'Exam Schedule',
                     target: 'All Classes',
                     date: 'Nov 09, 2026 • 8:00 AM',
                     pinned: true,
                     content: 'Please be reminded that our First Quarterly Periodical Exams will take place on November 19-20, 2026. Students are advised to bring pencils (#2), erasers, and review all self-learning modules in Math, Science, and English. Homeroom attendance begins strictly at 7:30 AM.'
                 },
                 {
                     id: 2,
                     title: 'DepEd Catch-Up Fridays: Drop Everything and Read (DEAR)',
                     category: 'General Notice',
                     target: 'Grade 4 - Diamond',
                     date: 'Nov 07, 2026 • 2:15 PM',
                     pinned: true,
                     content: 'In compliance with DepEd Memorandum on Catch-Up Fridays, all learners in Grade 4 - Diamond should bring their favorite English or Filipino storybook this Friday afternoon for our guided silent reading circle.'
                 },
                 {
                     id: 3,
                     title: 'Upcoming Parent-Teacher Homeroom Conference (PTC)',
                     category: 'School Event',
                     target: 'All Classes',
                     date: 'Nov 05, 2026 • 10:30 AM',
                     pinned: false,
                     content: 'Distribution of Report Cards (Form 138) and consultation regarding 1st Quarter performance will be held next Saturday in our respective classrooms. Parents are requested to attend.'
                 },
                 {
                     id: 4,
                     title: 'Classroom Project Submission: Animal Habitats Diorama',
                     category: 'Urgent Advisory',
                     target: 'Grade 4 - Diamond',
                     date: 'Nov 03, 2026 • 4:00 PM',
                     pinned: false,
                     content: 'Final deadline for the MAPEH & Science animal habitat drawing and mini-diorama is scheduled for Thursday. Rubrics and criteria are available under the Learning Materials tab.'
                 }
             ],
             get filtered() {
                 if (this.selectedCategory === 'all') return this.announcements;
                 return this.announcements.filter(a => a.category === this.selectedCategory);
             },
             togglePin(id) {
                 const a = this.announcements.find(x => x.id === id);
                 if (a) {
                     a.pinned = !a.pinned;
                     notify(a.pinned ? 'Announcement pinned to top of bulletin board.' : 'Announcement unpinned.', 'Notice Status Updated');
                 }
             }
         }">

        <!-- Category Filters Bar -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-4 shadow-xs flex items-center justify-between overflow-x-auto">
            <div class="flex items-center space-x-2">
                <button type="button" 
                        @click="selectedCategory = 'all'"
                        :class="selectedCategory === 'all' ? 'bg-[#172554] text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition cursor-pointer whitespace-nowrap">
                    All Notices
                </button>
                <button type="button" 
                        @click="selectedCategory = 'Exam Schedule'"
                        :class="selectedCategory === 'Exam Schedule' ? 'bg-[#172554] text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition cursor-pointer whitespace-nowrap">
                    📝 Exam Schedules
                </button>
                <button type="button" 
                        @click="selectedCategory = 'General Notice'"
                        :class="selectedCategory === 'General Notice' ? 'bg-[#172554] text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition cursor-pointer whitespace-nowrap">
                    📢 General Notices
                </button>
                <button type="button" 
                        @click="selectedCategory = 'Urgent Advisory'"
                        :class="selectedCategory === 'Urgent Advisory' ? 'bg-[#172554] text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition cursor-pointer whitespace-nowrap">
                    ⚠️ Urgent Advisories
                </button>
                <button type="button" 
                        @click="selectedCategory = 'School Event'"
                        :class="selectedCategory === 'School Event' ? 'bg-[#172554] text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition cursor-pointer whitespace-nowrap">
                    🎉 School Events
                </button>
            </div>
        </div>

        <!-- Announcements Feed -->
        <div class="space-y-4">
            <template x-for="item in filtered" :key="item.id">
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs hover:shadow-md transition space-y-3 relative group">
                    
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b border-slate-100">
                        <div class="flex items-center space-x-2">
                            <span class="text-xs font-extrabold uppercase px-2.5 py-1 rounded-lg"
                                  :class="{
                                      'bg-amber-50 text-amber-700 border border-amber-200': item.category === 'Exam Schedule',
                                      'bg-sky-50 text-sky-700 border border-sky-200': item.category === 'General Notice',
                                      'bg-rose-50 text-rose-700 border border-rose-200': item.category === 'Urgent Advisory',
                                      'bg-purple-50 text-purple-700 border border-purple-200': item.category === 'School Event'
                                  }"
                                  x-text="item.category">
                            </span>
                            
                            <span class="text-xs font-bold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg" x-text="item.target"></span>

                            <span x-show="item.pinned" class="inline-flex items-center space-x-1 text-xs font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">
                                <i class="fa-solid fa-thumbtack text-[10px]"></i>
                                <span>Pinned</span>
                            </span>
                        </div>

                        <div class="flex items-center space-x-3 text-xs text-slate-400">
                            <span x-text="item.date"></span>
                            <button type="button" 
                                    @click="togglePin(item.id)" 
                                    class="p-1 rounded-lg text-slate-400 hover:text-amber-500 transition cursor-pointer"
                                    :title="item.pinned ? 'Unpin' : 'Pin to Top'">
                                <i class="fa-solid fa-thumbtack text-xs" :class="item.pinned ? 'text-amber-500' : ''"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Title & Content -->
                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-amber-600 transition" x-text="item.title"></h3>
                    <p class="text-xs text-slate-600 leading-relaxed font-medium" x-text="item.content"></p>

                    <!-- Author Footer -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-700 font-bold text-[10px] flex items-center justify-center">
                                M
                            </div>
                            <span>Posted by <strong>Mrs. Sarah E. Miller</strong> • Homeroom Adviser</span>
                        </div>
                        <button type="button" 
                                @click="notify('Announcement broadcast link copied to clipboard.', 'Link Copied')"
                                class="text-slate-400 hover:text-slate-600 font-semibold cursor-pointer flex items-center space-x-1">
                            <i class="fa-solid fa-share-nodes text-xs"></i>
                            <span>Share</span>
                        </button>
                    </div>

                </div>
            </template>
        </div>

    </div>

</x-teacher-layout>

