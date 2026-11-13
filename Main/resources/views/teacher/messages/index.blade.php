<x-teacher-layout active="messages" title="Teacher Messages Inbox">

    @php
        $teacher = auth('teacher')->user();

        // 1. Load all messages for this teacher
        $allMessages = \App\Models\TeacherMessage::with('studentUser')
            ->where('teacher_id', $teacher->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // 2. Load enrolled students in this teacher's classes
        $classes = \App\Models\SchoolClass::with('students')
            ->where('teacher_id', $teacher->id)
            ->get();
        $enrolledStudents = $classes->flatMap->students;

        $threadsByUserId = [];

        // First, add every student who already has messages with this teacher
        foreach ($allMessages->groupBy('student_user_id') as $userId => $stuMsgs) {
            $user = $stuMsgs->first()->studentUser;
            if (!$user) continue;

            $stuRecord = \App\Models\Student::with('schoolClass')
                ->where('lrn', $user->lrn ?? '')
                ->first();

            $lastMsg = $stuMsgs->last();

            $threadsByUserId[$user->id] = [
                'id' => $user->id,
                'name' => $stuRecord ? trim($stuRecord->first_name . ' ' . $stuRecord->last_name) : $user->name,
                'role' => 'Student • ' . ($stuRecord?->schoolClass?->grade_level ?? 'Grade 1') . ' - ' . ($stuRecord?->schoolClass?->section ?? 'Section'),
                'lrn' => $user->lrn ?? $stuRecord?->lrn ?? 'N/A',
                'unread' => $stuMsgs->where('sender', 'student')->where('is_read', false)->count(),
                'lastTime' => $lastMsg ? $lastMsg->created_at->format('g:i A') : 'New',
                'messages' => $stuMsgs->map(fn($m) => [
                    'sender' => $m->sender,
                    'text' => $m->message,
                    'time' => $m->created_at->format('M d, g:i A'),
                ])->values()->all(),
            ];
        }

        // Second, add any enrolled students in this teacher's class who haven't messaged yet
        foreach ($enrolledStudents as $stu) {
            $user = \App\Models\User::where('role', 'student')
                ->where(function ($q) use ($stu) {
                    if (!empty($stu->lrn)) {
                        $q->where('lrn', trim($stu->lrn));
                    }
                    $q->orWhere('name', 'like', '%' . trim($stu->first_name) . '%');
                })
                ->first();

            if (!$user || isset($threadsByUserId[$user->id])) continue;

            $threadsByUserId[$user->id] = [
                'id' => $user->id,
                'name' => trim($stu->first_name . ' ' . $stu->last_name),
                'role' => 'Student • ' . ($stu->schoolClass?->grade_level ?? 'Grade 1') . ' - ' . ($stu->schoolClass?->section ?? 'Section'),
                'lrn' => $stu->lrn ?? $user->lrn ?? 'N/A',
                'unread' => 0,
                'lastTime' => 'New',
                'messages' => [],
            ];
        }

        $threadsData = array_values($threadsByUserId);
    @endphp

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 max-w-7xl mx-auto">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center border border-sky-100 shadow-xs">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        <circle cx="8" cy="12" r="1" fill="currentColor"/>
                        <circle cx="12" cy="12" r="1" fill="currentColor"/>
                        <circle cx="16" cy="12" r="1" fill="currentColor"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                        Messages & Student Inquiries
                    </h1>
                    <p class="text-xs font-semibold text-slate-500">
                        Direct communication channel with enrolled learners and guardians
                    </p>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8"
         x-data="{
             searchQuery: '',
             threads: @js($threadsData),
             activeThreadId: {{ $threadsData[0]['id'] ?? 'null' }},
             replyText: '',
             get filteredThreads() {
                 if (!this.searchQuery.trim()) return this.threads;
                 const q = this.searchQuery.toLowerCase();
                 return this.threads.filter(t => t.name.toLowerCase().includes(q) || t.lrn.toLowerCase().includes(q));
             },
             get activeThread() {
                 return this.threads.find(t => t.id === this.activeThreadId) || this.threads[0] || null;
             },
             async sendMessage() {
                 if (!this.replyText.trim() || !this.activeThread) return;
                 const text = this.replyText;
                 this.replyText = '';

                 const token = document.head.querySelector('meta[name=csrf-token]')?.content || '{{ csrf_token() }}';

                 const res = await fetch('{{ route('teacher.messages.send') }}', {
                     method: 'POST',
                     headers: {
                         'Content-Type': 'application/json',
                         'Accept': 'application/json',
                         'X-CSRF-TOKEN': token
                     },
                     body: JSON.stringify({
                         student_user_id: this.activeThread.id,
                         message: text
                     })
                 });

                 if (res.ok) {
                     const data = await res.json();
                     this.activeThread.messages.push({
                         sender: 'teacher',
                         text: text,
                         time: data.time || 'Just now'
                     });
                     this.activeThread.lastTime = data.time || 'Just now';

                     this.$nextTick(() => {
                         const box = document.getElementById('chat-scroll-box');
                         if (box) box.scrollTop = box.scrollHeight;
                     });
                 }
             }
         }">

        <!-- Two-Column Messenger Container -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col md:flex-row h-[720px]">
            
            <!-- Left Pane: Conversations List -->
            <div class="w-full md:w-80 border-r border-slate-200/80 flex flex-col bg-slate-50/50 shrink-0">
                
                <!-- Search Threads Input -->
                <div class="p-4 border-b border-slate-200/80 bg-white">
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" 
                               x-model="searchQuery" 
                               placeholder="Search student or LRN..." 
                               class="w-full pl-8 pr-3 py-2 rounded-xl border border-slate-200 text-xs font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 bg-slate-50">
                    </div>
                </div>

                <!-- Threads List -->
                <div class="flex-1 overflow-y-auto divide-y divide-slate-100 custom-scrollbar">
                    <template x-if="filteredThreads.length === 0">
                        <div class="p-6 text-center text-xs text-slate-400">
                            No student conversations found.
                        </div>
                    </template>

                    <template x-for="thread in filteredThreads" :key="thread.id">
                        <div @click="activeThreadId = thread.id; thread.unread = 0"
                             :class="activeThreadId === thread.id ? 'bg-sky-50/80 border-l-4 border-sky-500' : 'hover:bg-slate-100/70 border-l-4 border-transparent'"
                             class="p-4 transition cursor-pointer flex items-start space-x-3">
                            
                            <div class="relative shrink-0">
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-sky-400 to-indigo-600 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                                    <span x-text="thread.name.charAt(0)"></span>
                                </div>
                                <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-500 border-2 border-white"></span>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-xs font-bold text-slate-900 truncate" x-text="thread.name"></h4>
                                    <span class="text-[10px] text-slate-400 font-mono" x-text="thread.lastTime"></span>
                                </div>
                                <p class="text-[11px] text-slate-500 truncate" x-text="thread.role"></p>
                                <p class="text-xs text-slate-600 truncate mt-1 font-medium"
                                   x-text="thread.messages.length ? thread.messages[thread.messages.length - 1].text : 'No messages yet'"></p>
                            </div>

                            <span x-show="thread.unread > 0" class="w-5 h-5 rounded-full bg-sky-500 text-white font-bold text-[10px] flex items-center justify-center shrink-0" x-text="thread.unread"></span>
                        </div>
                    </template>
                </div>

            </div>

            <!-- Right Pane: Active Chat Conversation -->
            <div class="flex-1 flex flex-col bg-white">
                
                <!-- Empty state when no students exist -->
                <template x-if="!activeThread">
                    <div class="h-full flex flex-col items-center justify-center text-center text-slate-400 p-6">
                        <i class="fa-regular fa-comments text-4xl mb-3 text-slate-300"></i>
                        <h3 class="text-sm font-bold text-slate-700">No Conversations Yet</h3>
                        <p class="text-xs mt-1 max-w-xs">Messages from your students will appear here once they reach out.</p>
                    </div>
                </template>

                <!-- Chat Header -->
                <div x-show="activeThread" class="p-4 border-b border-slate-200/80 flex items-center justify-between bg-white">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-sky-400 to-indigo-600 text-white font-bold text-xs flex items-center justify-center">
                            <span x-text="activeThread ? activeThread.name.charAt(0) : ''"></span>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900" x-text="activeThread ? activeThread.name : ''"></h3>
                            <p class="text-xs text-slate-500" x-text="activeThread ? (activeThread.role + ' • LRN: ' + activeThread.lrn) : ''"></p>
                        </div>
                    </div>
                </div>

                <!-- Chat History Messages Scroll Box -->
                <div x-show="activeThread" id="chat-scroll-box" class="flex-1 p-6 overflow-y-auto space-y-4 custom-scrollbar bg-slate-50/30">
                    <template x-if="activeThread && activeThread.messages.length === 0">
                        <div class="h-full flex flex-col items-center justify-center text-center text-slate-400 text-xs">
                            <i class="fa-regular fa-comments text-3xl mb-2 text-slate-300"></i>
                            <p class="font-semibold text-slate-600">No messages yet</p>
                            <p class="mt-1">Send a message below or wait for your student to ask for help.</p>
                        </div>
                    </template>

                    <template x-for="(msg, idx) in (activeThread ? activeThread.messages : [])" :key="idx">
                        <div class="flex" :class="msg.sender === 'teacher' ? 'justify-end' : 'justify-start'">
                            <div class="max-w-md rounded-2xl p-4 text-xs font-medium space-y-1 shadow-2xs"
                                 :class="msg.sender === 'teacher' ? 'bg-[#172554] text-white rounded-br-none' : 'bg-white text-slate-800 border border-slate-200/80 rounded-bl-none'">
                                <p class="leading-relaxed" x-text="msg.text"></p>
                                <p class="text-[10px] text-right"
                                   :class="msg.sender === 'teacher' ? 'text-sky-200' : 'text-slate-400'"
                                   x-text="msg.time">
                                </p>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Chat Input Footer -->
                <div x-show="activeThread" class="p-4 border-t border-slate-200/80 bg-white space-y-2">
                    <!-- Quick Reply Chips -->
                    <div class="flex items-center space-x-1.5 overflow-x-auto pb-1 text-[11px]">
                        <button type="button" 
                                @click="replyText = 'Good day! Yes, that is noted. Thank you for the update.'"
                                class="px-2.5 py-1 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 whitespace-nowrap transition cursor-pointer">
                            👍 Noted, thank you
                        </button>
                        <button type="button" 
                                @click="replyText = 'Please submit your homework directly in our classroom tomorrow morning.'"
                                class="px-2.5 py-1 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 whitespace-nowrap transition cursor-pointer">
                            📝 Submit tomorrow
                        </button>
                        <button type="button" 
                                @click="replyText = 'Great effort on your recent class quiz! Keep up the outstanding work.'"
                                class="px-2.5 py-1 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 whitespace-nowrap transition cursor-pointer">
                            ⭐ Great work!
                        </button>
                    </div>

                    <!-- Input form -->
                    <form @submit.prevent="sendMessage()" class="flex items-center space-x-2">
                        <input type="text" 
                               x-model="replyText" 
                               placeholder="Type your message to student..." 
                               class="flex-1 px-4 py-3 rounded-2xl border border-slate-200 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-sky-500 bg-slate-50 focus:bg-white transition">
                        
                        <button type="submit" 
                                :disabled="!replyText.trim()"
                                :class="replyText.trim() ? 'bg-[#00adef] hover:bg-[#009fdc] cursor-pointer' : 'bg-slate-300 opacity-60 cursor-not-allowed'"
                                class="px-5 py-3 rounded-2xl text-white font-bold text-xs shadow-md transition flex items-center space-x-1.5">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span class="hidden sm:inline">Send</span>
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </div>

</x-teacher-layout>