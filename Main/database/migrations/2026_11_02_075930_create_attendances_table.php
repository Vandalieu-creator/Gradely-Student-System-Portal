
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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            // Student whose attendance is being recorded
            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            // Related class and teacher
            $table->foreignId('class_id')
                ->constrained('classes')
                ->cascadeOnDelete();

            $table->foreignId('teacher_id')
                ->constrained('teachers')
                ->cascadeOnDelete();

            // Attendance information
            $table->date('attendance_date');

            $table->enum('status', [
                'present',
                'absent',
                'late',
                'excused',
            ]);

            $table->text('remarks')->nullable();

            $table->timestamps();

            // Prevent duplicate attendance entries
            $table->unique(
                ['student_id', 'attendance_date'],
                'unique_student_attendance_per_day'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
