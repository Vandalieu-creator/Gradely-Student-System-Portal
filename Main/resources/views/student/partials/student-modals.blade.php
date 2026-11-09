<!-- Toast Notification: Message Sent -->
<div x-show="showToast"
     x-transition:enter="transition ease-out duration-300 transform"
     x-transition:enter-start="opacity-0 translate-y-[-20px]"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200 transform"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-[-20px]"
     class="fixed top-6 right-6 z-50 bg-kidGreen text-white font-bold px-6 py-4 rounded-2xl shadow-2xl flex items-center space-x-3 border-2 border-white select-none"
     style="display: none;">
    <span class="text-2xl">📩</span>
    <div>
        <p class="text-sm font-bold">Message Sent!</p>
        <p class="text-xs font-normal opacity-90">Mrs. Miller will reply to you soon.</p>
    </div>
</div>

<!-- ========================================== -->
<!-- 1. ASK TEACHER CHAT MODAL (Mrs. Miller)   -->
<!-- ========================================== -->
<div x-show="showTeacherModal" 
     x-transition.opacity 
     @keydown.window.escape="showTeacherModal = false"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50 select-none" 
     style="display: none;">
    
    <div @click.away="showTeacherModal = false" 
         class="bg-white rounded-[2.5rem] p-6 sm:p-7 max-w-md w-full shadow-2xl border-4 border-kidBlue/30 space-y-4 relative transform transition-all">
        
        <!-- Close Button -->
        <button @click="showTeacherModal = false" class="absolute top-4 right-5 text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">
            ✕
        </button>

        <!-- Teacher Avatar & Greeting Header -->
        <div class="flex items-start space-x-3 pt-2">
            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=120&q=80" 
                 alt="Mrs. Miller" 
                 class="w-14 h-14 rounded-full border-2 border-kidBlue object-cover shadow-sm flex-shrink-0">
            
            <!-- Chat Bubble Popup -->
            <div class="bg-sky-100 border-2 border-sky-200 p-3.5 rounded-2xl rounded-tl-none text-darkText relative shadow-xs">
                <p class="font-bold text-xs text-kidBlue mb-0.5">Mrs. Miller says:</p>
                <p class="text-sm font-semibold leading-snug">Hi! 👋 How can I help you today?</p>
            </div>
        </div>

        <!-- Message Area -->
        <div class="space-y-2 pt-1">
            <label for="teacher-msg" class="block text-xs font-bold text-gray-600">Type your message to Mrs. Miller:</label>
            <textarea id="teacher-msg" 
                      x-model="teacherMessage" 
                      rows="3" 
                      placeholder="e.g. Teacher, I have a question about our Math homework!" 
                      class="w-full p-3.5 rounded-2xl border-2 border-sky-100 bg-slate-50 text-sm text-darkText placeholder-gray-400 focus:outline-none focus:border-kidBlue focus:bg-white transition resize-none font-medium shadow-inner"></textarea>
        </div>

        <!-- Quick Template Chips -->
        <div class="flex flex-wrap gap-1.5 pt-1">
            <button @click="teacherMessage = 'Teacher, I need help with Math Worksheet #4!'" 
                    class="text-[11px] font-bold bg-amber-100 text-amber-800 hover:bg-amber-200 px-3 py-1 rounded-full transition cursor-pointer">
                🔢 Math Help
            </button>
            <button @click="teacherMessage = 'Teacher, I do not understand today\'s assignment.'" 
                    class="text-[11px] font-bold bg-purple-100 text-purple-800 hover:bg-purple-200 px-3 py-1 rounded-full transition cursor-pointer">
                ❓ Assignment Question
            </button>
            <button @click="teacherMessage = 'Teacher, when is the deadline for our MAPEH animal drawing?'" 
                    class="text-[11px] font-bold bg-orange-100 text-orange-800 hover:bg-orange-200 px-3 py-1 rounded-full transition cursor-pointer">
                🎨 Art Project
            </button>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-2 pt-3 border-t border-gray-100">
            <button @click="showTeacherModal = false" 
                    class="px-4 py-2.5 rounded-xl font-bold text-xs text-gray-500 hover:bg-gray-100 transition cursor-pointer">
                Cancel
            </button>
            <button @click="sendTeacherMessage()" 
                    :disabled="teacherMessage.trim() === ''"
                    :class="teacherMessage.trim() === '' ? 'opacity-50 cursor-not-allowed' : 'hover:bg-sky-500 cursor-pointer'"
                    class="bg-kidBlue text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md transition flex items-center space-x-1.5">
                <i class="fa-solid fa-paper-plane"></i>
                <span>Send Message</span>
            </button>
        </div>

    </div>
