<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AssessmentActivity;
use App\Models\GradingConfiguration;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentAssessmentScore;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EClassRecordController extends Controller
{
    private const SUBJECTS = [
        'Mathematics',
        'Science',
        'English',
        'Filipino',
        'Araling Panlipunan',
        'MAPEH',
        'EsP',
    ];

    private const QUARTERS = [
        '1st',
        '2nd',
        '3rd',
        '4th',
    ];

    /**
     * Display the E-Class Record.
     */
    public function index(Request $request)
    {
        $teacher = auth('teacher')->user();
        $subjects = self::SUBJECTS;

        // Only retrieve classes belonging to the logged-in teacher.
        $classes = $teacher->classes()
            ->with('students')
            ->orderBy('grade_level')
            ->orderBy('section')
            ->get();

        // Handle teachers who do not have an assigned class yet.
        if ($classes->isEmpty()) {
            return view('teacher.e-class-record', [
                'classes' => $classes,
                'selectedClass' => null,
                'subjects' => self::SUBJECTS,
                'selectedSubject' => 'Mathematics',
                'selectedQuarter' => '2nd',
                'gradingConfiguration' => null,
                'activities' => collect(),
                'students' => collect(),
            ]);
        }

        // Use the requested class only if it belongs to this teacher.
        $requestedClassId = $request->query('class_id');

        $selectedClass = $classes->firstWhere(
            'id',
            (int) $requestedClassId
        );

        // Automatically select the first assigned class by default.
        $selectedClass ??= $classes->first();

        $selectedSubject = $request->query('subject', 'Mathematics');

        if (!in_array($selectedSubject, self::SUBJECTS, true)) {
            $selectedSubject = 'Mathematics';
        }

        $selectedQuarter = $request->query('quarter', '2nd');

        if (!in_array($selectedQuarter, self::QUARTERS, true)) {
            $selectedQuarter = '2nd';
        }

        $schoolYear = $selectedClass->school_year;

        // Retrieve grading settings for the selected class and subject.
        $gradingConfiguration = GradingConfiguration::firstOrNew(
            [
                'class_id' => $selectedClass->id,
                'teacher_id' => $teacher->id,
                'subject' => $selectedSubject,
                'quarter' => $selectedQuarter,
                'school_year' => $schoolYear,
            ],
            [
                'grading_framework' => 'numerical',
                'written_work_weight' => 30,
                'performance_task_weight' => 50,
                'quarterly_assessment_weight' => 20,
            ]
        );

        // Retrieve activities belonging to the selected class,
        // subject, quarter, and school year.
        $activities = $selectedClass->assessmentActivities()
            ->where('teacher_id', $teacher->id)
            ->where('subject', $selectedSubject)
            ->where('quarter', $selectedQuarter)
            ->where('school_year', $schoolYear)
            ->orderByRaw("
                CASE category
                    WHEN 'written_work' THEN 1
                    WHEN 'performance_task' THEN 2
                    WHEN 'quarterly_assessment' THEN 3
                END
            ")
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $activityIds = $activities->pluck('id');

        // Retrieve only students in the selected class,
        // together with their scores for the selected activities.
        $students = $selectedClass->students()
            ->with([
                'assessmentScores' => function ($query) use ($activityIds) {
                    $query->whereIn('assessment_activity_id', $activityIds);
                },
            ])
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('teacher.e-class-record', compact(
            'classes',
            'selectedClass',
            'subjects',
            'selectedSubject',
            'selectedQuarter',
            'gradingConfiguration',
            'activities',
            'students'
        ));
    }

    /**
     * Create an assessment activity.
     */
    public function storeActivity(Request $request)
    {
        $teacher = auth('teacher')->user();

        $validated = $request->validate([
            'class_id' => ['required', 'integer'],
            'subject' => ['required', Rule::in(self::SUBJECTS)],
            'quarter' => ['required', Rule::in(self::QUARTERS)],
            'category' => [
                'required',
                Rule::in([
                    'written_work',
                    'performance_task',
                    'quarterly_assessment',
                ]),
            ],
            'activity_name' => ['required', 'string', 'max:255'],
            'max_score' => ['required', 'numeric', 'gt:0'],
        ]);

        // Confirm that the selected class belongs to this teacher.
        $class = $teacher->classes()
            ->findOrFail($validated['class_id']);

        $class->assessmentActivities()->create([
            'teacher_id' => $teacher->id,
            'subject' => $validated['subject'],
            'quarter' => $validated['quarter'],
            'school_year' => $class->school_year,
            'category' => $validated['category'],
            'activity_name' => $validated['activity_name'],
            'max_score' => $validated['max_score'],
        ]);

        return $this->backToRecord(
            $class,
            $validated['subject'],
            $validated['quarter'],
            'Activity created successfully.'
        );
    }

    /**
     * Update an existing assessment activity.
     */
    public function updateActivity(
        Request $request,
        AssessmentActivity $activity
    ) {
        $teacher = auth('teacher')->user();

        $class = $teacher->classes()
            ->findOrFail($activity->class_id);

        $validated = $request->validate([
            'activity_name' => ['required', 'string', 'max:255'],
            'max_score' => ['required', 'numeric', 'gt:0'],
            'category' => [
                'required',
                Rule::in([
                    'written_work',
                    'performance_task',
                    'quarterly_assessment',
                ]),
            ],
        ]);

        $activity->update($validated);

        return $this->backToRecord(
            $class,
            $activity->subject,
            $activity->quarter,
            'Activity updated successfully.'
        );
    }

    /**
     * Delete an assessment activity.
     */
    public function destroyActivity(AssessmentActivity $activity)
    {
        $teacher = auth('teacher')->user();

        $class = $teacher->classes()
            ->findOrFail($activity->class_id);

        $subject = $activity->subject;
        $quarter = $activity->quarter;

        // Related student scores are deleted through the database cascade.
        $activity->delete();

        return $this->backToRecord(
            $class,
            $subject,
            $quarter,
            'Activity deleted successfully.'
        );
    }

    /**
     * Save an individual student's score for an activity.
     */
    public function updateScore(
        Request $request,
        AssessmentActivity $activity,
        Student $student
    ) {
        $teacher = auth('teacher')->user();

        // Confirm that this activity belongs to one of the teacher's classes.
        $teacher->classes()
            ->findOrFail($activity->class_id);

        // Confirm that the student belongs to the activity's class.
        abort_unless(
            (int) $student->class_id === (int) $activity->class_id,
            404
        );

        $validated = $request->validate([
            'score' => [
                'nullable',
                'numeric',
                'min:0',
                'max:' . $activity->max_score,
            ],
        ]);

        StudentAssessmentScore::updateOrCreate(
            [
                'assessment_activity_id' => $activity->id,
                'student_id' => $student->id,
            ],
            [
                'score' => $validated['score'],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Student score saved successfully.',
        ]);
    }

    /**
     * Update grading weights for a class, subject, and quarter.
     */
    public function updateGradingConfiguration(Request $request)
    {
        $teacher = auth('teacher')->user();

        $validated = $request->validate([
            'class_id' => ['required', 'integer'],
            'subject' => ['required', Rule::in(self::SUBJECTS)],
            'quarter' => ['required', Rule::in(self::QUARTERS)],
            'written_work_weight' => ['required', 'numeric', 'min:0', 'max:100'],
            'performance_task_weight' => ['required', 'numeric', 'min:0', 'max:100'],
            'quarterly_assessment_weight' => ['required', 'numeric', 'min:0', 'max:100'],
            'grading_framework' => [
                'required',
                Rule::in(['numerical', 'descriptive']),
            ],
        ]);

        // Make sure the weights add up to exactly 100%.
        $totalWeight =
            (float) $validated['written_work_weight'] +
            (float) $validated['performance_task_weight'] +
            (float) $validated['quarterly_assessment_weight'];

        if (abs($totalWeight - 100) > 0.01) {
            return back()
                ->withErrors([
                    'weights' => 'The grading weights must add up to 100%.',
                ])
                ->withInput();
        }

        $class = $teacher->classes()
            ->findOrFail($validated['class_id']);

        GradingConfiguration::updateOrCreate(
            [
                'class_id' => $class->id,
                'teacher_id' => $teacher->id,
                'subject' => $validated['subject'],
                'quarter' => $validated['quarter'],
                'school_year' => $class->school_year,
            ],
            [
                'grading_framework' => $validated['grading_framework'],
                'written_work_weight' => $validated['written_work_weight'],
                'performance_task_weight' => $validated['performance_task_weight'],
                'quarterly_assessment_weight' => $validated['quarterly_assessment_weight'],
            ]
        );

        return $this->backToRecord(
            $class,
            $validated['subject'],
            $validated['quarter'],
            'Grading configuration saved successfully.'
        );
    }

    /**
     * Return to the selected E-Class Record.
     */
    private function backToRecord(
        SchoolClass $class,
        string $subject,
        string $quarter,
        string $message
    ) {
        return redirect()
            ->route('teacher.e-class-record', [
                'class_id' => $class->id,
                'subject' => $subject,
                'quarter' => $quarter,
            ])
            ->with('success', $message);
    }
}
