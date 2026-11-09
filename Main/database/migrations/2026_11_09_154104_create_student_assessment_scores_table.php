
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_assessment_scores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('assessment_activity_id')
                ->constrained('assessment_activities')
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->decimal('score', 8, 2)->nullable();

            $table->timestamps();

            $table->unique(
                ['assessment_activity_id', 'student_id'],
                'student_assessment_activity_student_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_assessment_scores');
    }
};
