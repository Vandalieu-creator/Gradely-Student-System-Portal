<x-teacher-layout active="students" title="Register New Student — {{ $class->class_name }}">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex items-center space-x-3 max-w-7xl mx-auto">
            <a href="{{ route('teacher.classes.students.index', $class) }}" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                    Register Student
                </h1>
                <p class="text-xs font-semibold text-slate-500">
                    Add a new learner to {{ $class->class_name }}
                </p>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6">

        <a href="{{ route('teacher.classes.students.index', $class) }}"
           class="text-xs font-bold text-slate-500 hover:text-sky-600 transition flex items-center space-x-1.5">
            <span>← Back to Student List</span>
        </a>

        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-8 shadow-xs space-y-6">
            <div class="pb-4 border-b border-slate-100">
                <h2 class="text-xl font-bold text-slate-900">Student Enrollment Information</h2>
                <p class="text-xs text-slate-500 mt-1">Register a student under {{ $class->class_name }}.</p>
            </div>

            @if ($errors->any())
                <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-xs font-semibold text-rose-800 space-y-1">
                    <p class="font-bold">Please correct the following errors:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('teacher.classes.students.store', $class) }}" class="space-y-4">
                @csrf

                <div>
                    <label for="lrn" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Learner Reference Number (LRN) *
                    </label>
                    <input id="lrn" name="lrn" type="text"
                           value="{{ old('lrn') }}"
                           placeholder="e.g. 109876543224"
                           maxlength="20" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-xs font-bold text-slate-700 mb-1.5">First Name *</label>
                        <input id="first_name" name="first_name" type="text"
                               value="{{ old('first_name') }}"
                               placeholder="e.g. Maria"
                               required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div>
                        <label for="middle_name" class="block text-xs font-bold text-slate-700 mb-1.5">Middle Name</label>
                        <input id="middle_name" name="middle_name" type="text"
                               value="{{ old('middle_name') }}"
                               placeholder="e.g. Clara"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div>
                        <label for="last_name" class="block text-xs font-bold text-slate-700 mb-1.5">Last Name *</label>
                        <input id="last_name" name="last_name" type="text"
                               value="{{ old('last_name') }}"
                               placeholder="e.g. Santos"
                               required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-xs font-bold text-slate-700 mb-1.5">Date of Birth *</label>
                        <input id="date_of_birth" name="date_of_birth" type="date"
                               value="{{ old('date_of_birth') }}"
                               max="{{ date('Y-m-d') }}" required
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white">
                    </div>

                    <div>
                        <label for="gender" class="block text-xs font-bold text-slate-700 mb-1.5">Gender *</label>
                        <select id="gender" name="gender" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white">
                            <option value="">Select Gender</option>
                            <option value="Male" @selected(old('gender') === 'Male')>Male</option>
                            <option value="Female" @selected(old('gender') === 'Female')>Female</option>
                        </select>
                    </div>

                    <div class="p-3 bg-sky-50 border border-sky-100 rounded-xl flex items-center justify-between">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-sky-600 block">Class Section</span>
                            <span class="text-xs font-bold text-sky-950">{{ $class->class_name }}</span>
                        </div>
                        <span class="text-[10px] font-semibold text-sky-700">{{ $class->grade_level }}</span>
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-xs font-bold text-slate-700 mb-1.5">Address</label>
                    <textarea id="address" name="address" rows="3"
                              placeholder="e.g. Barangay Poblacion, Ginatilan, Cebu"
                              class="w-full p-3.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500">{{ old('address') }}</textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                    <a href="{{ route('teacher.classes.students.index', $class) }}"
                       class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-[#172554] hover:bg-[#1e3a8a] text-white text-xs font-bold shadow-md transition">
                        Register Student
                    </button>
                </div>

            </form>
        </div>

    </div>

</x-teacher-layout>
