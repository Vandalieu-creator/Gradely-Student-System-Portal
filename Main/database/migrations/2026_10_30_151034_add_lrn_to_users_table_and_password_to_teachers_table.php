
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'lrn')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('lrn')->nullable()->unique();
            });
        }

        if (!Schema::hasColumn('teachers', 'password')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->string('password')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('password');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['lrn']);
            $table->dropColumn('lrn');
        });
    }
};
