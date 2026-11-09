<x-teacher-layout active="students" title="Archived Students — {{ $class->class_name }}">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-20 px-6 py-4">
        <div class="flex items-center space-x-3 max-w-7xl mx-auto">
            <a href="{{ route('teacher.classes.students.index', $class) }}" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">
                    Archived Students
                </h1>
                <p class="text-xs font-semibold text-slate-500">
                    {{ $class->class_name }} • Removed students with preserved academic records
                </p>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6">

        <div class="flex justify-between items-center">
            <a href="{{ route('teacher.classes.students.index', $class) }}"
               class="text-xs font-bold text-slate-500 hover:text-sky-600 transition flex items-center space-x-1.5">
                <span>← Back to Active Student Roster</span>
            </a>
        </div>

        <div class="rounded-3xl border border-amber-200 bg-amber-50/60 p-5 flex items-start space-x-3">
            <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-box-archive text-sm"></i>
            </div>
            <div class="text-xs text-amber-900">
                <p class="font-bold text-sm">Archived Records Notice</p>
                <p class="mt-0.5 leading-relaxed">
                    These students have been removed from the active classroom roster. Their grades and attendance records are permanently preserved, and they can be restored back to the classroom at any time.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-xs">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">{{ $class->class_name }} — Archived List</h3>
                    <p class="text-xs text-slate-500">{{ $students->count() }} archived student records</p>
                </div>
            </div>

            @if ($students->isEmpty())
                <div class="px-6 py-16 text-center">
                    <p class="font-bold text-slate-700 text-base">No archived students found.</p>
                    <p class="mt-1 text-xs text-slate-400">Students removed from this classroom will appear here.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] border-b border-slate-200">
                            <tr>
                                <th class="py-3 px-4">#</th>
                                <th class="py-3 px-4">Student Name</th>
                                <th class="py-3 px-4">LRN</th>
                                <th class="py-3 px-4">Archived Date</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($students as $student)
                                <tr class="hover:bg-slate-50/80 transition" x-data="{ showRestoreModal: false }">
                                    <td class="py-3.5 px-4 font-mono text-slate-400">{{ $loop->iteration }}</td>
                                    <td class="py-3.5 px-4 font-bold text-slate-900">
                                        {{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}
                                    </td>
                                    <td class="py-3.5 px-4 font-mono text-slate-500">{{ $student->lrn }}</td>
                                    <td class="py-3.5 px-4 text-slate-500">{{ $student->deleted_at?->format('M d, Y') }}</td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold text-[10px]">
                                            Archived
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <button type="button"
                                                @click="showRestoreModal = true"
                                                class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition cursor-pointer">
                                            Restore
                                        </button>

                                        <!-- Restore Modal -->
                                        <div x-show="showRestoreModal"
                                             x-cloak
                                             x-transition.opacity
                                             @keydown.escape.window="showRestoreModal = false"
                                             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 text-left"
                                             style="display: none;">
                                            <div @click.outside="showRestoreModal = false"
                                                 class="w-full max-w-md rounded-3xl bg-white p-7 shadow-2xl border-4 border-slate-100 space-y-4">
                                                
                                                <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-xl font-bold">
                                                    ✓
                                                </div>

                                                <div class="text-center">
                                                    <h3 class="text-lg font-bold text-slate-900">Restore Student?</h3>
                                                    <p class="mt-2 text-xs text-slate-600">
                                                        Restore <strong>{{ $student->first_name }} {{ $student->last_name }}</strong> to active classroom list?
                                                    </p>
                                                    <p class="mt-1 text-[11px] text-emerald-700 font-semibold">
                                                        Preserved grades and attendance will be reactivated.
                                                    </p>
                                                </div>

                                                <div class="flex items-center justify-center space-x-2 pt-2">
                                                    <button type="button"
                                                            @click="showRestoreModal = false"
                                                            class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                                                        Cancel
                                                    </button>
                                                    <form action="{{ route('teacher.classes.students.restore', [$class, $student->id]) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 transition cursor-pointer">
                                                            Yes, Restore Student
                                                        </button>
                                                    </form>
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

</x-teacher-layout>
