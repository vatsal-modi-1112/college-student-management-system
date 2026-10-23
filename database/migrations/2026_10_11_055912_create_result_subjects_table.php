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
        Schema::create('result_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_result_id')->constrained('student_results')->cascadeOnDelete();
            $table->string('subject', 100);
            $table->decimal('marks_obtained', 6, 2);
            $table->decimal('max_marks', 6, 2);
            $table->timestamps();
            $table->unique([
                'student_result_id',
                'subject'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_subjects');
    }
};
