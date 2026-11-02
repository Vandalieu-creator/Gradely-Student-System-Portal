
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();

            // Student, class, and teacher
            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->foreignId('class_id')
                ->constrained('classes')
                ->cascadeOnDelete();

            $table->foreignId('teacher_id')
                ->constrained('teachers')
                ->cascadeOnDelete();

            // Subject and grading period
            $table->string('subject');
            $table->enum('quarter', [
                '1st',
                '2nd',
                '3rd',
                '4th',
            ]);

            $table->string('school_year');

            // Grade components
            $table->decimal('written_work', 5, 2)->default(0);
            $table->decimal('performance_task', 5, 2)->default(0);
            $table->decimal('quarterly_assessment', 5, 2)->default(0);

            // Computed grades
            $table->decimal('initial_grade', 5, 2)->nullable();
            $table->decimal('quarterly_grade', 5, 2)->nullable();

            // Additional information
            $table->text('remarks')->nullable();

            $table->timestamps();

            // Prevent duplicate subject grades for the same student and quarter
            $table->unique(
                ['student_id', 'subject', 'quarter', 'school_year'],
                'unique_student_subject_quarter'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
