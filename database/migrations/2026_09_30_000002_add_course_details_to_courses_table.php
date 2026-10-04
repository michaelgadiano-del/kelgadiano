<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('instructor_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->text('description')->nullable()->after('title');
            $table->boolean('is_active')->default(true)->after('units');
            $table->string('image_path')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('instructor_id');
            $table->dropColumn(['description', 'is_active', 'image_path']);
        });
    }
};
