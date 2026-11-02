<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-blue-700">
                Gradely Teacher Portal
            </p>

            <h2 class="mt-2 text-2xl font-bold text-slate-900">
                Student Management
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-6 sm:px-8 lg:px-10">

            <!-- Back Button -->
            <a href="{{ route('teacher.classes.index') }}"
               class="inline-flex items-center text-sm font-semibold text-blue-900 hover:text-blue-700">
                ← Back to My Classes
            </a>

            <!-- Class Information -->
            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">

                <p class="text-xs font-bold uppercase tracking-widest text-blue-700">
                    {{ $class->grade_level }}
                </p>

                <h3 class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $class->class_name }}
                </h3>

                <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">

                    <div>
                        <p class="text-sm text-slate-500">Section</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $class->section }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">School Year</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $class->school_year }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Room</p>
                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $class->room ?? 'Not assigned' }}
                        </p>
                    </div>

                </div>
            </div>

            <!-- Student List -->
            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">

                <!-- Student List Header -->
                <div class="mb-7 space-y-5">

                    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

                        <div>
                            <h3 class="text-2xl font-bold text-slate-900">
                                Enrolled Students
                            </h3>

                            <p class="mt-2 text-sm text-slate-500">
                                Students registered in this classroom.
                            </p>
                        </div>

                        <!-- Student Count -->
                        <div class="rounded-xl bg-blue-50 px-5 py-3">
                            <p class="text-sm font-semibold text-blue-900">
                                {{ $students->count() }} Students
                            </p>
                        </div>

                    </div>

                    <!-- Search and Action Buttons -->
                    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">

                        <!-- Search Form -->
                        <form method="GET"
                              action="{{ route('teacher.classes.students.index', $class) }}"
                              class="flex flex-1 flex-col gap-3 sm:flex-row">

                            <input
                                type="text"
                                name="search"
                                value="{{ $search ?? '' }}"
                                placeholder="Search by student name or LRN..."
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900"
                            >

                            <button
                                type="submit"
                                style="background-color: #172554; color: white;"
                                class="rounded-xl px-6 py-3 text-sm font-semibold hover:opacity-90">
                                Search
                            </button>

                            @if (!empty($search))
                                <a href="{{ route('teacher.classes.students.index', $class) }}"
                                   class="rounded-xl border border-slate-300 px-6 py-3 text-center text-sm font-semibold text-slate-700">
                                    Clear
                                </a>
                            @endif

                        </form>

                        <!-- Student Action Buttons -->
                        <div class="flex flex-col gap-3 sm:flex-row">

                            <!-- Archived Students -->
                            <a href="{{ route('teacher.classes.students.archived', $class) }}"
                               style="background-color: #92400e; color: white;"
                               class="inline-flex justify-center rounded-xl px-5 py-3 text-sm font-semibold shadow-sm hover:opacity-90">
                                Archived Students
                            </a>

                            <!-- Register Student -->
                            <a href="{{ route('teacher.classes.students.create', $class) }}"
                               style="background-color: #172554; color: white;"
                               class="inline-flex justify-center rounded-xl px-5 py-3 text-sm font-semibold shadow-sm hover:opacity-90">
                                Register Student
                            </a>

                        </div>

                    </div>
                </div>

                <!-- Empty Student List -->
                @if ($students->isEmpty())

                    <div class="rounded-xl border border-dashed border-slate-300 px-6 py-14 text-center">

                        <h4 class="text-xl font-bold text-slate-900">
                            No Students Yet
                        </h4>

                        <p class="mt-3 text-sm text-slate-600">
                            There are currently no students enrolled in this class.
                        </p>

                    </div>

                @else

                    <!-- Student Table -->
                    <div class="overflow-x-auto">

                        <table class="w-full text-left">

                            <thead>
                                <tr class="border-b border-slate-200 bg-slate-50">

                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-600">
                                        #
                                    </th>

                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-600">
                                        Student Name
                                    </th>

                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-600">
                                        LRN
                                    </th>

                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-600">
                                        Gender
                                    </th>

                                    <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-600">
                                        Action
                                    </th>

                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($students as $index => $student)

                                    <tr class="border-b border-slate-100 hover:bg-slate-50">

                                        <td class="px-5 py-4 text-sm text-slate-600">
                                            {{ $index + 1 }}
                                        </td>

                                        <td class="px-5 py-4 text-sm font-semibold text-slate-900">
                                            {{ $student->last_name }},
                                            {{ $student->first_name }}
                                            {{ $student->middle_name }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-slate-600">
                                            {{ $student->lrn }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-slate-600">
                                            {{ $student->gender ?? 'Not specified' }}
                                        </td>

                                        <td class="px-5 py-4 text-sm">

                                            <a href="{{ route('teacher.classes.students.show', [$class, $student]) }}"
                                               style="background-color: #172554; color: white;"
                                               class="inline-flex rounded-lg px-4 py-2 font-semibold hover:opacity-90">
                                                View
                                            </a>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif

            </div>

        </div>
    </div>
</x-app-layout>