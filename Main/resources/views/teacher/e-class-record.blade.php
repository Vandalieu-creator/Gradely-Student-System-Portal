
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Class Record - Gradely</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .grade-table th,
        .grade-table td {
            white-space: nowrap;
        }

        .grade-table input.score-input {
            width: 65px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            padding: 5px 3px;
            font-size: 12px;
            background: white;
        }

        .grade-table input:focus {
            outline: 2px solid #38bdf8;
            border-color: transparent;
        }
    </style>
</head>

<body
    class="min-h-screen bg-slate-100"
    x-data="{
        sidebarCollapsed: localStorage.getItem('gradely_teacher_sidebar_collapsed') === 'true',
        toggleSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('gradely_teacher_sidebar_collapsed', this.sidebarCollapsed);
        }
    }">

<div class="min-h-screen flex">

    <!-- Teacher Sidebar -->
    <div class="hidden md:block shrink-0 sticky top-0 h-screen">
        <x-teacher-sidebar active="e-class-record" />
    </div>

    <!-- Main Content -->
    <div class="flex-1 min-w-0 p-4 md:p-6">

        <main class="max-w-[1600px] mx-auto bg-[#f8fafc] min-h-screen rounded-xl p-4 md:p-7">

            <!-- Header -->
            <header class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-800">
                        E-Class Record
                    </h1>

                    <p class="text-sm text-slate-500 mt-1">
                        Ginatilan Elementary School
                        @if($selectedClass)
                            <span class="mx-1">•</span>
                            School Year {{ $selectedClass->school_year }}
                        @endif
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-800">
                            Teacher {{ auth('teacher')->user()->first_name }}
                            {{ auth('teacher')->user()->last_name }}
                        </p>
                        <p class="text-xs text-slate-500">Teacher Account</p>
                    </div>

                    <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center">
                        <i class="fas fa-user text-slate-500"></i>
                    </div>
                </div>
            </header>

            <!-- Success / Error Messages -->
            @if(session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <p class="font-bold mb-1">Please check the following:</p>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(!$selectedClass)

                <section class="bg-white border border-slate-200 rounded-xl p-10 text-center">
                    <i class="fas fa-school text-4xl text-slate-300 mb-4"></i>
                    <h2 class="text-lg font-bold text-slate-700">No class assigned yet</h2>
                    <p class="text-sm text-slate-500 mt-2">
                        You need an assigned class before you can create an E-Class Record.
                    </p>
                    <a href="{{ route('teacher.my-students') }}"
                       class="inline-block mt-5 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2 rounded-lg">
                        View My Students
                    </a>
                </section>

            @else

                @php
                    $categories = [
                        'written_work' => [
                            'label' => 'Written Work',
                            'short' => 'WW',
                            'weight' => (float) $gradingConfiguration->written_work_weight,
                            'header' => 'bg-blue-50 text-blue-700',
                            'cell' => 'bg-blue-50/20',
                            'summary' => 'bg-blue-50/50 text-blue-700',
                        ],
                        'performance_task' => [
                            'label' => 'Performance Tasks',
                            'short' => 'PT',
                            'weight' => (float) $gradingConfiguration->performance_task_weight,
                            'header' => 'bg-teal-50 text-teal-700',
                            'cell' => 'bg-teal-50/20',
                            'summary' => 'bg-teal-50/50 text-teal-700',
                        ],
                        'quarterly_assessment' => [
                            'label' => 'Quarterly Assessment',
                            'short' => 'QA',
                            'weight' => (float) $gradingConfiguration->quarterly_assessment_weight,
                            'header' => 'bg-amber-50 text-amber-700',
                            'cell' => 'bg-amber-50/20',
                            'summary' => 'bg-amber-50/50 text-amber-700',
                        ],
                    ];

                    $activitiesByCategory = $activities->groupBy('category');

                    $totalColumns = 1 + $activities->count() + 3 + 1;
                @endphp

                <!-- Toolbar -->
                <section class="bg-white border border-slate-200 rounded-xl p-3 mb-4">

                    <form method="GET"
                          action="{{ route('teacher.e-class-record') }}"
                          id="recordFilters"
                          class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">

                        <div class="flex flex-wrap items-center gap-3">

                            <label class="flex items-center gap-2 border border-slate-200 rounded-lg px-3 py-2 text-sm">
                                <span class="font-semibold text-slate-600">Class:</span>
                                <select name="class_id"
                                        onchange="this.form.submit()"
                                        class="border-0 focus:ring-0 text-sm font-bold text-teal-600 bg-transparent">
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}"
                                            @selected($selectedClass->id === $class->id)>
                                            {{ $class->class_name }}
                                            ({{ $class->grade_level }} - {{ $class->section }})
                                        </option>
                                    @endforeach
                                </select>
                            </label>

                            <label class="flex items-center gap-2 border border-slate-200 rounded-lg px-3 py-2 text-sm">
                                <span class="font-semibold text-slate-600">Subject:</span>
                                <select name="subject"
                                        onchange="this.form.submit()"
                                        class="border-0 focus:ring-0 text-sm font-bold text-teal-600 bg-transparent">
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject }}"
                                            @selected($selectedSubject === $subject)>
                                            {{ $subject }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>

                            <label class="flex items-center gap-2 border border-slate-200 rounded-lg px-3 py-2 text-sm">
                                <span class="font-semibold text-slate-600">Quarter:</span>
                                <select name="quarter"
                                        onchange="this.form.submit()"
                                        class="border-0 focus:ring-0 text-sm font-bold text-slate-700 bg-transparent">
                                    @foreach(['1st', '2nd', '3rd', '4th'] as $quarter)
                                        <option value="{{ $quarter }}"
                                            @selected($selectedQuarter === $quarter)>
                                            {{ $quarter }} Quarter
                                        </option>
                                    @endforeach
                                </select>
                            </label>

                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs font-semibold text-slate-600 border border-slate-200 bg-slate-50 rounded-full px-3 py-2">
                                {{ $selectedClass->grade_level }} - {{ $selectedClass->section }}
                            </span>

                            <button type="button"
                                    onclick="document.getElementById('activityForm').scrollIntoView({behavior:'smooth'})"
                                    class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2 rounded-lg">
                                <i class="fas fa-plus mr-1"></i> Add Activity
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Activity Creation -->
                <section id="activityForm"
                         class="bg-white border border-slate-200 rounded-xl p-4 mb-4">

                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h2 class="font-bold text-slate-800">Add Assessment Activity</h2>
                            <p class="text-xs text-slate-500 mt-1">
                                Add an activity to the selected class, subject, and quarter.
                            </p>
                        </div>
                        <i class="fas fa-clipboard-list text-teal-600 text-xl"></i>
                    </div>

                    <form method="POST"
                          action="{{ route('teacher.e-class-record.activities.store') }}"
                          class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        @csrf

                        <input type="hidden" name="class_id" value="{{ $selectedClass->id }}">
                        <input type="hidden" name="subject" value="{{ $selectedSubject }}">
                        <input type="hidden" name="quarter" value="{{ $selectedQuarter }}">

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">
                                Activity Name
                            </label>
                            <input type="text"
                                   name="activity_name"
                                   required
                                   maxlength="255"
                                   placeholder="e.g. Quiz 1"
                                   class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal-400">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">
                                Category
                            </label>
                            <select name="category"
                                    required
                                    class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm">
                                <option value="written_work">Written Work</option>
                                <option value="performance_task">Performance Task</option>
                                <option value="quarterly_assessment">Quarterly Assessment</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">
                                Maximum Score
                            </label>
                            <input type="number"
                                   name="max_score"
                                   required
                                   min="0.01"
                                   step="0.01"
                                   placeholder="e.g. 20"
                                   class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm">
                        </div>

                        <div class="flex items-end">
                            <button type="submit"
                                    class="w-full bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold px-4 py-2 rounded-lg">
                                Save Activity
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Grading Configuration -->
                <section class="bg-white border border-slate-200 rounded-xl p-4 mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h2 class="font-bold text-slate-800">Grading Configuration</h2>
                            <p class="text-xs text-slate-500 mt-1">
                                The three category weights must total 100%.
                            </p>
                        </div>
                        <i class="fas fa-sliders text-teal-600 text-xl"></i>
                    </div>

                    <form method="POST"
                          action="{{ route('teacher.e-class-record.grading-configuration.update') }}"
                          class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="class_id" value="{{ $selectedClass->id }}">
                        <input type="hidden" name="subject" value="{{ $selectedSubject }}">
                        <input type="hidden" name="quarter" value="{{ $selectedQuarter }}">

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">
                                Written Work (%)
                            </label>
                            <input type="number"
                                   name="written_work_weight"
                                   min="0" max="100" step="0.01" required
                                   value="{{ old('written_work_weight', $gradingConfiguration->written_work_weight) }}"
                                   class="weight-input w-full border border-slate-200 rounded-lg px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">
                                Performance Tasks (%)
                            </label>
                            <input type="number"
                                   name="performance_task_weight"
                                   min="0" max="100" step="0.01" required
                                   value="{{ old('performance_task_weight', $gradingConfiguration->performance_task_weight) }}"
                                   class="weight-input w-full border border-slate-200 rounded-lg px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">
                                Quarterly Assessment (%)
                            </label>
                            <input type="number"
                                   name="quarterly_assessment_weight"
                                   min="0" max="100" step="0.01" required
                                   value="{{ old('quarterly_assessment_weight', $gradingConfiguration->quarterly_assessment_weight) }}"
                                   class="weight-input w-full border border-slate-200 rounded-lg px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">
                                Grading Framework
                            </label>
                            <select name="grading_framework"
                                    class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm">
                                <option value="numerical"
                                    @selected($gradingConfiguration->grading_framework === 'numerical')>
                                    Numerical
                                </option>
                                <option value="descriptive"
                                    @selected($gradingConfiguration->grading_framework === 'descriptive')>
                                    Descriptive
                                </option>
                            </select>
                        </div>

                        <div class="flex flex-col justify-end">
                            <p id="weightTotal" class="text-xs text-slate-500 mb-1">
                                Total: 100%
                            </p>
                            <button type="submit"
                                    class="bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2 rounded-lg">
                                Save Weights
                            </button>
                        </div>
                    </form>

                    @error('weights')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror

                    @if($gradingConfiguration->grading_framework === 'descriptive')
                        <p class="mt-3 text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded-lg p-3">
                            Descriptive framework is selected. The descriptive observation and narrative assessment interface has not yet been implemented. Numerical score entry below is still displayed in this version.
                        </p>
                    @endif
                </section>

                <!-- E-Class Record Table -->
                <section class="bg-white border border-slate-200 rounded-xl overflow-hidden">

                    <div class="p-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                        <div>
                            <h2 class="font-bold text-slate-800">
                                {{ $selectedClass->class_name }}
                            </h2>
                            <p class="text-xs text-slate-500">
                                {{ $selectedClass->grade_level }} -
                                {{ $selectedClass->section }} |
                                {{ $selectedSubject }} |
                                {{ $selectedQuarter }} Quarter
                            </p>
                        </div>

                        <p class="text-xs text-slate-500">
                            <i class="fas fa-cloud-arrow-up mr-1"></i>
                            Scores save when you leave an input field.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="grade-table w-full border-collapse text-[11px] text-slate-700">

                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">

                                    <th rowspan="2"
                                        class="p-3 text-left min-w-[180px] border-r border-slate-200">
                                        <span class="text-slate-500 font-bold">Student Name</span>
                                    </th>

                                    @foreach($categories as $key => $category)
                                        @php
                                            $categoryActivities = $activitiesByCategory->get($key, collect());
                                        @endphp

                                        <th colspan="{{ max(1, $categoryActivities->count()) + 1 }}"
                                            class="p-3 text-center {{ $category['header'] }} border-r border-slate-200">
                                            {{ $category['label'] }}
                                            ({{ $category['short'] }})
                                            — {{ number_format($category['weight'], 2) }}%
                                        </th>
                                    @endforeach

                                    <th colspan="2" class="p-3 text-center text-slate-500">
                                        Grading Summary
                                    </th>
                                </tr>

                                <tr class="bg-white border-b border-slate-200 text-slate-500">

                                    @foreach($categories as $key => $category)
                                        @php
                                            $categoryActivities = $activitiesByCategory->get($key, collect());
                                        @endphp

                                        @forelse($categoryActivities as $activity)
                                            <th class="p-2 {{ $category['cell'] }}">
                                                <div class="font-bold">{{ $activity->activity_name }}</div>
                                                <div class="text-[10px] text-slate-400">
                                                    / {{ number_format((float) $activity->max_score, 2) }}
                                                </div>

                                                <form method="POST"
                                                        action="{{ route('teacher.e-class-record.activities.destroy', $activity->id) }}"
                                                        class="mt-1 delete-activity-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-500 hover:text-red-700 text-[10px]">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </th>
                                        @empty
                                            <th class="p-2 {{ $category['cell'] }} text-slate-400">
                                                No activities
                                            </th>
                                        @endforelse

                                        <th class="p-2 {{ $category['summary'] }} font-bold border-r border-slate-200">
                                            {{ $category['short'] }}%
                                        </th>
                                    @endforeach

                                    <th class="p-2">Initial</th>
                                    <th class="p-2">Remarks</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">

                                @forelse($students as $student)

                                    @php
                                        $studentName = trim(
                                            ($student->first_name ?? '') . ' ' .
                                            ($student->middle_name ?? '') . ' ' .
                                            ($student->last_name ?? '')
                                        );

                                        $scoreMap = $student->assessmentScores
                                            ->keyBy('assessment_activity_id');
                                    @endphp

                                    <tr class="student-row hover:bg-slate-50 transition"
                                        data-ww-weight="{{ $categories['written_work']['weight'] }}"
                                        data-pt-weight="{{ $categories['performance_task']['weight'] }}"
                                        data-qa-weight="{{ $categories['quarterly_assessment']['weight'] }}">

                                        <td class="p-3 font-semibold text-slate-700 border-r border-slate-100">
                                            {{ $studentName }}
                                            <div class="text-[10px] text-slate-400 font-normal">
                                                LRN: {{ $student->lrn }}
                                            </div>
                                        </td>

                                        @foreach($categories as $key => $category)
                                            @php
                                                $categoryActivities = $activitiesByCategory->get($key, collect());
                                            @endphp

                                            @forelse($categoryActivities as $activity)
                                                @php
                                                    $savedScore = $scoreMap->get($activity->id)?->score;
                                                @endphp

                                                <td class="p-2 text-center {{ $category['cell'] }}">
                                                    <input
                                                        type="number"
                                                        class="score-input"
                                                        min="0"
                                                        max="{{ $activity->max_score }}"
                                                        step="0.01"
                                                        value="{{ $savedScore }}"
                                                        placeholder="—"
                                                        data-category="{{ $key }}"
                                                        data-max="{{ $activity->max_score }}"
                                                        data-save-url="{{ route('teacher.e-class-record.scores.update', ['activity' => $activity->id, 'student' => $student->id]) }}"
                                                        aria-label="{{ $activity->activity_name }} score for {{ $studentName }}">

                                                    <span class="block text-[9px] text-slate-400 save-status"></span>
                                                </td>
                                            @empty
                                                <td class="p-2 text-center {{ $category['cell'] }} text-slate-300">
                                                    —
                                                </td>
                                            @endforelse

                                            <td class="p-2 text-center {{ $category['summary'] }} font-bold border-r border-slate-100">
                                                <span class="category-percentage"
                                                      data-category-total="{{ $key }}">0.00</span>%
                                            </td>
                                        @endforeach

                                        <td class="p-2 text-center font-bold text-slate-800">
                                            <span class="initial-grade">—</span>
                                        </td>

                                        <td class="p-2 text-center text-slate-500">
                                            <span class="grade-remarks">Incomplete</span>
                                        </td>

                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="{{ $totalColumns }}"
                                            class="p-8 text-center text-slate-400">
                                            No students found in this class.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Footer Statistics -->
                <section class="mt-4 bg-white border border-slate-200 rounded-xl p-4">

                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">

                        <div class="flex flex-wrap items-center gap-6 text-xs text-slate-500">
                            <div>
                                Students:
                                <strong class="text-slate-800 text-sm ml-1" id="studentCount">
                                    {{ $students->count() }}
                                </strong>
                            </div>

                            <div>
                                Class Average:
                                <strong class="text-slate-800 text-sm ml-1" id="classAverage">—</strong>
                            </div>

                            <div>
                                Highest Initial Grade:
                                <strong class="text-emerald-600 text-sm ml-1" id="highestGrade">—</strong>
                            </div>

                            <div>
                                Lowest Initial Grade:
                                <strong class="text-red-500 text-sm ml-1" id="lowestGrade">—</strong>
                            </div>
                        </div>

                        <div class="text-xs text-slate-500">
                            <span id="completionSummary">Waiting for scores.</span>
                        </div>

                    </div>
                </section>

            @endif

        </main>
    </div>
</div>
<!-- Custom Delete Confirmation Modal -->
<div id="deleteActivityModal"
     class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6">

        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                <i class="fas fa-trash-alt text-red-600 text-xl"></i>
            </div>

            <div>
                <h2 class="text-lg font-bold text-slate-800">
                    Delete Assessment Activity?
                </h2>
                <p class="text-xs text-slate-500">
                    Please confirm this action.
                </p>
            </div>
        </div>

        <p class="text-sm text-slate-600 leading-relaxed mb-6">
            Are you sure you want to delete this activity?
            All student scores associated with it will also be deleted.
            This action cannot be undone.
        </p>

        <div class="flex justify-end gap-3">
            <button type="button"
                    id="cancelDeleteActivity"
                    class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-100 font-semibold text-sm">
                Cancel
            </button>

            <button type="button"
                    id="confirmDeleteActivity"
                    class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 font-semibold text-sm">
                <i class="fas fa-trash mr-1"></i>
                Delete Activity
            </button>
        </div>

    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    /**
     * Calculate a student's category percentages and weighted initial grade.
     * Blank scores are treated as not yet entered and prevent a complete
     * initial grade from being displayed.
     */
    function calculateStudentRow(row) {
        const categories = [
            'written_work',
            'performance_task',
            'quarterly_assessment'
        ];

        let categoryPercentages = {};
        let allActivitiesScored = true;
        let hasActivities = false;

        categories.forEach(category => {
            const inputs = row.querySelectorAll(
                `.score-input[data-category="${category}"]`
            );

            let earned = 0;
            let possible = 0;

            inputs.forEach(input => {
                hasActivities = true;
                possible += Number(input.dataset.max);

                if (input.value === '') {
                    allActivitiesScored = false;
                } else {
                    earned += Number(input.value);
                }
            });

            const percentage = possible > 0
                ? (earned / possible) * 100
                : 0;

            categoryPercentages[category] = percentage;

            const output = row.querySelector(
                `[data-category-total="${category}"]`
            );

            if (output) {
                output.textContent = percentage.toFixed(2);
            }
        });

        const weights = {
            written_work: Number(row.dataset.wwWeight),
            performance_task: Number(row.dataset.ptWeight),
            quarterly_assessment: Number(row.dataset.qaWeight)
        };

        const initialGrade =
            (categoryPercentages.written_work * weights.written_work / 100) +
            (categoryPercentages.performance_task * weights.performance_task / 100) +
            (categoryPercentages.quarterly_assessment * weights.quarterly_assessment / 100);

        const initialOutput = row.querySelector('.initial-grade');
        const remarksOutput = row.querySelector('.grade-remarks');

        if (!hasActivities || !allActivitiesScored) {
            initialOutput.textContent = '—';
            remarksOutput.textContent = hasActivities
                ? 'Incomplete'
                : 'No activities';

            row.dataset.initial = '';
            return;
        }

        initialOutput.textContent = initialGrade.toFixed(2);
        remarksOutput.textContent = 'Calculated';
        row.dataset.initial = initialGrade.toFixed(2);
    }

    /**
     * Update the class statistics using completed initial grades.
     */
    function calculateClassStatistics() {
        const rows = [...document.querySelectorAll('.student-row')];

        const grades = rows
            .map(row => row.dataset.initial)
            .filter(value => value !== '')
            .map(Number);

        const average = document.getElementById('classAverage');
        const highest = document.getElementById('highestGrade');
        const lowest = document.getElementById('lowestGrade');
        const summary = document.getElementById('completionSummary');

        if (!average) return;

        if (grades.length === 0) {
            average.textContent = '—';
            highest.textContent = '—';
            lowest.textContent = '—';
        } else {
            const total = grades.reduce((sum, grade) => sum + grade, 0);

            average.textContent = (total / grades.length).toFixed(2);
            highest.textContent = Math.max(...grades).toFixed(2);
            lowest.textContent = Math.min(...grades).toFixed(2);
        }

        summary.textContent =
            `${grades.length} of ${rows.length} students have complete scores.`;
    }

    /**
     * Save an individual score through the Laravel route.
     */
    async function saveStudentScore(input) {
        const status = input.parentElement.querySelector('.save-status');
        const value = input.value;

        const max = Number(input.dataset.max);

        if (value !== '' && (Number(value) < 0 || Number(value) > max)) {
            status.textContent = `Enter 0 to ${max}`;
            status.className = 'block text-[9px] text-red-600 save-status';
            return;
        }

        status.textContent = 'Saving...';
        status.className = 'block text-[9px] text-slate-400 save-status';

        try {
            const response = await fetch(input.dataset.saveUrl, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    score: value === '' ? null : Number(value)
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(
                    data.message || 'Unable to save this score.'
                );
            }

            status.textContent = 'Saved';
            status.className = 'block text-[9px] text-emerald-600 save-status';

        } catch (error) {
            status.textContent = 'Save failed';
            status.className = 'block text-[9px] text-red-600 save-status';

            console.error(error);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.student-row').forEach(row => {
            calculateStudentRow(row);
        });

        calculateClassStatistics();

        document.querySelectorAll('.score-input').forEach(input => {
            input.addEventListener('change', async () => {
                await saveStudentScore(input);

                const row = input.closest('.student-row');
                calculateStudentRow(row);
                calculateClassStatistics();
            });
        });

        // Custom confirmation modal for deleting assessment activities.
        const deleteModal = document.getElementById('deleteActivityModal');
        const cancelDeleteButton = document.getElementById('cancelDeleteActivity');
        const confirmDeleteButton = document.getElementById('confirmDeleteActivity');

        let pendingDeleteForm = null;

        document.querySelectorAll('.delete-activity-form').forEach(form => {
            form.addEventListener('submit', event => {
                event.preventDefault();

                pendingDeleteForm = form;

                deleteModal.classList.remove('hidden');
                deleteModal.classList.add('flex');
            });
        });

        cancelDeleteButton.addEventListener('click', () => {
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex');
            pendingDeleteForm = null;
        });

        confirmDeleteButton.addEventListener('click', () => {
            if (pendingDeleteForm) {
                pendingDeleteForm.submit();
            }
        });

        // Show the current total of the three grading weights.
        const weightInputs = document.querySelectorAll('.weight-input');
        const weightTotal = document.getElementById('weightTotal');

        function updateWeightTotal() {
            if (!weightTotal) return;

            const total = [...weightInputs]
                .reduce((sum, input) => sum + Number(input.value || 0), 0);

            weightTotal.textContent = `Total: ${total.toFixed(2)}%`;

            weightTotal.className =
                Math.abs(total - 100) < 0.01
                    ? 'text-xs text-emerald-600 mb-1'
                    : 'text-xs text-red-600 mb-1';
        }

        weightInputs.forEach(input => {
            input.addEventListener('input', updateWeightTotal);
        });

        updateWeightTotal();
    });
</script>

</body>
</html>
