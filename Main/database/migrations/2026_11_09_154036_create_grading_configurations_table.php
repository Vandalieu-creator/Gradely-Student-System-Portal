
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grading_configurations', function (Blueprint $table) {
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

            $table->string('grading_framework')->default('numerical');

            $table->decimal('written_work_weight', 5, 2)->default(30);
            $table->decimal('performance_task_weight', 5, 2)->default(50);
            $table->decimal('quarterly_assessment_weight', 5, 2)->default(20);

            $table->timestamps();

            $table->unique(
                ['class_id', 'subject', 'quarter', 'school_year'],
                'grading_config_class_subject_quarter_year_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grading_configurations');
    }
};
