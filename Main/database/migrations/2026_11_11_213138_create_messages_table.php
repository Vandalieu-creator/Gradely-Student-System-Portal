
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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // Teacher participating in the conversation
            $table->foreignId('teacher_id')
                ->constrained('teachers')
                ->cascadeOnDelete();

            // Student participating in the conversation
            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            // User account that sent the message
            $table->foreignId('sender_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Identifies whether the sender is a teacher or student
            $table->string('sender_type');

            // Message content
            $table->text('body');

            // Tracks when the recipient reads the message
            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            // Improves conversation lookup
            $table->index(['teacher_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
