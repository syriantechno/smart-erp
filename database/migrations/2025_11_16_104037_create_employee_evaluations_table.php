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
        Schema::create('employee_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('evaluator_id')->nullable();

            // Overall 1-5 stars
            $table->unsignedTinyInteger('overall_rating');

            // Optional detailed ratings (1-5)
            $table->unsignedTinyInteger('performance_rating')->nullable();
            $table->unsignedTinyInteger('behavior_rating')->nullable();
            $table->unsignedTinyInteger('skills_rating')->nullable();

            $table->text('comments')->nullable();
            $table->timestamp('evaluated_at')->nullable();

            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('evaluator_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_evaluations');
    }
};
