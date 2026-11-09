<x-teacher-layout active="classes" title="Create New Class">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex items-center space-x-3 max-w-7xl mx-auto">
            <a href="{{ route('teacher.classes.index') }}" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                    Create New Class
                </h1>
                <p class="text-xs font-semibold text-slate-500">
                    Set up a new classroom and student section
                </p>
            </div>
        </div>
    </header>

    <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-6">

            <div class="pb-4 border-b border-slate-100">
                <h2 class="text-xl font-bold text-slate-900">Classroom Information</h2>
                <p class="text-xs text-slate-500 mt-1">Enter the details of the class you will manage.</p>
            </div>

            @if ($errors->any())
                <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4 text-xs font-semibold text-rose-800 space-y-1">
                    <p class="font-bold">Please check the errors below:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('teacher.classes.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="class_name" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Class Name *
                    </label>
                    <input type="text"
                           id="class_name"
                           name="class_name"
                           value="{{ old('class_name') }}"
                           placeholder="e.g. Grade 4 - Diamond"
                           required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="grade_level" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Grade Level *
                        </label>
                        <select id="grade_level"
                                name="grade_level"
                                required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500 bg-white">
                            <option value="">Select Grade Level</option>
                            @foreach (range(1, 6) as $grade)
                                <option value="Grade {{ $grade }}" {{ old('grade_level') == "Grade $grade" ? 'selected' : '' }}>
                                    Grade {{ $grade }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="section" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Section Name *
                        </label>
                        <input type="text"
                               id="section"
                               name="section"
                               value="{{ old('section') }}"
                               placeholder="e.g. Diamond"
                               required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="school_year" class="block text-xs font-bold text-slate-700 mb-1.5">
                            School Year *
                        </label>
                        <input type="text"
                               id="school_year"
                               name="school_year"
                               value="{{ old('school_year', '2026-2027') }}"
                               placeholder="2026-2027"
                               required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>

                    <div>
                        <label for="room" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Room / Location
                        </label>
                        <input type="text"
                               id="room"
                               name="room"
                               value="{{ old('room') }}"
                               placeholder="e.g. Building A, Room 204"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                    <a href="{{ route('teacher.classes.index') }}" 
                       class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 rounded-xl bg-[#172554] hover:bg-[#1e3a8a] text-white text-xs font-bold shadow-md transition">
                        Save Classroom
                    </button>
                </div>
            </form>

        </div>
    </div>

</x-teacher-layout>
