<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">
                Archived Students
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Students removed from the active classroom list.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                <h3 class="font-semibold text-amber-900">
                    Archived Student Records
                </h3>
                <p class="mt-1 text-sm text-amber-800">
                    These students have been removed from the active classroom
                    roster. Their grades and attendance records are preserved.
                    You can restore a student when necessary.
                </p>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm">

                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $class->class_name }} — Archived Students
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ $class->grade_level }} ·
                            Section {{ $class->section }} ·
                            {{ $class->school_year }}
                        </p>
                    </div>

                    <a href="{{ route('teacher.classes.students.index', $class) }}"
                       style="background-color: #172554; color: white;"
                       class="rounded-xl px-4 py-2 text-sm font-semibold">
                        Back to Student List
                    </a>
                </div>

                <p class="mb-4 text-sm text-gray-600">
                    Archived Students: {{ $students->count() }}
                </p>

                @if ($students->isEmpty())
                    <div class="rounded-xl border border-gray-200 p-8 text-center">
                        <p class="font-semibold text-gray-700">
                            No archived students found.
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                            Students removed from this classroom will appear here.
                        </p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-gray-600">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th class="px-4 py-3">Student Name</th>
                                    <th class="px-4 py-3">LRN</th>
                                    <th class="px-4 py-3">Removed Date</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Action</th>

                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @foreach ($students as $student)
                                    <tr>
                                        <td class="px-4 py-3">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="px-4 py-3 font-semibold text-gray-900">
                                            {{ $student->first_name }}
                                            {{ $student->middle_name }}
                                            {{ $student->last_name }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $student->lrn }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $student->deleted_at->format('M d, Y') }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                                                Archived
                                            </span>
                                        </td>
                                     <td class="px-4 py-3 text-sm">

    <div x-data="{ showRestoreModal: false }">

        <!-- Open Confirmation Modal -->
        <button type="button"
                @click="showRestoreModal = true"
                style="background-color: #166534; color: white;"
                class="rounded-xl px-4 py-2 text-xs font-semibold hover:opacity-90">
            Restore Student
        </button>

        <!-- Confirmation Modal -->
        <div
            x-show="showRestoreModal"
            x-cloak
            x-transition.opacity
            @keydown.escape.window="showRestoreModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4"
            style="display: none;"
        >

            <div
                @click.outside="showRestoreModal = false"
                x-transition.scale
                class="w-full max-w-md rounded-2xl bg-white p-7 shadow-2xl"
                role="dialog"
                aria-modal="true"
                aria-labelledby="restore-modal-title"
            >

                <!-- Warning Icon -->
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-8 w-8 text-emerald-700"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <!-- Modal Message -->
                <div class="mt-5 text-center">

                    <h3 id="restore-modal-title"
                        class="text-xl font-bold text-slate-900">
                        Restore Student?
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        Are you sure you want to restore
                        <span class="font-bold text-slate-900">
                            {{ $student->first_name }}
                            {{ $student->last_name }}
                        </span>
                        to the active classroom list?
                    </p>

                    <p class="mt-2 text-xs text-emerald-700">
                        The student's existing grades and attendance records will be preserved.
                    </p>

                </div>

                <!-- Modal Actions -->
                <div class="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:justify-center">

                    <!-- Cancel -->
                    <button type="button"
                            @click="showRestoreModal = false"
                            class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Cancel
                    </button>

                    <!-- Confirm Restore -->
                    <form action="{{ route('teacher.classes.students.restore', [$class, $student->id]) }}"
                          method="POST">
                        @csrf

                        <button type="submit"
                                style="background-color: #166534; color: white;"
                                class="w-full rounded-xl px-5 py-3 text-sm font-semibold hover:opacity-90">
                            Yes, Restore Student
                        </button>
                    </form>

                </div>

            </div>
        </div>

    </div>

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