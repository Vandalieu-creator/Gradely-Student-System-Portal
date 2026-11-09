
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_id')
                ->constrained('classes')
                ->cascadeOnDelete();

            $table->foreignId('teacher_id')
                ->constrained('teachers')
                ->cascadeOnDelete();

            $table->string('subject');
            $table->enum('quarter', ['1st', '2nd', '3rd', '4th']);
            $table->string('school_year');

            $table->enum('category', [
                'written_work',
                'performance_task',
                'quarterly_assessment',
            ]);

            $table->string('activity_name');
            $table->decimal('max_score', 8, 2);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(
                ['class_id', 'subject', 'quarter', 'school_year'],
                'assessment_activities_class_subject_quarter_year_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_activities');
    }
};
