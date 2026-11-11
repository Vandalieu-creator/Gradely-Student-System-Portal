<x-teacher-layout active="students" title="My Students Directory">

<div
    x-data="{
        activeModalStudent: null,
        showAddStudentModal: false,
        showStudentDetailModal: false,
        studentRecipients: @js($students->map(fn ($student) => [
            'lrn' => $student->lrn,
            'name' => trim($student->first_name . ' ' . ($student->middle_name ?? '') . ' ' . $student->last_name),
            'class' => $student->schoolClass->class_name ?? 'No class assigned',
        ])->values()),

        openStudent(st) {
            this.activeModalStudent = st;
            this.showStudentDetailModal = true;
        }
    }"
>

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 max-w-7xl mx-auto">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center border border-sky-100 shadow-xs">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                        My Students Directory
                    </h1>
                    <p class="text-xs font-semibold text-slate-500">
                        Complete student registry across all your classes
                    </p>
                </div>
            </div>

            
            <!-- Header Quick Actions -->
            <div class="flex items-center space-x-2 flex-wrap">
                <a href="{{ route('teacher.class-settings') }}"
                class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition shadow-2xs">
                    Manage Classes
                </a>

                

                <button type="button"
                        @click="showMessageModal = true"
                        class="px-4 py-2.5 rounded-xl bg-[#00adef] hover:bg-[#009fdc] text-white text-xs font-bold shadow-xs transition cursor-pointer">
                    <i class="fa-solid fa-paper-plane mr-1 text-[11px]"></i> Message Student
                </button>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6">

        <!-- Filters & Search Toolbar -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs space-y-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                
                <!-- Search Form -->
                <form method="GET" action="{{ route('teacher.my-students') }}" class="flex-1 max-w-md relative">
                    @if(request('class'))
                        <input type="hidden" name="class" value="{{ request('class') }}">
                    @endif
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}" 
                           placeholder="Search by student name or LRN..." 
                           class="w-full pl-9 pr-4 py-2.5 rounded-2xl border border-slate-200 text-xs font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 bg-slate-50 focus:bg-white transition">
                </form>

                <!-- Class Filter Pills -->
                <div class="flex flex-wrap items-center gap-1.5">
                    <a href="{{ route('teacher.my-students') }}" 
                       class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ !$classFilter ? 'bg-[#172554] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        All Classes ({{ $classes->sum('students_count') }})
                    </a>
                    @foreach($classes as $c)
                        <a href="{{ route('teacher.my-students') }}?class={{ urlencode($c->class_name) }}" 
                           class="px-3 py-1.5 rounded-xl text-xs font-bold transition {{ $classFilter === $c->class_name ? 'bg-[#00adef] text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            {{ $c->class_name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Metrics bar -->
            <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between text-xs text-slate-500 gap-2">
                <div class="flex items-center space-x-4">
                    <span>Showing <strong class="text-slate-800">{{ $students->count() }}</strong> students</span>
                    <span>•</span>
                    <span>Males: <strong class="text-slate-800">{{ $students->where('gender', 'Male')->count() }}</strong></span>
                    <span>•</span>
                    <span>Females: <strong class="text-slate-800">{{ $students->where('gender', 'Female')->count() }}</strong></span>
                </div>
                @if($search || $classFilter)
                    <a href="{{ route('teacher.my-students') }}" class="text-sky-600 font-bold hover:underline">
                        Reset Filters ✕
                    </a>
                @endif
            </div>
        </div>

        <!-- Students Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($students as $student)
                <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs hover:shadow-md transition space-y-4 flex flex-col justify-between group">
                    <div>
                        <!-- Header with Avatar and Section Tag -->
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-sky-400 to-indigo-500 text-white font-extrabold text-base flex items-center justify-center shadow-sm">
                                    {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 group-hover:text-sky-600 transition text-sm">
                                        {{ $student->last_name }}, {{ $student->first_name }}
                                    </h3>
                                    <p class="text-[11px] font-mono text-slate-400">LRN: {{ $student->lrn }}</p>
                                </div>
                            </div>

                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $student->gender === 'Female' ? 'bg-pink-50 text-pink-700 border border-pink-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                {{ $student->gender ?? 'Student' }}
                            </span>
                        </div>

                        <!-- Info details -->
                        <div class="mt-4 p-3 rounded-2xl bg-slate-50 space-y-1.5 text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-400 font-medium">Class Section:</span>
                                <span class="font-bold text-slate-800">{{ $student->schoolClass->class_name ?? 'No class assigned' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400 font-medium">Birth Date:</span>
                                <span class="font-semibold text-slate-700">{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('M d, Y') : 'Not provided' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400 font-medium">Academic Status:</span>
                                <span class="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full text-[10px]">Active Enrolled</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <button type="button" 
                                @click="openStudent(@js([
                                    'name' => trim($student->first_name . ' ' . ($student->middle_name ?? '') . ' ' . $student->last_name),
                                    'lrn' => $student->lrn,
                                    'class' => $student->schoolClass->class_name ?? 'No class assigned',
                                    'gender' => $student->gender ?? 'Not provided',
                                    'address' => $student->address ?? 'Not provided',
                                    'dob' => $student->date_of_birth
                                        ? \Carbon\Carbon::parse($student->date_of_birth)->format('F d, Y')
                                        : 'Not provided'
                                ]))"

                                class="text-xs font-bold text-slate-600 hover:text-sky-600 transition flex items-center space-x-1 cursor-pointer">
                            <i class="fa-solid fa-address-card text-xs"></i>
                            <span>View Profile</span>
                        </button>

                        
                        <button
                            type="button"
                            @click="$dispatch('open-message', {
                                lrn: @js($student->lrn),
                                students: studentRecipients
                            })"
                            class="px-3.5 py-1.5 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-700 text-xs font-bold transition cursor-pointer"
                        >
                            <i class="fa-solid fa-comment-dots text-xs mr-1"></i> Message
                        </button>

                    </div>

                </div>
            @empty
                <div class="col-span-full rounded-3xl border border-slate-200 bg-white px-6 py-16 text-center shadow-xs">
                    <p class="text-slate-400 text-sm">No students found matching your criteria.</p>
                </div>
            @endforelse
        </div>

        

        <!-- Student Profile Modal -->
        <template x-teleport="body">

        <div x-show="showStudentDetailModal" 
             x-transition.opacity 
             @keydown.window.escape="showStudentDetailModal = false"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 z-50 select-none" 
             style="display: none;">
            
            <div @click.away="showStudentDetailModal = false" 
                 class="bg-white rounded-3xl p-6 sm:p-7 max-w-md w-full shadow-2xl border-4 border-slate-100 space-y-4 relative text-slate-800 transform transition-all">
                
                <button @click="showStudentDetailModal = false" class="absolute top-4 right-5 text-slate-400 hover:text-slate-700 text-xl font-bold cursor-pointer">
                    ✕
                </button>

                <div class="text-center pt-2">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-sky-400 to-indigo-600 text-white font-extrabold text-2xl flex items-center justify-center mx-auto shadow-md">
                        <span x-text="activeModalStudent ? activeModalStudent.name.charAt(0) : 'S'"></span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mt-2" x-text="activeModalStudent ? activeModalStudent.name : ''"></h3>
                    <p class="text-xs font-mono text-slate-500" x-text="activeModalStudent ? 'LRN: ' + activeModalStudent.lrn : ''"></p>
                </div>

                <div class="space-y-2 text-xs bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <div class="flex justify-between py-1 border-b border-slate-200/60">
                        <span class="text-slate-500">Section:</span>
                        <span class="font-bold text-slate-900" x-text="activeModalStudent ? activeModalStudent.class : ''"></span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-200/60">
                        <span class="text-slate-500">Gender:</span>
                        <span class="font-semibold text-slate-800" x-text="activeModalStudent ? activeModalStudent.gender : ''"></span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-200/60">
                        <span class="text-slate-500">Date of Birth:</span>
                        <span class="font-semibold text-slate-800" x-text="activeModalStudent ? activeModalStudent.dob : ''"></span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-slate-500">Average Attendance:</span>
                        <span class="font-semibold text-slate-500">No attendance data</span>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-2 pt-2 border-t border-slate-100">
                    <button @click="showStudentDetailModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 transition cursor-pointer">
                        Close
                    </button>
                    <button @click="showStudentDetailModal = false; showMessageModal = true" class="px-4 py-2 rounded-xl bg-[#00adef] text-white text-xs font-bold hover:bg-[#009fdc] transition cursor-pointer">
                        Send Message
                    </button>
                </div>
            </div>
        </div>
        </template>

    </div>
</div>

</x-teacher-layout>

