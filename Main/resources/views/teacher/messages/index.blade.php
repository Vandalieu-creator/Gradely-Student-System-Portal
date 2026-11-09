<x-teacher-layout active="messages" title="Teacher Messages Inbox">

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

            <!-- Compose Button -->
            <button type="button" 
                    @click="showMessageModal = true"
                    class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-[#00adef] hover:bg-[#009fdc] text-white text-xs font-bold shadow-md shadow-sky-500/20 transition cursor-pointer">
                <i class="fa-solid fa-pen-to-square text-xs"></i>
                <span>Compose Message</span>
            </button>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8"
         x-data="{
             searchQuery: '',
             activeThreadId: 1,
             replyText: '',
             threads: [
                 {
                     id: 1,
                     name: 'Jm Marvie Brizuela',
                     role: 'Student • Grade 4 - Diamond',
                     lrn: '109876543210',
                     unread: 1,
                     lastTime: '10:42 AM',
                     messages: [
                         { sender: 'student', text: 'Good morning teacher! 👋 I have a question about the animal drawing homework. Can we use watercolors instead of crayons?', time: '10:35 AM' },
                         { sender: 'teacher', text: 'Good morning Jm! Yes, watercolors or crayons are both completely fine. Just make sure the drawing paper does not get too wet.', time: '10:38 AM' },
                         { sender: 'student', text: 'Thank you teacher! I will finish it today and submit tomorrow morning. 😊', time: '10:42 AM' }
                     ]
                 },
                 {
                     id: 2,
                     name: 'Mrs. Maria Licatan (Parent)',
                     role: 'Parent of Eduard Licatan',
                     lrn: '109876543211',
                     unread: 1,
                     lastTime: '8:15 AM',
                     messages: [
                         { sender: 'student', text: 'Good morning Mrs. Miller. Eduard has a mild fever today so I advised him to rest. May we request excuse for his attendance today?', time: '8:10 AM' },
                         { sender: 'teacher', text: 'Good morning Mrs. Licatan. Noted on Eduard\'s medical absence. I have marked him excused. Please let him rest and take care!', time: '8:15 AM' }
                     ]
                 },
                 {
                     id: 3,
                     name: 'Clint John Orbillo',
                     role: 'Student • Grade 4 - Diamond',
                     lrn: '109876543212',
                     unread: 1,
                     lastTime: 'Yesterday',
                     messages: [
                         { sender: 'student', text: 'Teacher, what page was our Math assignment in the textbook again?', time: 'Yesterday 4:10 PM' },
                         { sender: 'teacher', text: 'Hello Clint! It is on pages 64-66, exercises A and B.', time: 'Yesterday 4:20 PM' }
                     ]
                 },
                 {
                     id: 4,
                     name: 'Charles Cabrera',
                     role: 'Student • Grade 4 - Diamond',
                     lrn: '109876543213',
                     unread: 0,
                     lastTime: 'Nov 06',
                     messages: [
                         { sender: 'student', text: 'Teacher, thank you for checking my Science worksheet!', time: 'Nov 06' },
                         { sender: 'teacher', text: 'You did a great job on ecosystems, Charles! Keep it up.', time: 'Nov 06' }
                     ]
                 }
             ],
             get activeThread() {
                 return this.threads.find(t => t.id === this.activeThreadId) || this.threads[0];
             },
             sendMessage() {
                 if (!this.replyText.trim()) return;
                 this.activeThread.messages.push({
                     sender: 'teacher',
                     text: this.replyText,
                     time: 'Just now'
                 });
                 this.replyText = '';
                 notify('Message sent to ' + this.activeThread.name + '.', 'Sent');
                 this.$nextTick(() => {
                     const box = document.getElementById('chat-scroll-box');
                     if (box) box.scrollTop = box.scrollHeight;
                 });
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
                               placeholder="Search conversations..." 
                               class="w-full pl-8 pr-3 py-2 rounded-xl border border-slate-200 text-xs font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 bg-slate-50">
                    </div>
                </div>

                <!-- Threads List -->
                <div class="flex-1 overflow-y-auto divide-y divide-slate-100 custom-scrollbar">
                    <template x-for="thread in threads" :key="thread.id">
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
                                <p class="text-xs text-slate-600 truncate mt-1 font-medium" x-text="thread.messages[thread.messages.length - 1].text"></p>
                            </div>

                            <span x-show="thread.unread > 0" class="w-5 h-5 rounded-full bg-sky-500 text-white font-bold text-[10px] flex items-center justify-center shrink-0" x-text="thread.unread"></span>
                        </div>
                    </template>
                </div>

            </div>

            <!-- Right Pane: Active Chat Conversation -->
            <div class="flex-1 flex flex-col bg-white">
                
                <!-- Chat Header -->
                <div class="p-4 border-b border-slate-200/80 flex items-center justify-between bg-white">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-sky-400 to-indigo-600 text-white font-bold text-xs flex items-center justify-center">
                            <span x-text="activeThread.name.charAt(0)"></span>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900" x-text="activeThread.name"></h3>
                            <p class="text-xs text-slate-500" x-text="activeThread.role + ' • LRN: ' + activeThread.lrn"></p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button type="button" 
                                @click="notify('Opening full academic profile for ' + activeThread.name, 'Profile Link')"
                                class="p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition cursor-pointer text-xs"
                                title="View Student Records">
                            <i class="fa-solid fa-address-card"></i>
                        </button>
                    </div>
                </div>

                <!-- Chat History Messages Scroll Box -->
                <div id="chat-scroll-box" class="flex-1 p-6 overflow-y-auto space-y-4 custom-scrollbar bg-slate-50/30">
                    <template x-for="(msg, idx) in activeThread.messages" :key="idx">
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
                <div class="p-4 border-t border-slate-200/80 bg-white space-y-2">
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
                               placeholder="Type your message to student or parent..." 
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

