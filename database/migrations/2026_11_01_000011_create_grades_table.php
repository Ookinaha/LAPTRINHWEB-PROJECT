<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->unique()->constrained()->cascadeOnDelete();
            $table->decimal('midterm', 4, 2)->nullable(); // điểm giữa kỳ (thang 10)
            $table->decimal('final', 4, 2)->nullable();   // điểm cuối kỳ (thang 10)
            $table->decimal('total', 4, 2)->nullable();   // tự tính: 40% GK + 60% CK
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
