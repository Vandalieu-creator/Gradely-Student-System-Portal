
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Teacher\EClassRecordController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\ClassSettingsController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\MessageController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'teacher' => redirect()->route('teacher.dashboard'),
        'parent' => redirect()->route('parent.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        default => abort(403),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [TeacherController::class, 'dashboard'])
            ->name('dashboard');

        // My Students - teammate's design with database integration
        Route::get('/my-students', function () {

            $teacher = auth('teacher')->user();

            abort_unless($teacher, 403);

            // Get only this teacher's classes
            $classes = $teacher->classes()
                ->withCount('students')
                ->orderBy('class_name')
                ->get();

            // Search and class filter values
            $search = trim(request('search', ''));
            $classFilter = request('class', '');

            // Get students belonging to this teacher's classes
            $students = \App\Models\Student::query()
                ->with('schoolClass')
                ->whereIn('class_id', $classes->pluck('id'))

                // Filter by selected class
                ->when($classFilter, function ($query) use ($classFilter, $classes) {
                    $classIds = $classes
                        ->where('class_name', $classFilter)
                        ->pluck('id');

                    $query->whereIn('class_id', $classIds);
                })

                // Search by student name or LRN
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('middle_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('lrn', 'like', "%{$search}%");
                    });
                })

                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get();

            return view('teacher.students.all', compact(
                'students',
                'classes',
                'search',
                'classFilter'
            ));

        })->name('my-students');

        // Phil-IRI Reading
        Route::get('/phil-iri-reading', function () {
            return view('teacher.phil-iri-reading');
        })->name('phil-iri-reading');

        // Attendance
        Route::get('/attendance', [TeacherController::class, 'attendance'])
            ->name('attendance.index');

        Route::post('/attendance', [TeacherController::class, 'saveAttendance'])
            ->name('attendance.store');

        // Class Schedule
        Route::get('/schedule', [TeacherController::class, 'schedule'])
            ->name('schedule.index');

        // Assignments
        Route::get('/assignments', [TeacherController::class, 'assignments'])
            ->name('assignments.index');

        // Learning Materials
        Route::get('/materials', [TeacherController::class, 'materials'])
            ->name('materials.index');

        // Grades
        Route::get('/grades', [TeacherController::class, 'grades'])
            ->name('grades.index');

        // Announcements
        Route::get('/announcements', [TeacherController::class, 'announcements'])
            ->name('announcements.index');

        // Messages
        Route::get('/messages', [TeacherController::class, 'messages'])
            ->name('messages.index');

        Route::post('/messages', [MessageController::class, 'store'])
            ->name('messages.store');

        // DepEd Reports
        Route::get('/deped-reports', function () {
            return view('teacher.deped-reports');
        })->name('deped-reports');

        // Class Settings
        Route::get('/class-settings', [ClassSettingsController::class, 'index'])
            ->name('class-settings');
            
        Route::post('/class-settings', [ClassSettingsController::class, 'store'])
            ->name('class-settings.store');

        // Student Enrollment
        Route::post('/my-students', [StudentController::class, 'store'])
            ->name('students.store');

        /*
        |--------------------------------------------------------------------------
        | E-Class Record
        |--------------------------------------------------------------------------
        */

        Route::get('/e-class-record', [EClassRecordController::class, 'index'])
            ->name('e-class-record');

        // Assessment Activities
        Route::post('/e-class-record/activities', [EClassRecordController::class, 'storeActivity'])
            ->name('e-class-record.activities.store');

        Route::put('/e-class-record/activities/{activity}', [EClassRecordController::class, 'updateActivity'])
            ->name('e-class-record.activities.update');

        Route::delete('/e-class-record/activities/{activity}', [EClassRecordController::class, 'destroyActivity'])
            ->name('e-class-record.activities.destroy');

        // Student Assessment Scores
        Route::put('/e-class-record/activities/{activity}/students/{student}/score', [EClassRecordController::class, 'updateScore'])
            ->name('e-class-record.scores.update');

        // Grading Configuration
        Route::put('/e-class-record/grading-configuration', [EClassRecordController::class, 'updateGradingConfiguration'])
            ->name('e-class-record.grading-configuration.update');
    });

/*
|--------------------------------------------------------------------------
| Parent Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:parent'])
    ->prefix('parent')
    ->name('parent.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('parent.dashboard');
        })->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('student.dashboard');
        })->name('dashboard');

        Route::get('/grades', function () {
            return view('student.grades');
        })->name('grades');
    });

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