</div>

<!-- ========================================== -->
<!-- 2. HOMEWORK INTERACTIVE MODAL              -->
<!-- ========================================== -->
<div x-show="showModal" 
     x-transition.opacity 
     @keydown.window.escape="showModal = false"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4 z-50 select-none" 
     style="display: none;">
    
    <div @click.away="showModal = false" 
         class="bg-white rounded-3xl p-6 sm:p-8 max-w-sm w-full text-center shadow-2xl border-4 border-kidOrange/20 space-y-5 transform transition-all">
        
        <div class="w-16 h-16 bg-kidOrange/20 text-kidOrange rounded-full flex items-center justify-center text-3xl mx-auto">
            🎨
        </div>

        <div>
            <h3 class="text-xl font-bold text-darkText">Draw Your Favorite Animal</h3>
            <p class="text-sm font-medium text-gray-600 mt-2">Did you finish the homework?</p>
        </div>

        <div class="grid grid-cols-2 gap-3 pt-2">
            <button @click="
                        taskDone = true; 
                        stars += 20; 
                        showModal = false;
                    " 
                    class="bg-kidGreen hover:bg-green-500 text-white font-bold py-3 px-4 rounded-2xl shadow-md transition flex items-center justify-center space-x-1 cursor-pointer">
                <i class="fa-solid fa-circle-check"></i>
                <span>Yes!</span>
            </button>

            <button @click="showModal = false" 
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold py-3 px-4 rounded-2xl shadow-xs transition flex items-center justify-center space-x-1 cursor-pointer">
                <i class="fa-solid fa-circle-xmark"></i>
                <span>No</span>
            </button>
        </div>

    </div>
</div>

<!-- ========================================== -->
<!-- 3. CLASS SCHEDULE MODAL                    -->
<!-- ========================================== -->
<div x-show="showScheduleModal" 
     x-transition.opacity 
     @keydown.window.escape="showScheduleModal = false"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50 select-none" 
     style="display: none;">
    
    <div @click.away="showScheduleModal = false" 
         class="bg-white rounded-[2.5rem] p-6 sm:p-8 max-w-lg w-full shadow-2xl border-4 border-kidBlue/30 space-y-4 relative transform transition-all">
        
        <!-- Close Button -->
        <button @click="showScheduleModal = false" class="absolute top-5 right-6 text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">
            ✕
        </button>

        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-2xl font-bold">
                📅
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800">Class Schedule</h3>
                <p class="text-xs text-sky-600 font-bold uppercase tracking-wider">Grade 4 - Diamond &bull; Mon - Fri</p>
            </div>
        </div>

        <div class="space-y-2 max-h-80 overflow-y-auto pr-1 text-xs">
            <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                <span class="font-bold text-slate-500">7:30 AM &ndash; 8:00 AM</span>
                <span class="font-bold text-slate-800">Flag Ceremony & Homeroom</span>
                <span class="text-[10px] bg-slate-200 text-slate-700 px-2 py-0.5 rounded-full font-bold">General</span>
            </div>
            <div class="flex items-center justify-between p-3 rounded-2xl bg-amber-50/70 border border-amber-100">
                <span class="font-bold text-amber-700">8:00 AM &ndash; 9:00 AM</span>
                <span class="font-bold text-slate-800">Mathematics</span>
                <span class="text-[10px] bg-amber-200 text-amber-800 px-2 py-0.5 rounded-full font-bold">Mrs. Miller</span>
            </div>
            <div class="flex items-center justify-between p-3 rounded-2xl bg-emerald-50/70 border border-emerald-100">
                <span class="font-bold text-emerald-700">9:00 AM &ndash; 10:00 AM</span>
                <span class="font-bold text-slate-800">Science</span>
                <span class="text-[10px] bg-emerald-200 text-emerald-800 px-2 py-0.5 rounded-full font-bold">Mr. Garcia</span>
            </div>
            <div class="flex items-center justify-between p-2.5 rounded-2xl bg-pink-100/60 border border-pink-200 text-pink-700 font-bold text-center justify-center">
                <span>🍎 10:00 AM &ndash; 10:20 AM: Morning Recess & Snack</span>
            </div>
            <div class="flex items-center justify-between p-3 rounded-2xl bg-sky-50/70 border border-sky-100">
                <span class="font-bold text-sky-700">10:20 AM &ndash; 11:20 AM</span>
                <span class="font-bold text-slate-800">English & Reading</span>
                <span class="text-[10px] bg-sky-200 text-sky-800 px-2 py-0.5 rounded-full font-bold">Ms. Lopez</span>
            </div>
            <div class="flex items-center justify-between p-3 rounded-2xl bg-purple-50/70 border border-purple-100">
                <span class="font-bold text-purple-700">11:20 AM &ndash; 12:00 PM</span>
                <span class="font-bold text-slate-800">Filipino</span>
                <span class="text-[10px] bg-purple-200 text-purple-800 px-2 py-0.5 rounded-full font-bold">Mrs. Santos</span>
            </div>
            <div class="flex items-center justify-between p-2.5 rounded-2xl bg-yellow-100/60 border border-yellow-200 text-amber-800 font-bold text-center justify-center">
                <span>🍱 12:00 PM &ndash; 1:00 PM: Lunch Break</span>
            </div>
            <div class="flex items-center justify-between p-3 rounded-2xl bg-teal-50/70 border border-teal-100">
                <span class="font-bold text-teal-700">1:00 PM &ndash; 2:00 PM</span>
                <span class="font-bold text-slate-800">MAPEH / Art Class</span>
                <span class="text-[10px] bg-teal-200 text-teal-800 px-2 py-0.5 rounded-full font-bold">Mr. Cruz</span>
            </div>
            <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                <span class="font-bold text-slate-500">3:00 PM</span>
                <span class="font-bold text-slate-800">Dismissal & Study Time</span>
                <span class="text-[10px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-bold">Bell Ring</span>
            </div>
        </div>

        <div class="pt-3 border-t border-slate-100 flex justify-end">
            <button @click="showScheduleModal = false" class="bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-xs transition cursor-pointer">
                Close Schedule
            </button>
        </div>

    </div>
