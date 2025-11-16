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
        Schema::create('employee_evaluation_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_evaluation_id');
            $table->unsignedBigInteger('criterion_id');
            $table->unsignedTinyInteger('score');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('employee_evaluation_id')
                ->references('id')
                ->on('employee_evaluations')
                ->onDelete('cascade');

            $table->foreign('criterion_id')
                ->references('id')
                ->on('evaluation_criteria')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_evaluation_items');
    }
};
