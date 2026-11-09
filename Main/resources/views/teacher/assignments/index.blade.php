<x-teacher-layout active="assignments" title="Assignments Manager">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 max-w-7xl mx-auto">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center border border-orange-100 shadow-xs">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="13" rx="2"/>
                        <path d="M8 20h8"/>
                        <path d="M12 16v4"/>
                        <rect x="7" y="6" width="10" height="7" rx="1"/>
                        <path d="M9.5 8.5h5"/>
                        <path d="M9.5 10.5h3.5"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                        Assignments Manager
                    </h1>
                    <p class="text-xs font-semibold text-slate-500">
                        Create homework, projects, track submissions, and grade student work
                    </p>
                </div>
            </div>

            <!-- Action button -->
            <button type="button" 
                    @click="showAssignmentModal = true"
                    class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold shadow-md shadow-orange-600/20 transition cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Create Assignment</span>
            </button>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6"
         x-data="{
             classFilter: 'all',
             statusFilter: 'all',
             assignments: [
                 { id: 1, title: 'Fractions & Decimal Operations Worksheet #4', subject: 'Mathematics', class: 'Grade 4 - Diamond', due: 'Nov 12, 2026', points: 50, submitted: 28, total: 32, status: 'Active' },
                 { id: 2, title: 'Draw Your Favorite Animal (Animal Habitats)', subject: 'MAPEH & Science', class: 'Grade 4 - Diamond', due: 'Nov 14, 2026', points: 30, submitted: 30, total: 32, status: 'Active' },
                 { id: 3, title: 'Philippine Ecosystems Laboratory Report', subject: 'Science', class: 'Grade 5 - Sapphire', due: 'Nov 15, 2026', points: 100, submitted: 18, total: 24, status: 'Active' },
                 { id: 4, title: 'English Reading Journal: The Blind Men and the Elephant', subject: 'English', class: 'Grade 4 - Diamond', due: 'Nov 09, 2026', points: 40, submitted: 32, total: 32, status: 'Graded' },
                 { id: 5, title: 'Pagsulat ng Maikling Kwento Tungkol sa Pamilya', subject: 'Filipino', class: 'Grade 6 - Emerald', due: 'Nov 16, 2026', points: 50, submitted: 15, total: 20, status: 'Active' }
             ],
             get filtered() {
                 return this.assignments.filter(a => {
                     const matchClass = this.classFilter === 'all' || a.class === this.classFilter;
                     const matchStatus = this.statusFilter === 'all' || a.status === this.statusFilter;
                     return matchClass && matchStatus;
                 });
             }
         }">

        <!-- Filter Bar -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Class pills -->
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" 
                        @click="classFilter = 'all'"
                        :class="classFilter === 'all' ? 'bg-[#172554] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition cursor-pointer">
                    All Classes
                </button>
                <button type="button" 
                        @click="classFilter = 'Grade 4 - Diamond'"
                        :class="classFilter === 'Grade 4 - Diamond' ? 'bg-[#172554] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition cursor-pointer">
                    Grade 4 - Diamond
                </button>
                <button type="button" 
                        @click="classFilter = 'Grade 5 - Sapphire'"
                        :class="classFilter === 'Grade 5 - Sapphire' ? 'bg-[#172554] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition cursor-pointer">
                    Grade 5 - Sapphire
                </button>
                <button type="button" 
                        @click="classFilter = 'Grade 6 - Emerald'"
                        :class="classFilter === 'Grade 6 - Emerald' ? 'bg-[#172554] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold transition cursor-pointer">
                    Grade 6 - Emerald
                </button>
            </div>

            <!-- Status buttons -->
            <div class="flex items-center space-x-2">
                <button type="button" 
                        @click="statusFilter = 'all'"
                        :class="statusFilter === 'all' ? 'text-slate-900 border-b-2 border-orange-500 font-bold' : 'text-slate-500 hover:text-slate-700'"
                        class="text-xs pb-1 px-1 transition cursor-pointer">
                    All Status
                </button>
                <button type="button" 
                        @click="statusFilter = 'Active'"
                        :class="statusFilter === 'Active' ? 'text-slate-900 border-b-2 border-orange-500 font-bold' : 'text-slate-500 hover:text-slate-700'"
                        class="text-xs pb-1 px-1 transition cursor-pointer">
                    Active
                </button>
                <button type="button" 
                        @click="statusFilter = 'Graded'"
                        :class="statusFilter === 'Graded' ? 'text-slate-900 border-b-2 border-orange-500 font-bold' : 'text-slate-500 hover:text-slate-700'"
                        class="text-xs pb-1 px-1 transition cursor-pointer">
                    Graded
                </button>
            </div>
        </div>

        <!-- Assignments Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <template x-for="item in filtered" :key="item.id">
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs hover:shadow-md transition space-y-4 flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-lg bg-orange-50 text-orange-700 border border-orange-200" x-text="item.subject"></span>
                            <span class="text-xs font-bold px-2.5 py-0.5 rounded-full"
                                  :class="item.status === 'Graded' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-sky-50 text-sky-700 border border-sky-200'"
                                  x-text="item.status"></span>
                        </div>

                        <h3 class="font-bold text-slate-900 text-base group-hover:text-orange-600 transition" x-text="item.title"></h3>

                        <div class="text-xs text-slate-500 space-y-1">
                            <p class="flex items-center space-x-1.5">
                                <i class="fa-solid fa-chalkboard-user text-slate-400"></i>
                                <span class="font-semibold text-slate-700" x-text="item.class"></span>
                            </p>
                            <p class="flex items-center space-x-1.5">
                                <i class="fa-regular fa-clock text-slate-400"></i>
                                <span>Due: <strong class="text-slate-800" x-text="item.due"></strong></span>
                            </p>
                            <p class="flex items-center space-x-1.5">
                                <i class="fa-solid fa-star text-amber-500"></i>
                                <span>Total Points: <strong class="text-slate-800" x-text="item.points + ' pts'"></strong></span>
                            </p>
                        </div>

                        <!-- Submission Progress Bar -->
                        <div class="pt-2">
                            <div class="flex justify-between text-xs font-semibold mb-1">
                                <span class="text-slate-500">Submissions</span>
                                <span class="text-slate-900 font-bold" x-text="item.submitted + ' / ' + item.total + ' (' + Math.round((item.submitted/item.total)*100) + '%)'"></span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-orange-500 to-amber-500 h-2 rounded-full transition-all duration-500"
                                     :style="'width: ' + ((item.submitted / item.total) * 100) + '%'"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <button type="button" 
                                @click="notify('Opening submission review panel for ' + item.title, 'Grade Submissions')"
                                class="text-xs font-bold text-orange-600 hover:text-orange-700 transition cursor-pointer">
                            Review & Grade →
                        </button>
                        <button type="button" 
                                @click="notify('Assignment settings opened.', 'Edit')"
                                class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition cursor-pointer">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                    </div>
                </div>
            </template>
        </div>

    </div>

</x-teacher-layout>