</div>

<!-- ========================================== -->
<!-- 4. STUDENT GUIDE & FAQS MODAL             -->
<!-- ========================================== -->
<div x-show="showHelpModal" 
     x-transition.opacity 
     @keydown.window.escape="showHelpModal = false"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50 select-none" 
     style="display: none;">
    
    <div @click.away="showHelpModal = false" 
         class="bg-white rounded-[2.5rem] p-6 sm:p-8 max-w-lg w-full shadow-2xl border-4 border-kidPurple/30 space-y-4 relative transform transition-all">
        
        <button @click="showHelpModal = false" class="absolute top-5 right-6 text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">
            ✕
        </button>

        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-2xl font-bold">
                🌟
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800">Student Guide & FAQs</h3>
                <p class="text-xs text-purple-600 font-bold uppercase tracking-wider">Everything you need to know</p>
            </div>
        </div>

        <div class="space-y-3 max-h-80 overflow-y-auto pr-1 text-xs">
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="font-bold text-slate-800 mb-1">⭐ How do I earn stars?</p>
                <p class="text-slate-600">You get stars whenever you finish your homework checklist, answer activities, or show exemplary kindness in class!</p>
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="font-bold text-slate-800 mb-1">📊 Where can I see my report card?</p>
                <p class="text-slate-600">Click on "Grading" on the sidebar or click "View Report Card" on your dashboard to see your 1st, 2nd, 3rd, and 4th quarter grades.</p>
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="font-bold text-slate-800 mb-1">👩‍🏫 How do I ask my teacher for help?</p>
                <p class="text-slate-600">Click the "Ask Help" button on Mrs. Miller's card or click "Support &rarr; Ask Mrs. Miller" in the sidebar anytime you have a question!</p>
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                <p class="font-bold text-slate-800 mb-1">🔍 What is Quick Find (⌘K)?</p>
                <p class="text-slate-600">Quick Find lets you search any subject, homework task, teacher, or grade report with instant live search.</p>
            </div>
        </div>

        <div class="pt-3 border-t border-slate-100 flex justify-end">
            <button @click="showHelpModal = false" class="bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-xs transition cursor-pointer">
                Got it, thank you!
            </button>
        </div>

    </div>
</div>
