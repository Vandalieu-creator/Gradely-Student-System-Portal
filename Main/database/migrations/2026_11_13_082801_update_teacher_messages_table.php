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
    Schema::table('teacher_messages', function (Blueprint $table) {
        if (!Schema::hasColumn('teacher_messages', 'student_user_id')) {
            $table->unsignedBigInteger('student_user_id')->nullable();
        }
        if (!Schema::hasColumn('teacher_messages', 'teacher_id')) {
            $table->unsignedBigInteger('teacher_id')->nullable();
        }
        if (!Schema::hasColumn('teacher_messages', 'sender')) {
            $table->string('sender')->default('student');
        }
        if (!Schema::hasColumn('teacher_messages', 'message')) {
            $table->text('message')->nullable();
        }
        if (!Schema::hasColumn('teacher_messages', 'is_read')) {
            $table->boolean('is_read')->default(false);
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_messages', function (Blueprint $table) {
            //
        });
    }
};
