<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-blue-700">
                Gradely Teacher Portal
            </p>
            <h2 class="mt-2 text-2xl font-bold text-slate-900">
                My Classes
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Manage your classrooms and monitor student enrollment.
            </p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-6 sm:px-8 lg:px-10">

            <!-- Page Introduction -->
            <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
                <div>
                    <h3 class="text-3xl font-bold text-slate-900">
                        Classroom Overview
                    </h3>
                    <p class="mt-2 text-base text-slate-600">
                        View and manage the classrooms assigned to your account.
                    </p>
                </div>

<a href="{{ route('teacher.classes.create') }}"
   style="background-color: #172554; color: white;"
   class="inline-flex items-center justify-center rounded-xl px-6 py-3 text-sm font-semibold shadow-sm hover:opacity-90">
    + Create New Class
</a>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">
                        TOTAL CLASSES
                    </p>
                    <p class="mt-3 text-4xl font-bold text-slate-900">
                        {{ $classes->count() }}
                    </p>
                    <p class="mt-2 text-sm text-slate-500">
                        Classes under your teaching account
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-7 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">
                        TOTAL ENROLLED STUDENTS
                    </p>
                    <p class="mt-3 text-4xl font-bold text-slate-900">
                        {{ $classes->sum('students_count') }}
                    </p>
                    <p class="mt-2 text-sm text-slate-500">
                        Students enrolled across your classes
                    </p>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="rounded-xl border border-green-200 bg-green-50 px-6 py-4 text-sm font-medium text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Class List Heading -->
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900">
                        Your Classrooms
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Select a classroom to manage its students.
                    </p>
                </div>

                <span class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">
                    {{ $classes->count() }} Classes
                </span>
            </div>

            <!-- Class Cards -->
            @forelse ($classes as $class)

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <!-- Card Header -->
                    <div class="flex flex-col justify-between gap-4 border-b border-slate-100 px-7 py-6 sm:flex-row sm:items-center">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-blue-700">
                                {{ $class->grade_level }}
                            </p>

                            <h4 class="mt-2 text-2xl font-bold text-slate-900">
                                {{ $class->class_name }}
                            </h4>

                            <p class="mt-2 text-sm text-slate-500">
                                Section: {{ $class->section }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-blue-50 px-5 py-3">
                            <p class="text-xs font-semibold uppercase text-blue-700">
                                School Year
                            </p>
                            <p class="mt-1 font-bold text-blue-950">
                                {{ $class->school_year }}
                            </p>
                        </div>
                    </div>

                    <!-- Class Details -->
                    <div class="grid grid-cols-1 gap-6 px-7 py-6 sm:grid-cols-3">
                        <div>
                            <p class="text-sm text-slate-500">Grade Level</p>
                            <p class="mt-2 font-semibold text-slate-900">
                                {{ $class->grade_level }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Section</p>
                            <p class="mt-2 font-semibold text-slate-900">
                                {{ $class->section }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Classroom</p>
                            <p class="mt-2 font-semibold text-slate-900">
                                {{ $class->room ?? 'Not assigned' }}
                            </p>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="flex flex-col justify-between gap-4 border-t border-slate-100 bg-slate-50 px-7 py-5 sm:flex-row sm:items-center">
                        <div>
                            <p class="text-sm text-slate-500">
                                Enrolled Students
                            </p>
                            <p class="mt-1 text-2xl font-bold text-slate-900">
                                {{ $class->students_count }}
                                <span class="text-sm font-normal text-slate-500">
                                    Students
                                </span>
                            </p>
                        </div>

<a href="{{ route('teacher.classes.students.index', $class) }}"
   style="background-color: #172554; color: white;"
   class="inline-flex items-center justify-center rounded-xl px-6 py-3 text-sm font-semibold shadow-sm hover:opacity-90">
    View Students →
</a>
</a>
                    </div>

                </div>

            @empty

                <!-- Empty State -->
                <div class="rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center shadow-sm">
                    <h4 class="text-2xl font-bold text-slate-900">
                        No Classes Yet
                    </h4>

                    <p class="mx-auto mt-3 max-w-lg text-slate-600">
                        You haven't created or been assigned any classes yet.
                        Create your first classroom to start organizing your students.
                    </p>

                    <a href="{{ route('teacher.classes.create') }}"
                       class="mt-6 inline-flex items-center justify-center rounded-xl bg-blue-950 px-7 py-3 text-sm font-semibold text-white hover:bg-blue-900">
                        + Create Your First Class
                    </a>
                </div>

            @endforelse

        </div>
    </div>
</x-app-layout>