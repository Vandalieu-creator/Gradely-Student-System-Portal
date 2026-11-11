<!-- Global Toast Notification System -->
<div x-show="showToast"
     x-transition:enter="transition ease-out duration-300 transform"
     x-transition:enter-start="opacity-0 translate-y-[-20px] scale-95"
     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
     x-transition:leave="transition ease-in duration-200 transform"
     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
     x-transition:leave-end="opacity-0 translate-y-[-20px] scale-95"
     class="fixed top-6 right-6 z-50 bg-[#172554] text-white px-5 py-3.5 rounded-2xl shadow-2xl flex items-center space-x-3.5 border-2 border-sky-400 select-none max-w-sm"
     style="display: none;">
    <div class="w-9 h-9 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center shrink-0 border border-sky-400/30">
        <i class="fa-solid fa-circle-check text-lg"></i>
    </div>
    <div class="min-w-0 flex-1">
        <p class="text-xs font-bold text-sky-300 uppercase tracking-wider" x-text="toastTitle || 'Success'"></p>
        <p class="text-sm font-semibold text-white truncate" x-text="toastMessage"></p>
    </div>
    <button @click="showToast = false" class="text-slate-400 hover:text-white text-xs cursor-pointer">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>

<!-- ============================================================== -->
<!-- 1. CREATE ASSIGNMENT MODAL                                     -->
<!-- ============================================================== -->
<div x-show="showAssignmentModal" 
     x-transition.opacity 
     @keydown.window.escape="showAssignmentModal = false"
     class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 z-50 select-none" 
     style="display: none;"
     x-data="{
         title: '',
         classroom: 'Grade 4 - Diamond',
         subject: 'Mathematics',
         dueDate: '{{ now()->addDays(3)->format('Y-m-d') }}',
         points: 50,
         instructions: '',
         submitAssignment() {
             if (!this.title.trim()) return;
             this.showAssignmentModal = false;
             notify('Assignment \"' + this.title + '\" published successfully for ' + this.classroom + '!', 'Assignment Created');
             this.title = '';
             this.instructions = '';
         }
     }">
    
    <div @click.away="showAssignmentModal = false" 
         class="bg-white rounded-3xl p-6 sm:p-7 max-w-lg w-full shadow-2xl border-4 border-slate-100 space-y-4 relative text-slate-800 transform transition-all">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center">
                    <i class="fa-solid fa-pen-ruler text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Create New Assignment</h3>
                    <p class="text-xs text-slate-500">Post homework, projects, or review quizzes</p>
                </div>
            </div>
            <button @click="showAssignmentModal = false" class="text-slate-400 hover:text-slate-700 text-lg font-bold cursor-pointer">
                ✕
            </button>
        </div>

        <!-- Form Body -->
        <form @submit.prevent="submitAssignment()" class="space-y-3.5">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Assignment Title *</label>
                <input type="text" 
                       x-model="title" 
                       required 
                       placeholder="e.g. Fractions and Decimals Worksheet #3" 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 font-medium">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Assigned Class *</label>
                    <select x-model="classroom" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 font-medium bg-white">
                        <option value="Grade 4 - Diamond">Grade 4 - Diamond</option>
                        <option value="Grade 5 - Sapphire">Grade 5 - Sapphire</option>
                        <option value="Grade 6 - Emerald">Grade 6 - Emerald</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Subject *</label>
                    <select x-model="subject" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 font-medium bg-white">
                        <option value="Mathematics">Mathematics</option>
                        <option value="Science">Science</option>
                        <option value="English">English</option>
                        <option value="Filipino">Filipino</option>
                        <option value="MAPEH">MAPEH</option>
                        <option value="EsP">EsP</option>
                        <option value="Araling Panlipunan">Araling Panlipunan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Due Date *</label>
                    <input type="date" 
                           x-model="dueDate" 
                           required 
                           class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 font-medium bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Maximum Points</label>
                    <input type="number" 
                           x-model="points" 
                           min="5" 
                           max="100" 
                           class="w-full px-3 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 font-medium bg-white">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Instructions / Description</label>
                <textarea x-model="instructions" 
                          rows="3" 
                          placeholder="Provide directions, requirements, or reference textbook pages for students..." 
                          class="w-full p-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 font-medium resize-none"></textarea>
            </div>

            <!-- Modal Actions -->
            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-slate-100">
                <button type="button" 
                        @click="showAssignmentModal = false" 
                        class="px-4 py-2.5 rounded-xl font-bold text-xs text-slate-500 hover:bg-slate-100 transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-5 py-2.5 rounded-xl font-bold text-xs bg-[#172554] hover:bg-[#1e3a8a] text-white shadow-md transition flex items-center space-x-1.5 cursor-pointer">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    <span>Publish Assignment</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- ============================================================== -->
