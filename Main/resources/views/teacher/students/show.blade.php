<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-blue-700">
                Gradely Teacher Portal
            </p>

            <h2 class="mt-2 text-2xl font-bold text-slate-900">
                Student Details
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-10">
        <div class="mx-auto max-w-4xl px-6 sm:px-8">

            <a href="{{ route('teacher.classes.students.index', $class) }}"
               class="text-sm font-semibold text-blue-900 hover:underline">
                ← Back to Student List
            </a>
            <div class="mt-4 flex justify-end gap-3">
    <a href="{{ route('teacher.classes.students.edit', [$class, $student]) }}"
       style="background-color: #172554; color: white;"
       class="inline-flex items-center rounded-xl px-6 py-3 text-sm font-semibold shadow-sm hover:opacity-90">
        Edit Student
    </a>
<!-- Archive Student Button and Confirmation Modal -->
<div x-data="{ showArchiveModal: false }">

    <!-- Open Modal -->
    <button type="button"
            @click="showArchiveModal = true"
            style="background-color: #b91c1c; color: white;"
            class="inline-flex items-center rounded-xl px-6 py-3 text-sm font-semibold shadow-sm hover:opacity-90">
        Archive Student
    </button>

    <!-- Confirmation Modal -->
    <div x-show="showArchiveModal"
         x-cloak
         x-transition.opacity
         @keydown.escape.window="showArchiveModal = false"
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4"
         style="display: none;">

        <div @click.outside="showArchiveModal = false"
             x-transition.scale
             class="w-full max-w-md rounded-2xl bg-white p-7 shadow-2xl"
             role="dialog"
             aria-modal="true">

            <!-- Warning Icon -->
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-8 w-8 text-red-700"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                </svg>
            </div>

            <!-- Modal Message -->
            <div class="mt-5 text-center">
                <h3 class="text-xl font-bold text-slate-900">
                    Archive Student?
                </h3>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Are you sure you want to archive
                    <span class="font-bold text-slate-900">
                        {{ $student->first_name }}
                        {{ $student->last_name }}
                    </span>?
                </p>

                <p class="mt-2 text-xs text-emerald-700">
                    Their grades and attendance records will be preserved.
                    You can restore this student later.
                </p>
            </div>

            <!-- Modal Actions -->
            <div class="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:justify-center">

                <!-- Cancel -->
                <button type="button"
                        @click="showArchiveModal = false"
                        class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Cancel
                </button>

                <!-- Confirm Archive -->
                <form action="{{ route('teacher.classes.students.destroy', [$class, $student]) }}"
                      method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            style="background-color: #b91c1c; color: white;"
                            class="w-full rounded-xl px-5 py-3 text-sm font-semibold hover:opacity-90">
                        Yes, Archive Student
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

</div>


            <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            @if (session('success'))
    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-800">
        {{ session('success') }}
    </div>
@endif
                <div class="bg-blue-950 px-8 py-8">
                    <p class="text-xs font-bold uppercase tracking-widest text-blue-200">
                        Student Record
                    </p>

                    <h3 class="mt-3 text-3xl font-bold text-white">
                        {{ $student->first_name }}
                        {{ $student->middle_name }}
                        {{ $student->last_name }}
                    </h3>

                    <p class="mt-2 text-sm text-blue-200">
                        Learner Reference Number: {{ $student->lrn }}
                    </p>
                </div>

                <div class="p-8">
                    <h4 class="mb-6 text-lg font-bold text-slate-900">
                        Personal Information
                    </h4>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                        <div>
                            <p class="text-sm text-slate-500">First Name</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $student->first_name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Middle Name</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $student->middle_name ?? 'Not provided' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Last Name</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $student->last_name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">LRN</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $student->lrn }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Date of Birth</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $student->date_of_birth?->format('F d, Y') ?? 'Not provided' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-slate-500">Gender</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $student->gender ?? 'Not specified' }}
                            </p>
                        </div>

                        <div class="sm:col-span-2">
                            <p class="text-sm text-slate-500">Address</p>
                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $student->address ?? 'Not provided' }}
                            </p>
                        </div>

                    </div>

                    <div class="mt-8 border-t border-slate-100 pt-8">
                        <h4 class="mb-5 text-lg font-bold text-slate-900">
                            Classroom Information
                        </h4>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                            <div>
                                <p class="text-sm text-slate-500">Class Name</p>
                                <p class="mt-1 font-semibold text-slate-900">
                                    {{ $class->class_name }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-slate-500">Grade Level</p>
                                <p class="mt-1 font-semibold text-slate-900">
                                    {{ $class->grade_level }}
                                </p>
                            </div>

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

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>