<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration adds the ability to delegate a step to another employee
     * by creating a subtask linked to the step.
     */
    public function up(): void
    {
        Schema::table('task_steps', function (Blueprint $table) {
            // Link to delegated subtask (when step is assigned to another employee)
            $table->unsignedBigInteger('delegated_task_id')->nullable()->after('completed_by');
            $table->foreign('delegated_task_id')->references('id')->on('tasks')->onDelete('set null');
            
            // Who the step is assigned to (for delegation)
            $table->unsignedBigInteger('assigned_to')->nullable()->after('delegated_task_id');
            $table->foreign('assigned_to')->references('id')->on('employees')->onDelete('set null');
            
            // Index for faster lookups
            $table->index('delegated_task_id');
            $table->index('assigned_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_steps', function (Blueprint $table) {
            $table->dropForeign(['delegated_task_id']);
            $table->dropForeign(['assigned_to']);
            $table->dropColumn(['delegated_task_id', 'assigned_to']);
        });
    }
};