<!-- 2. POST ANNOUNCEMENT MODAL                                     -->
<!-- ============================================================== -->
<div x-show="showAnnouncementModal" 
     x-transition.opacity 
     @keydown.window.escape="showAnnouncementModal = false"
     class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 z-50 select-none" 
     style="display: none;"
     x-data="{
         annTitle: '',
         annTarget: 'All Classes',
         annType: 'General Announcement',
         annBody: '',
         submitAnnouncement() {
             if (!this.annTitle.trim()) return;
             this.showAnnouncementModal = false;
             notify('Announcement \"' + this.annTitle + '\" posted successfully to ' + this.annTarget + '!', 'Announcement Broadcasted');
             this.annTitle = '';
             this.annBody = '';
         }
     }">
    
    <div @click.away="showAnnouncementModal = false" 
         class="bg-white rounded-3xl p-6 sm:p-7 max-w-lg w-full shadow-2xl border-4 border-slate-100 space-y-4 relative text-slate-800 transform transition-all">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i class="fa-solid fa-bullhorn text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Post Class Announcement</h3>
                    <p class="text-xs text-slate-500">Notify students and guardians of important notices</p>
                </div>
            </div>
            <button @click="showAnnouncementModal = false" class="text-slate-400 hover:text-slate-700 text-lg font-bold cursor-pointer">
                ✕
            </button>
        </div>

        <!-- Form Body -->
        <form @submit.prevent="submitAnnouncement()" class="space-y-3.5">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Announcement Title *</label>
                <input type="text" 
                       x-model="annTitle" 
                       required 
                       placeholder="e.g. Schedule for 1st Periodical Examination" 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 font-medium">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Target Audience</label>
                    <select x-model="annTarget" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 font-medium bg-white">
                        <option value="All Classes">All My Classes</option>
                        <option value="Grade 4 - Diamond">Grade 4 - Diamond</option>
                        <option value="Grade 5 - Sapphire">Grade 5 - Sapphire</option>
                        <option value="Grade 6 - Emerald">Grade 6 - Emerald</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Notice Category</label>
                    <select x-model="annType" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 font-medium bg-white">
                        <option value="General Announcement">General Notice</option>
                        <option value="Exam Schedule">Exam Schedule</option>
                        <option value="Urgent Advisory">Urgent Advisory</option>
                        <option value="Event Reminder">School Event</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Announcement Details *</label>
                <textarea x-model="annBody" 
                          rows="4" 
                          required 
                          placeholder="Type your announcement message here for parents and students..." 
                          class="w-full p-3.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 font-medium resize-none"></textarea>
            </div>

            <!-- Modal Actions -->
            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-slate-100">
                <button type="button" 
                        @click="showAnnouncementModal = false" 
                        class="px-4 py-2.5 rounded-xl font-bold text-xs text-slate-500 hover:bg-slate-100 transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-5 py-2.5 rounded-xl font-bold text-xs bg-amber-600 hover:bg-amber-700 text-white shadow-md transition flex items-center space-x-1.5 cursor-pointer">
                    <i class="fa-solid fa-bullhorn text-xs"></i>
                    <span>Broadcast Notice</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- ============================================================== -->
