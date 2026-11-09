<x-teacher-layout active="schedule" title="Class Schedule">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 max-w-7xl mx-auto">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 shadow-xs">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                        Class Schedule & Timetable
                    </h1>
                    <p class="text-xs font-semibold text-slate-500">
                        Weekly teaching periods, subject slots, and advisory schedule
                    </p>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <button type="button" 
                        onclick="window.print()"
                        class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition shadow-2xs cursor-pointer flex items-center space-x-1.5">
                    <i class="fa-solid fa-print text-slate-500 text-xs"></i>
                    <span>Print Schedule</span>
                </button>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6"
         x-data="{
             activeDay: 'Monday',
             days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
             timetable: {
                 'Monday': [
                     { time: '7:30 AM - 8:00 AM', subject: 'Flag Ceremony & Homeroom Advisory', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'sky' },
                     { time: '8:00 AM - 9:00 AM', subject: 'Mathematics (Fractions & Decimals)', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'indigo' },
                     { time: '9:00 AM - 9:30 AM', subject: 'Morning Recess & Nutrition Break', room: 'School Canteen', class: 'All Sections', color: 'slate' },
                     { time: '9:30 AM - 10:30 AM', subject: 'Science & Health (Ecosystems)', room: 'Room 102', class: 'Grade 5 - Sapphire', color: 'emerald' },
                     { time: '10:30 AM - 11:30 AM', subject: 'English (Reading & Phonics)', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'blue' },
                     { time: '11:30 AM - 1:00 PM', subject: 'Lunch Break & Teacher Office Hours', room: 'Faculty Room', class: 'Advisory Office', color: 'slate' },
                     { time: '1:00 PM - 2:00 PM', subject: 'Filipino (Wika at Panitikan)', room: 'Room 301', class: 'Grade 6 - Emerald', color: 'amber' },
                     { time: '2:00 PM - 3:00 PM', subject: 'MAPEH (Music, Arts, PE, Health)', room: 'Gymnasium / Room 204', class: 'Grade 4 - Diamond', color: 'purple' },
                     { time: '3:00 PM - 4:00 PM', subject: 'Remedial Reading & Student Consultation', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'teal' }
                 ],
                 'Tuesday': [
                     { time: '7:30 AM - 8:00 AM', subject: 'Homeroom Guidance & Value Formation', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'sky' },
                     { time: '8:00 AM - 9:00 AM', subject: 'Mathematics (Problem Solving & Word Problems)', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'indigo' },
                     { time: '9:00 AM - 9:30 AM', subject: 'Morning Recess', room: 'School Grounds', class: 'All Sections', color: 'slate' },
                     { time: '9:30 AM - 10:30 AM', subject: 'Science Laboratory (Hands-on Experiments)', room: 'Sci-Lab B', class: 'Grade 5 - Sapphire', color: 'emerald' },
                     { time: '10:30 AM - 11:30 AM', subject: 'English Grammar & Writing Composition', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'blue' },
                     { time: '11:30 AM - 1:00 PM', subject: 'Lunch Break', room: 'Faculty Lounge', class: 'Faculty', color: 'slate' },
                     { time: '1:00 PM - 2:00 PM', subject: 'Araling Panlipunan (Kasaysayan ng Pilipinas)', room: 'Room 301', class: 'Grade 6 - Emerald', color: 'amber' },
                     { time: '2:00 PM - 3:00 PM', subject: 'Edukasyon sa Pagpapakatao (EsP)', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'rose' }
                 ],
                 'Wednesday': [
                     { time: '7:30 AM - 8:00 AM', subject: 'Morning Roll Call & Journaling', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'sky' },
                     { time: '8:00 AM - 9:00 AM', subject: 'Mathematics Diagnostic Exercises', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'indigo' },
                     { time: '9:00 AM - 9:30 AM', subject: 'Recess Break', room: 'Canteen', class: 'All Sections', color: 'slate' },
                     { time: '9:30 AM - 10:30 AM', subject: 'Science & Environment Lecture', room: 'Room 102', class: 'Grade 5 - Sapphire', color: 'emerald' },
                     { time: '10:30 AM - 11:30 AM', subject: 'English Spelling & Vocabulary Quiz', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'blue' },
                     { time: '11:30 AM - 1:00 PM', subject: 'Lunch Break & Lesson Planning', room: 'Faculty Room', class: 'Faculty', color: 'slate' },
                     { time: '1:00 PM - 2:30 PM', subject: 'MAPEH Practical Demonstration (PE & Dance)', room: 'School Covered Court', class: 'Grade 4 - Diamond', color: 'purple' }
                 ],
                 'Thursday': [
                     { time: '7:30 AM - 8:00 AM', subject: 'Homeroom Daily Agenda & Attendance', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'sky' },
                     { time: '8:00 AM - 9:00 AM', subject: 'Mathematics Group Activity', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'indigo' },
                     { time: '9:00 AM - 9:30 AM', subject: 'Morning Recess', room: 'School Grounds', class: 'All Sections', color: 'slate' },
                     { time: '9:30 AM - 10:30 AM', subject: 'Science Ecology Studies', room: 'Room 102', class: 'Grade 5 - Sapphire', color: 'emerald' },
                     { time: '10:30 AM - 11:30 AM', subject: 'English Storytelling & Public Speaking', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'blue' },
                     { time: '11:30 AM - 1:00 PM', subject: 'Lunch Break', room: 'Faculty Room', class: 'Faculty', color: 'slate' },
                     { time: '1:00 PM - 2:00 PM', subject: 'Filipino Pagbasa at Pagsulat', room: 'Room 301', class: 'Grade 6 - Emerald', color: 'amber' },
                     { time: '2:00 PM - 3:30 PM', subject: 'Art Workshop & Poster Making', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'purple' }
                 ],
                 'Friday': [
                     { time: '7:30 AM - 8:00 AM', subject: 'Weekly Homeroom Evaluation & Clean-up', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'sky' },
                     { time: '8:00 AM - 9:30 AM', subject: 'Weekly Assessment & Mastery Quizzes', room: 'Room 204', class: 'Grade 4 - Diamond', color: 'indigo' },
                     { time: '9:30 AM - 10:00 AM', subject: 'Recess Break', room: 'Canteen', class: 'All Sections', color: 'slate' },
                     { time: '10:00 AM - 11:30 AM', subject: 'Catch-Up Fridays Reading Program (DEAR)', room: 'School Library / Room 204', class: 'Grade 4 & 5', color: 'teal' },
                     { time: '11:30 AM - 1:00 PM', subject: 'Lunch & Faculty Meeting', room: 'Principal Conference Room', class: 'Faculty', color: 'slate' },
                     { time: '1:00 PM - 3:00 PM', subject: 'Extracurricular Clubs & Sports Training', room: 'School Grounds', class: 'All Levels', color: 'amber' }
                 ]
             }
         }">

        <!-- Day Selector Tabs -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-2 shadow-xs flex items-center justify-between">
            <div class="flex items-center space-x-1.5 overflow-x-auto p-1 custom-scrollbar w-full sm:w-auto">
                <template x-for="day in days" :key="day">
                    <button type="button" 
                            @click="activeDay = day"
                            :class="activeDay === day ? 'bg-[#172554] text-white shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-semibold'"
                            class="px-5 py-2.5 rounded-2xl text-xs transition cursor-pointer whitespace-nowrap">
                        <span x-text="day"></span>
                    </button>
                </template>
            </div>

            <div class="hidden sm:flex items-center space-x-2 pr-3 text-xs text-slate-500 font-semibold">
                <i class="fa-solid fa-bell text-amber-500"></i>
                <span>Class Hours: 7:30 AM — 4:00 PM</span>
            </div>
        </div>

        <!-- Schedule Cards List for Selected Day -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-900" x-text="activeDay + ' Timetable'"></h3>
                    <p class="text-xs text-slate-500">All subject periods and scheduled class rooms</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold" x-text="timetable[activeDay].length + ' Scheduled Periods'"></span>
            </div>

            <div class="space-y-3">
                <template x-for="(slot, i) in timetable[activeDay]" :key="i">
                    <div class="p-4 rounded-2xl border transition flex flex-col sm:flex-row sm:items-center justify-between gap-3 group"
                         :class="{
                             'bg-sky-50/50 border-sky-200 hover:bg-sky-50': slot.color === 'sky',
                             'bg-indigo-50/50 border-indigo-200 hover:bg-indigo-50': slot.color === 'indigo',
                             'bg-emerald-50/50 border-emerald-200 hover:bg-emerald-50': slot.color === 'emerald',
                             'bg-blue-50/50 border-blue-200 hover:bg-blue-50': slot.color === 'blue',
                             'bg-amber-50/50 border-amber-200 hover:bg-amber-50': slot.color === 'amber',
                             'bg-purple-50/50 border-purple-200 hover:bg-purple-50': slot.color === 'purple',
                             'bg-teal-50/50 border-teal-200 hover:bg-teal-50': slot.color === 'teal',
                             'bg-rose-50/50 border-rose-200 hover:bg-rose-50': slot.color === 'rose',
                             'bg-slate-50 border-slate-200 hover:bg-slate-100': slot.color === 'slate'
                         }">
                        
                        <div class="flex items-start sm:items-center space-x-3.5">
                            <!-- Time Badge -->
                            <div class="px-3 py-2 rounded-xl bg-white border border-slate-200 shadow-2xs text-xs font-extrabold text-slate-800 shrink-0 font-mono">
                                <span x-text="slot.time"></span>
                            </div>

                            <div>
                                <h4 class="text-sm font-bold text-slate-900" x-text="slot.subject"></h4>
                                <div class="flex items-center space-x-2 mt-1 text-xs text-slate-500">
                                    <span class="flex items-center space-x-1">
                                        <i class="fa-solid fa-location-dot text-[10px] text-slate-400"></i>
                                        <span x-text="slot.room"></span>
                                    </span>
                                    <span>•</span>
                                    <span class="font-semibold text-slate-700" x-text="slot.class"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Status badge / action -->
                        <div class="flex items-center space-x-2">
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold"
                                  :class="slot.color === 'slate' ? 'bg-slate-200 text-slate-700' : 'bg-white text-slate-800 shadow-2xs border border-slate-200'"
                                  x-text="slot.color === 'slate' ? 'Break / Planning' : 'Instructional Period'">
                            </span>
                        </div>
                    </div>
                </template>
            </div>
        </div>

    </div>

</x-teacher-layout>

