<?php



use App\Http\Controllers\TeacherStudentController;
use App\Http\Controllers\TeacherClassController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', function () {
        return view('teacher.dashboard');
    })->name('dashboard');

    Route::get('/classes', [TeacherClassController::class, 'index'])
        ->name('classes.index');

    Route::get('/classes/create', [TeacherClassController::class, 'create'])
        ->name('classes.create');

    Route::post('/classes', [TeacherClassController::class, 'store'])
        ->name('classes.store');

    Route::get('/classes/{class}/students', [TeacherStudentController::class, 'index'])
        ->name('classes.students.index');

     Route::get('/classes/{class}/students/archived', [TeacherStudentController::class, 'archived'])
         ->name('classes.students.archived');

        Route::get('/classes/{class}/students/{student}', [TeacherStudentController::class, 'show'])
    ->name('classes.students.show');
       
    Route::get('/classes/{class}/students/{student}/edit', [TeacherStudentController::class, 'edit'])
    ->name('classes.students.edit');

    Route::put('/classes/{class}/students/{student}', [TeacherStudentController::class, 'update'])
    ->name('classes.students.update');

    Route::delete('/classes/{class}/students/{student}', [TeacherStudentController::class, 'destroy'])
    ->name('classes.students.destroy');
    
    Route::post('/classes/{class}/students/{student}/restore', [TeacherStudentController::class, 'restore'])
    ->name('classes.students.restore');

        Route::get('/classes/{class}/students/create', [TeacherStudentController::class, 'create'])
    ->name('classes.students.create');

     Route::post('/classes/{class}/students', [TeacherStudentController::class, 'store'])
    ->name('classes.students.store');


    
        
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
