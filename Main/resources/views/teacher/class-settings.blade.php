
<x-teacher-layout active="class-settings" title="Class Settings">

    <!-- Page Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 max-w-7xl mx-auto">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center border border-sky-100 shadow-sm">
                    <i class="fa-solid fa-gear text-lg"></i>
                </div>

                <div>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                        Class Settings
                    </h1>
                    <p class="text-xs font-semibold text-slate-500">
                        Manage your classroom information and class assignments
                    </p>
                </div>
            </div>
        </div>
    </header>

    <div
        x-data="{
            showAddStudentModal: false,
            selectedClassId: ''
        }"
        class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6"
    >

        <!-- Success Message -->
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-green-50 border border-green-200 text-green-700 text-sm font-semibold">
                <i class="fa-solid fa-circle-check mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700">
                <p class="font-bold text-sm mb-2">Please check the following:</p>

                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Overview Cards -->
        <section class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">
                            Total Classes
                        </p>

                        <h2 class="text-3xl font-extrabold text-slate-900 mt-2">
                            {{ $classes->count() }}
                        </h2>
                    </div>

                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center">
                        <i class="fa-solid fa-chalkboard text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">
                            Total Students
                        </p>

                        <h2 class="text-3xl font-extrabold text-slate-900 mt-2">
                            {{ $classes->sum('students_count') }}
                        </h2>
                    </div>

                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center">
                        <i class="fa-solid fa-user-graduate text-xl"></i>
                    </div>
                </div>
            </div>

        </section>

        <!-- Add Class Form -->
        <section class="bg-white rounded-3xl border border-slate-200/80 p-5 sm:p-7 shadow-sm">

            <div class="flex items-center gap-3 mb-6">
                <div class="w-11 h-11 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    <i class="fa-solid fa-plus text-lg"></i>
                </div>

                <div>
                    <h2 class="text-base font-extrabold text-slate-900">
                        Add New Class
                    </h2>

                    <p class="text-xs font-medium text-slate-500 mt-1">
                        Create another class under your teacher account.
                    </p>
                </div>
            </div>

            <form action="{{ route('teacher.class-settings.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- Grade Level -->
                    <div>
                        <label for="grade_level" class="block text-xs font-bold text-slate-700 mb-2">
                            Grade Level <span class="text-red-500">*</span>
                        </label>

                        <select id="grade_level"
                                name="grade_level"
                                required
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white">

                            <option value="">Select grade level</option>

                            @foreach(['Kindergarten', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'] as $grade)
                                <option value="{{ $grade }}" @selected(old('grade_level') === $grade)>
                                    {{ $grade }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Section -->
                    <div>
                        <label for="section" class="block text-xs font-bold text-slate-700 mb-2">
                            Section <span class="text-red-500">*</span>
                        </label>

                        <input type="text"
                               id="section"
                               name="section"
                               value="{{ old('section') }}"
                               placeholder="e.g. Sampaguita"
                               maxlength="255"
                               required
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white">
                    </div>

                    <!-- Room -->
                    <div>
                        <label for="room" class="block text-xs font-bold text-slate-700 mb-2">
                            Room
                        </label>

                        <input type="text"
                               id="room"
                               name="room"
                               value="{{ old('room') }}"
                               placeholder="e.g. Room 101 (Optional)"
                               maxlength="255"
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white">
                    </div>

                    <!-- School Year -->
                    <div>
                        <label for="school_year" class="block text-xs font-bold text-slate-700 mb-2">
                            School Year <span class="text-red-500">*</span>
                        </label>

                        <input type="text"
                               id="school_year"
                               name="school_year"
                               value="{{ old('school_year') }}"
                               placeholder="e.g. 2026-2027"
                               maxlength="255"
                               required
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500 focus:bg-white">
                    </div>

                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-[#00adef] hover:bg-[#009fdc] text-white text-xs font-extrabold px-6 py-3 rounded-xl shadow-sm transition">
                        <i class="fa-solid fa-plus"></i>
                        Create Class
                    </button>
                </div>

            </form>

        </section>

        <!-- My Classes -->
        <section class="bg-white rounded-3xl border border-slate-200/80 p-5 sm:p-7 shadow-sm">

            <div class="flex items-center gap-3 mb-6">
                <div class="w-11 h-11 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    <i class="fa-solid fa-school text-lg"></i>
                </div>

                <div>
                    <h2 class="text-base font-extrabold text-slate-900">
                        My Classes
                    </h2>

                    <p class="text-xs font-medium text-slate-500 mt-1">
                        View all classes assigned to your account.
                    </p>
                </div>
            </div>

            
            @forelse($classes as $class)

                <div class="border border-slate-200/80 rounded-2xl p-5 mb-4 last:mb-0 hover:border-sky-200 transition">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 shrink-0 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                                <i class="fa-solid fa-chalkboard"></i>
                            </div>

                            <div>
                                <h3 class="text-sm font-extrabold text-slate-900">
                                    {{ $class->class_name }}
                                </h3>

                                <p class="text-xs font-semibold text-slate-500 mt-1">
                                    {{ $class->grade_level }} · {{ $class->section }}
                                </p>

                                <div class="flex flex-wrap gap-x-4 gap-y-2 mt-3 text-xs text-slate-500">
                                    <span>
                                        <i class="fa-solid fa-door-open mr-1"></i>
                                        {{ $class->room ?: 'No room assigned' }}
                                    </span>

                                    <span>
                                        <i class="fa-solid fa-calendar mr-1"></i>
                                        {{ $class->school_year }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 self-start">

                            <div class="flex items-center gap-2 text-xs font-bold bg-sky-50 text-sky-700 px-4 py-2.5 rounded-xl">
                                <i class="fa-solid fa-users"></i>

                                {{ $class->students_count }}
                                {{ $class->students_count === 1 ? 'Student' : 'Students' }}
                            </div>

                            <button
                                type="button"
                                @click="selectedClassId = '{{ $class->id }}'; showAddStudentModal = true"
                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold transition"
                            >
                                <i class="fa-solid fa-user-plus"></i>
                                Add Student
                            </button>

                        </div>

                    </div>

                </div>

            @empty

                <div class="text-center py-12 border-2 border-dashed border-slate-200 rounded-2xl">
                    <div class="w-16 h-16 rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-school text-2xl"></i>
                    </div>

                    <h3 class="text-sm font-extrabold text-slate-700">
                        No Classes Yet
                    </h3>

                    <p class="text-xs text-slate-500 mt-2">
                        Create your first class using the form above.
                    </p>
                </div>

            @endforelse

            <template x-teleport="body">
                <div
                    x-show="showAddStudentModal"
                    x-cloak
                    x-transition.opacity
                    @keydown.escape.window="showAddStudentModal = false"
                    @click.self="showAddStudentModal = false"
                    class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/60 p-4"
                >
                    <div
                        x-show="showAddStudentModal"
                        x-transition
                        class="w-full max-w-2xl max-h-[90vh] overflow-y-auto bg-white rounded-2xl shadow-2xl"
                    >
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between p-6 border-b border-slate-100">
                            <div>
                                <h2 class="text-lg font-extrabold text-slate-900">
                                    Enroll New Student
                                </h2>
                                <p class="text-sm text-slate-500 mt-1">
                                    Add a student to this class.
                                </p>
                            </div>

                            <button
                                type="button"
                                @click="showAddStudentModal = false"
                                class="w-9 h-9 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition"
                            >
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <!-- Enrollment Form -->
                        <form
                            method="POST"
                            action="{{ route('teacher.students.store') }}"
                            class="p-6 space-y-5"
                        >
                            @csrf

                            <input
                                type="hidden"
                                name="class_id"
                                :value="selectedClassId"
                            >

                            <!-- First and Middle Name -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-2">
                                        First Name <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="first_name"
                                        value="{{ old('first_name') }}"
                                        required
                                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-sky-500 focus:ring-sky-500"
                                        placeholder="Enter first name"
                                    >
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-2">
                                        Middle Name
                                    </label>
                                    <input
                                        type="text"
                                        name="middle_name"
                                        value="{{ old('middle_name') }}"
                                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-sky-500 focus:ring-sky-500"
                                        placeholder="Optional"
                                    >
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="last_name"
                                    value="{{ old('last_name') }}"
                                    required
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-sky-500 focus:ring-sky-500"
                                    placeholder="Enter last name"
                                >
                            </div>

                            <!-- LRN -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">
                                    Learner Reference Number (LRN) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="lrn"
                                    value="{{ old('lrn') }}"
                                    required
                                    maxlength="12"
                                    minlength="12"
                                    pattern="[0-9]{12}"
                                    inputmode="numeric"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-sky-500 focus:ring-sky-500"
                                    placeholder="Enter 12-digit LRN"
                                >
                                <p class="text-xs text-slate-400 mt-1">
                                    The LRN must contain exactly 12 digits.
                            </p>
                            </div>

                            !-- Date of Birth and Gender -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-2">
                                        Date of Birth
                                    </label>
                                    <input
                                        type="date"
                                        name="date_of_birth"
                                        value="{{ old('date_of_birth') }}"
                                        max="{{ date('Y-m-d') }}"
                                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-sky-500 focus:ring-sky-500"
                                    >
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-2">
                                        Gender
                                    </label>
                                    <select
                                        name="gender"
                                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-sky-500 focus:ring-sky-500"
                                    >
                                        <option value="">Select gender</option>
                                        <option value="Male" @selected(old('gender') === 'Male')>Male</option>
                                        <option value="Female" @selected(old('gender') === 'Female')>Female</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Address -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">
                                    Address
                                </label>
                                <textarea
                                    name="address"
                                    rows="2"
                                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-sky-500 focus:ring-sky-500"
                                    placeholder="Enter student's address"
                                >{{ old('address') }}</textarea>
                            </div>

                            <!-- Selected Class -->
                            <div class="rounded-xl bg-sky-50 border border-sky-100 p-4">
                                <p class="text-xs font-bold text-sky-700">
                                    <i class="fa-solid fa-school mr-1"></i>
                                    Selected Class
                                </p>
                                <p class="text-sm font-extrabold text-sky-900 mt-1">
                                    <span x-text="selectedClassId ? 'Class selected' : 'No class selected'"></span>
                                </p>
                            </div>

                            <!-- Modal Actions -->
                            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                                <button
                                    type="button"
                                    @click="showAddStudentModal = false"
                                    class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-bold hover:bg-slate-50 transition"
                                >
                                    Cancel
                                </button>

                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold transition"
                                >
                                    <i class="fa-solid fa-user-plus"></i>
                                    Enroll Student
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </template>



        </section>

    </div>

</x-teacher-layout>
