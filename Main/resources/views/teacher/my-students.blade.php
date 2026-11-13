<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Students - Gradely</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body
    class="min-h-screen bg-slate-100"
    x-data="{
        sidebarCollapsed: localStorage.getItem('gradely_teacher_sidebar_collapsed') === 'true',
        searchQuery: '',
        toggleSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('gradely_teacher_sidebar_collapsed', this.sidebarCollapsed);
        }
    }">

<div class="min-h-screen flex">

    <!-- Teacher Sidebar -->
    <div class="hidden md:block shrink-0 sticky top-0 h-screen">
        <x-teacher-sidebar active="my-students" />
    </div>

    <!-- Main Content -->
    <div class="flex-1 min-w-0 p-4 md:p-6">

        <main class="max-w-[1600px] mx-auto bg-[#f8fafc] min-h-screen rounded-xl p-4 md:p-7">

            <!-- Header -->
            <header class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">

                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-800">
                        My Students
                    </h1>

                    <p class="text-sm text-slate-500 mt-1">
                        Ginatilan Elementary School
                        <span class="mx-1">•</span>
                        School Year 2026-2027
                    </p>
                </div>

                <!-- Teacher Profile -->
                <div class="flex items-center gap-3">

                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-800">
                            Teacher {{ auth('teacher')->user()->first_name }}
                            {{ auth('teacher')->user()->last_name }}
                        </p>

                        <p class="text-xs text-slate-500">
                            Teacher Account
                        </p>
                    </div>

                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center">
                        <i class="fas fa-user text-slate-500"></i>
                    </div>

                </div>

            </header>

            <!-- My Students Content -->
            @php
                $teacher = auth('teacher')->user();
                $classes = \App\Models\SchoolClass::with('students')
                    ->where('teacher_id', $teacher->id)
                    ->get();
                $myStudents = $classes->flatMap->students;
            @endphp

            <section class="bg-white border border-slate-200 rounded-xl p-6 md:p-8">

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">

                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>

                        <div>
                            <h2 class="text-lg font-bold text-slate-800">
                                Student Management
                            </h2>

                            <p class="text-sm text-slate-500">
                                @if($classes->isNotEmpty())
                                    Advisory Class:
                                    <span class="font-semibold text-slate-700">
                                        {{ $classes->map(fn($c) => $c->grade_level . ' - ' . $c->section)->join(', ') }}
                                    </span>
                                @else
                                    No advisory class assigned yet
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Search Filter -->
                        <div class="relative">
                            <i class="fas fa-search text-slate-400 text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                            <input type="text"
                                   x-model="searchQuery"
                                   placeholder="Search student or LRN..."
                                   class="pl-9 pr-3 py-2 text-xs border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 text-slate-700">
                        </div>

                        <span class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 text-xs font-bold px-3.5 py-2 rounded-lg">
                            <i class="fas fa-user-graduate"></i>
                            {{ $myStudents->count() }} {{ \Illuminate\Support\Str::plural('Student', $myStudents->count()) }}
                        </span>
                    </div>

                </div>

                <div class="border-t border-slate-100 pt-5">

                    @if($myStudents->isEmpty())
                        <div class="text-center py-10">
                            <p class="text-sm font-semibold text-slate-600">
                                No students enrolled in your class yet.
                            </p>
                            <p class="text-xs text-slate-400 mt-1">
                                Students assigned to your section will automatically appear here.
                            </p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-slate-700">
                                <thead>
                                    <tr class="bg-slate-50 text-slate-600 text-xs uppercase font-bold border-b border-slate-200">
                                        <th class="py-3 px-4">#</th>
                                        <th class="py-3 px-4">LRN</th>
                                        <th class="py-3 px-4">Student Name</th>
                                        <th class="py-3 px-4">Grade & Section</th>
                                        <th class="py-3 px-4">Gender</th>
                                        <th class="py-3 px-4 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($myStudents as $index => $student)
                                        @php
                                            $fullName = trim($student->last_name . ', ' . $student->first_name . ' ' . ($student->middle_name ?? ''));
                                            $searchText = strtolower($fullName . ' ' . ($student->lrn ?? ''));
                                        @endphp
                                        <tr x-show="searchQuery.trim() === '' || @js($searchText).includes(searchQuery.toLowerCase())"
                                            class="hover:bg-slate-50/80 transition">
                                            <td class="py-3 px-4 text-slate-400 font-medium">{{ $index + 1 }}</td>
                                            <td class="py-3 px-4 font-mono text-xs text-slate-600">{{ $student->lrn ?? '—' }}</td>
                                            <td class="py-3 px-4 font-bold text-slate-800">{{ $fullName }}</td>
                                            <td class="py-3 px-4 text-slate-600">
                                                {{ $student->schoolClass?->grade_level }} - {{ $student->schoolClass?->section }}
                                            </td>
                                            <td class="py-3 px-4 text-slate-600 capitalize">{{ $student->gender ?? '—' }}</td>
                                            <td class="py-3 px-4 text-center">
                                                <span class="bg-emerald-100 text-emerald-700 text-xs px-2.5 py-1 rounded-full font-bold">
                                                    Enrolled
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>

            </section>

        </main>

    </div>

</div>

</body>
</html>