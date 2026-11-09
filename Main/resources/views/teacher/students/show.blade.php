<x-teacher-layout active="students" title="Student Details — {{ $student->first_name }} {{ $student->last_name }}">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex items-center space-x-3 max-w-7xl mx-auto">
            <a href="{{ route('teacher.classes.students.index', $class) }}" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                    Student Details
                </h1>
                <p class="text-xs font-semibold text-slate-500">
                    {{ $class->class_name }} • LRN: {{ $student->lrn }}
                </p>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6">

        <div class="flex justify-between items-center">
            <a href="{{ route('teacher.classes.students.index', $class) }}"
               class="text-xs font-bold text-slate-500 hover:text-sky-600 transition flex items-center space-x-1.5">
                <span>← Back to Student List</span>
            </a>

            <div class="flex items-center space-x-2" x-data="{ showArchiveModal: false }">
                <a href="{{ route('teacher.classes.students.edit', [$class, $student]) }}"
                   class="px-4 py-2 rounded-xl bg-[#172554] hover:bg-[#1e3a8a] text-white text-xs font-bold shadow-xs transition">
                    Edit Student
                </a>

                <button type="button"
                        @click="showArchiveModal = true"
                        class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-xs transition cursor-pointer">
                    Archive Student
                </button>

                <!-- Confirmation Modal -->
                <div x-show="showArchiveModal"
                     x-cloak
                     x-transition.opacity
                     @keydown.escape.window="showArchiveModal = false"
                     class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4"
                     style="display: none;">

                    <div @click.outside="showArchiveModal = false"
                         class="w-full max-w-md rounded-3xl bg-white p-7 shadow-2xl border-4 border-slate-100 space-y-4">
                        
                        <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto text-xl font-bold">
                            ⚠️
                        </div>

                        <div class="text-center">
                            <h3 class="text-lg font-bold text-slate-900">Archive Student?</h3>
                            <p class="mt-2 text-xs text-slate-600">
                                Are you sure you want to archive <strong>{{ $student->first_name }} {{ $student->last_name }}</strong>?
                            </p>
                            <p class="mt-1 text-[11px] text-emerald-700 font-semibold">
                                Their grades and attendance records will be preserved.
                            </p>
                        </div>

                        <div class="flex items-center justify-center space-x-2 pt-2">
                            <button type="button"
                                    @click="showArchiveModal = false"
                                    class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                                Cancel
                            </button>
                            <form action="{{ route('teacher.classes.students.destroy', [$class, $student]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 rounded-xl bg-rose-600 text-white text-xs font-bold hover:bg-rose-700 transition cursor-pointer">
                                    Yes, Archive Student
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3.5 text-xs font-bold text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xs">
            <div class="bg-gradient-to-r from-[#101a2a] to-[#1e3a8a] text-white p-8">
                <span class="text-xs font-extrabold uppercase tracking-widest text-sky-400">
                    Official Student Record
                </span>
                <h2 class="mt-2 text-2xl sm:text-3xl font-extrabold text-white">
                    {{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}
                </h2>
                <p class="mt-1 text-xs text-slate-300 font-mono">
                    Learner Reference Number: {{ $student->lrn }}
                </p>
            </div>

            <div class="p-8 space-y-6">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">
                        Personal Information
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="p-3 bg-slate-50 rounded-2xl">
                            <p class="text-slate-400 font-semibold">First Name</p>
                            <p class="mt-1 font-bold text-slate-900">{{ $student->first_name }}</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl">
                            <p class="text-slate-400 font-semibold">Middle Name</p>
                            <p class="mt-1 font-bold text-slate-900">{{ $student->middle_name ?? 'Not provided' }}</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl">
                            <p class="text-slate-400 font-semibold">Last Name</p>
                            <p class="mt-1 font-bold text-slate-900">{{ $student->last_name }}</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl">
                            <p class="text-slate-400 font-semibold">LRN</p>
                            <p class="mt-1 font-mono font-bold text-slate-900">{{ $student->lrn }}</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl">
                            <p class="text-slate-400 font-semibold">Date of Birth</p>
                            <p class="mt-1 font-bold text-slate-900">{{ $student->date_of_birth ? date('F d, Y', strtotime($student->date_of_birth)) : 'Not provided' }}</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl">
                            <p class="text-slate-400 font-semibold">Gender</p>
                            <p class="mt-1 font-bold text-slate-900">{{ $student->gender ?? 'Not specified' }}</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl sm:col-span-2">
                            <p class="text-slate-400 font-semibold">Home Address</p>
                            <p class="mt-1 font-bold text-slate-900">{{ $student->address ?? 'Ginatilan, Cebu' }}</p>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">
                        Enrolled Classroom Details
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="p-3 bg-slate-50 rounded-2xl">
                            <p class="text-slate-400 font-semibold">Class Name</p>
                            <p class="mt-1 font-bold text-slate-900">{{ $class->class_name }}</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl">
                            <p class="text-slate-400 font-semibold">Grade Level</p>
                            <p class="mt-1 font-bold text-slate-900">{{ $class->grade_level }}</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl">
                            <p class="text-slate-400 font-semibold">Section</p>
                            <p class="mt-1 font-bold text-slate-900">{{ $class->section }}</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl">
                            <p class="text-slate-400 font-semibold">School Year</p>
                            <p class="mt-1 font-bold text-slate-900">{{ $class->school_year }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-teacher-layout>
