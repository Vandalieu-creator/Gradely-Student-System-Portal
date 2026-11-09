<x-teacher-layout active="materials" title="Learning Materials">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 max-w-7xl mx-auto">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shadow-xs">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5v-13A2.5 2.5 0 0 1 6.5 4H12v15H6.5A2.5 2.5 0 0 0 4 19.5z"/>
                        <path d="M20 19.5v-13A2.5 2.5 0 0 0 17.5 4H12v15h5.5a2.5 2.5 0 0 1 2.5 2.5z"/>
                        <path d="M6.5 8h3.5"/>
                        <path d="M6.5 11h3.5"/>
                        <path d="M14 8h3.5"/>
                        <path d="M14 11h3.5"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                        Learning Materials & Curriculum
                    </h1>
                    <p class="text-xs font-semibold text-slate-500">
                        Lesson plans, self-learning modules (SLMs), slide decks, and printables
                    </p>
                </div>
            </div>

            <!-- Upload button -->
            <button type="button" 
                    @click="showUploadModal = true"
                    class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition cursor-pointer">
                <i class="fa-solid fa-cloud-arrow-up text-xs"></i>
                <span>Upload Material</span>
            </button>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6"
         x-data="{
             selectedSubject: 'all',
             resources: [
                 { id: 1, title: 'Grade 4 Mathematics Quarter 1 SLM: Understanding Fractions', subject: 'Mathematics', type: 'PDF', size: '3.8 MB', date: 'Nov 02, 2026', downloads: 34 },
                 { id: 2, title: 'Lesson Plan: Digestive and Respiratory Systems in Animals', subject: 'Science', type: 'DOCX', size: '1.2 MB', date: 'Oct 28, 2026', downloads: 29 },
                 { id: 3, title: 'Interactive Slide Presentation: Parts of Speech & Verbs', subject: 'English', type: 'PPTX', size: '14.5 MB', date: 'Oct 25, 2026', downloads: 41 },
                 { id: 4, title: 'Kuwentong Bayan at Pabula: Si Pagong at si Matsing', subject: 'Filipino', type: 'PDF', size: '2.4 MB', date: 'Oct 20, 2026', downloads: 22 },
                 { id: 5, title: 'Catch-Up Friday Guided Reading Passages (Grade 4-6)', subject: 'Reading', type: 'PDF', size: '5.1 MB', date: 'Nov 04, 2026', downloads: 58 },
                 { id: 6, title: 'Traditional Filipino Folk Dances: Tinikling Video Guide', subject: 'MAPEH', type: 'MP4', size: '48.2 MB', date: 'Oct 18, 2026', downloads: 19 }
             ],
             get filtered() {
                 if (this.selectedSubject === 'all') return this.resources;
                 return this.resources.filter(r => r.subject === this.selectedSubject);
             }
         }">

        <!-- Subject Filters Bar -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-4 shadow-xs flex items-center justify-between overflow-x-auto">
            <div class="flex items-center space-x-2">
                <button type="button" 
                        @click="selectedSubject = 'all'"
                        :class="selectedSubject === 'all' ? 'bg-[#172554] text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition cursor-pointer whitespace-nowrap">
                    All Subjects (6)
                </button>
                <button type="button" 
                        @click="selectedSubject = 'Mathematics'"
                        :class="selectedSubject === 'Mathematics' ? 'bg-[#172554] text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition cursor-pointer whitespace-nowrap">
                    🔢 Mathematics
                </button>
                <button type="button" 
                        @click="selectedSubject = 'Science'"
                        :class="selectedSubject === 'Science' ? 'bg-[#172554] text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition cursor-pointer whitespace-nowrap">
                    🔬 Science
                </button>
                <button type="button" 
                        @click="selectedSubject = 'English'"
                        :class="selectedSubject === 'English' ? 'bg-[#172554] text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition cursor-pointer whitespace-nowrap">
                    📚 English
                </button>
                <button type="button" 
                        @click="selectedSubject = 'Filipino'"
                        :class="selectedSubject === 'Filipino' ? 'bg-[#172554] text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition cursor-pointer whitespace-nowrap">
                    🇵🇭 Filipino
                </button>
                <button type="button" 
                        @click="selectedSubject = 'MAPEH'"
                        :class="selectedSubject === 'MAPEH' ? 'bg-[#172554] text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 font-semibold'"
                        class="px-4 py-2 rounded-xl text-xs transition cursor-pointer whitespace-nowrap">
                    🎨 MAPEH
                </button>
            </div>
        </div>

        <!-- Materials Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <template x-for="item in filtered" :key="item.id">
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs hover:shadow-md transition space-y-4 flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-extrabold uppercase px-2.5 py-1 rounded-lg"
                                  :class="{
                                      'bg-rose-50 text-rose-700 border border-rose-200': item.type === 'PDF',
                                      'bg-blue-50 text-blue-700 border border-blue-200': item.type === 'DOCX',
                                      'bg-amber-50 text-amber-700 border border-amber-200': item.type === 'PPTX',
                                      'bg-purple-50 text-purple-700 border border-purple-200': item.type === 'MP4'
                                  }"
                                  x-text="item.type">
                            </span>
                            <span class="text-[11px] font-semibold text-slate-400" x-text="item.size"></span>
                        </div>

                        <h3 class="font-bold text-slate-900 text-sm group-hover:text-emerald-600 transition" x-text="item.title"></h3>

                        <div class="text-xs text-slate-500 space-y-1">
                            <p class="flex items-center space-x-1.5">
                                <span class="font-bold text-slate-700" x-text="item.subject"></span>
                                <span>•</span>
                                <span x-text="'Uploaded ' + item.date"></span>
                            </p>
                            <p class="text-slate-400" x-text="item.downloads + ' student downloads'"></p>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <button type="button" 
                                @click="notify('Downloading ' + item.title + ' (' + item.size + ')...', 'Download Started')"
                                class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition flex items-center space-x-1.5 cursor-pointer">
                            <i class="fa-solid fa-download text-xs"></i>
                            <span>Download Resource</span>
                        </button>
                        <button type="button" 
                                @click="notify('Opening full preview of ' + item.title, 'Document Preview')"
                                class="text-xs font-semibold text-slate-400 hover:text-slate-600 cursor-pointer">
                            Preview
                        </button>
                    </div>
                </div>
            </template>
        </div>

    </div>

</x-teacher-layout>

