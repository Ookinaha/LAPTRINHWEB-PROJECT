<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_sections', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lecturer_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedTinyInteger('day_of_week')->nullable(); // 2..8 (8 = Chủ nhật)
            $table->unsignedTinyInteger('start_period')->nullable();
            $table->unsignedTinyInteger('end_period')->nullable();
            $table->string('room', 30)->nullable();
            $table->unsignedSmallInteger('max_students')->default(50);
            $table->boolean('is_open')->default(true); // cho phép đăng ký
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_sections');
    }
};