<!-- 3. UPLOAD LEARNING MATERIAL MODAL                              -->
<!-- ============================================================== -->
<div x-show="showUploadModal" 
     x-transition.opacity 
     @keydown.window.escape="showUploadModal = false"
     class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 z-50 select-none" 
     style="display: none;"
     x-data="{
         matTitle: '',
         matSubject: 'Mathematics',
         matType: 'PDF Document',
         submitMaterial() {
             if (!this.matTitle.trim()) return;
             this.showUploadModal = false;
             notify('Material \"' + this.matTitle + '\" uploaded and attached to ' + this.matSubject + '!', 'Resource Added');
             this.matTitle = '';
         }
     }">
    
    <div @click.away="showUploadModal = false" 
         class="bg-white rounded-3xl p-6 sm:p-7 max-w-lg w-full shadow-2xl border-4 border-slate-100 space-y-4 relative text-slate-800 transform transition-all">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i class="fa-solid fa-folder-open text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Upload Learning Material</h3>
                    <p class="text-xs text-slate-500">Attach lecture slides, modules, worksheets, or links</p>
                </div>
            </div>
            <button @click="showUploadModal = false" class="text-slate-400 hover:text-slate-700 text-lg font-bold cursor-pointer">
                ✕
            </button>
        </div>

        <!-- Form Body -->
        <form @submit.prevent="submitMaterial()" class="space-y-3.5">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Resource Title *</label>
                <input type="text" 
                       x-model="matTitle" 
                       required 
                       placeholder="e.g. DepEd Grade 4 Math Quarter 1 Self-Learning Module" 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 font-medium">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Subject</label>
                    <select x-model="matSubject" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 font-medium bg-white">
                        <option value="Mathematics">Mathematics</option>
                        <option value="Science">Science</option>
                        <option value="English">English</option>
                        <option value="Filipino">Filipino</option>
                        <option value="MAPEH">MAPEH</option>
                        <option value="EsP">EsP</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Material Type</label>
                    <select x-model="matType" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 font-medium bg-white">
                        <option value="PDF Document">PDF Document (SLM)</option>
                        <option value="PowerPoint Slide">PowerPoint Presentation</option>
                        <option value="Word Worksheet">Printable Worksheet (DOCX)</option>
                        <option value="Video Lesson">Video Demonstration</option>
                    </select>
                </div>
            </div>

            <!-- Upload Drop Area -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Select File</label>
                <div class="border-2 border-dashed border-slate-200 hover:border-emerald-400 rounded-2xl p-6 text-center transition cursor-pointer bg-slate-50/50">
                    <i class="fa-solid fa-cloud-arrow-up text-2xl text-emerald-500 mb-2"></i>
                    <p class="text-xs font-bold text-slate-700">Click to upload or drag & drop</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">PDF, DOCX, PPTX, MP4 up to 50MB</p>
                </div>
            </div>

            <!-- Modal Actions -->
            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-slate-100">
                <button type="button" 
                        @click="showUploadModal = false" 
                        class="px-4 py-2.5 rounded-xl font-bold text-xs text-slate-500 hover:bg-slate-100 transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-5 py-2.5 rounded-xl font-bold text-xs bg-emerald-600 hover:bg-emerald-700 text-white shadow-md transition flex items-center space-x-1.5 cursor-pointer">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Save to Curriculum</span>
                </button>
            </div>
        </form>

    </div>
</div>

<!-- ============================================================== -->
<!-- 4. COMPOSE MESSAGE MODAL                                       -->
<!-- ============================================================== -->
<div x-show="showMessageModal"
     @open-message.window="
         studentRecipients = $event.detail.students || [];
         msgRecipient = $event.detail.lrn || '';
         showMessageModal = true;
     "
     
     x-transition.opacity 
     @keydown.window.escape="showMessageModal = false"
     class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 z-50 select-none" 
     style="display: none;"
     x-data="{
         msgRecipient: '',
         msgTopic: 'Homework Feedback',
         msgText: '',
         studentRecipients: [],

         recipientDropdownOpen: false,
         recipientSearch: '',
         sendNewMessage() {
             if (!this.msgText.trim()) return;
             this.showMessageModal = false;
             notify('Message sent to ' + this.msgRecipient + '!', 'Direct Message Dispatched');
             this.msgText = '';
         }
     }">
    
    <div @click.away="showMessageModal = false" 
         class="bg-white rounded-3xl p-6 sm:p-7 max-w-lg w-full shadow-2xl border-4 border-slate-100 space-y-4 relative text-slate-800 transform transition-all">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    <i class="fa-solid fa-paper-plane text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Compose New Message</h3>
                    <p class="text-xs text-slate-500">Send an inquiry response or student update</p>
                </div>
            </div>
            <button @click="showMessageModal = false" class="text-slate-400 hover:text-slate-700 text-lg font-bold cursor-pointer">
                ✕
            </button>
        </div>

        <!-- Form Body -->
        <form method="POST"
              action="{{ route('teacher.messages.store') }}"
              class="space-y-3.5">
            @csrf
            <input type="hidden" name="lrn" :value="msgRecipient">

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Recipient *</label>
                
                
                
                <div class="relative" @click.outside="recipientDropdownOpen = false">

                    <!-- Dropdown Trigger -->
                    <button
                        type="button"
                        @click="recipientDropdownOpen = !recipientDropdownOpen; recipientSearch = ''"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm hover:border-sky-400 focus:outline-none focus:ring-2 focus:ring-sky-500 transition"
                    >
                        <span
                            class="font-medium text-slate-700 truncate"
                            x-text="studentRecipients.find(s => s.lrn === msgRecipient)?.name || 'Select a student'"
                        ></span>

                    <i
                        class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-200"
                        :class="recipientDropdownOpen ? 'rotate-180' : ''"
                    ></i>
                    </button>

                    <!-- Animated Dropdown -->
                    <div
                        x-show="recipientDropdownOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        x-cloak
                        class="absolute left-0 right-0 top-full mt-2 z-50 bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden"
                    >

                        <!-- Search -->
                        <div class="p-3 border-b border-slate-100">
                            <div class="relative">
                                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>

                                <input
                                    type="text"
                                    x-model="recipientSearch"
                                    placeholder="Search student name or LRN..."
                                    class="w-full pl-9 pr-3 py-2.5 rounded-lg bg-slate-50 border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-sky-500"
                                >
                            </div>
                        </div>

                        <!-- Student Options -->
                        <div class="max-h-52 overflow-y-auto p-1.5">

                        <template
                            x-for="student in studentRecipients.filter(s =>
                                (s.name + ' ' + s.lrn + ' ' + s.class)
                                .toLowerCase()
                                .includes(recipientSearch.toLowerCase())
                            )"
                            :key="student.lrn"
                        >
                            <button
                                type="button"
                                @click="msgRecipient = student.lrn; recipientDropdownOpen = false; recipientSearch = ''"
                                class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-left hover:bg-sky-50 transition"
                                :class="msgRecipient === student.lrn ? 'bg-sky-50' : ''"
                            >
                                <div class="min-w-0">
                                    <p
                                        class="text-xs font-bold text-slate-800 truncate"
                                        x-text="student.name"
                                    ></p>

                                    <p
                                        class="text-[10px] text-slate-400 mt-0.5"
                                        x-text="student.class + ' · LRN: ' + student.lrn"
                                    ></p>
                                </div>

                                <i
                                    x-show="msgRecipient === student.lrn"
                                    class="fa-solid fa-check text-sky-600 text-xs"
                                ></i>
                            </button>
                        </template>

                        <!-- Empty Search Result -->
                        <div
                            x-show="studentRecipients.filter(s =>
                                (s.name + ' ' + s.lrn + ' ' + s.class)
                                .toLowerCase()
                                .includes(recipientSearch.toLowerCase())
                            ).length === 0"
                            class="py-6 text-center"
                        >
                            <i class="fa-solid fa-user-slash text-slate-300 text-xl"></i>
                            <p class="text-xs text-slate-400 mt-2">No students found.</p>
                        </div>

                    </div>
                </div>
            </div>



            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Subject</label>
                <input type="text" 
                       x-model="msgTopic" 
                       placeholder="e.g. Regarding Today's Math Worksheet" 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 font-medium">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Message Content *</label>
                <textarea name="body"
                          x-model="msgText" 
                          rows="4" 
                          required 
                          placeholder="Type your message to the student or parent..." 
                          class="w-full p-3.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 font-medium resize-none"></textarea>
            </div>

            <!-- Quick Template Chips -->
            <div class="flex flex-wrap gap-1.5 pt-1">
                <button type="button" @click="msgText = 'Good day! This is a reminder regarding tomorrow\'s submission deadline for the Science project.'" 
                        class="text-[11px] font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 px-2.5 py-1 rounded-full transition cursor-pointer">
                    ⏰ Deadline Reminder
                </button>
                <button type="button" @click="msgText = 'Great job on your recent performance task! Keep up the outstanding effort in our lessons.'" 
                        class="text-[11px] font-semibold bg-emerald-100 text-emerald-800 hover:bg-emerald-200 px-2.5 py-1 rounded-full transition cursor-pointer">
                    🌟 Commendation
                </button>
            </div>

            <!-- Modal Actions -->
            <div class="flex items-center justify-end space-x-2 pt-3 border-t border-slate-100">
                <button type="button" 
                        @click="showMessageModal = false" 
                        class="px-4 py-2.5 rounded-xl font-bold text-xs text-slate-500 hover:bg-slate-100 transition cursor-pointer">
                    Cancel
                </button>
                <button type="submit"
                        :disabled="!msgRecipient || !msgText.trim()"
                        :class="(!msgRecipient || !msgText.trim()) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-[#1e3a8a] cursor-pointer'"
                        class="px-5 py-2.5 rounded-xl font-bold text-xs bg-[#172554] text-white shadow-md transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    <span>Send Message</span>
                </button>
            </div>
        </form>

    </div>
</div>

