<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('comment');
            $table->enum('type', ['task', 'step'])->default('task');
            $table->foreignId('step_id')->nullable()->constrained('task_steps')->onDelete('cascade');
            $table->boolean('is_internal')->default(false); // Internal comments vs client-visible
            $table->timestamps();

            $table->index(['task_id', 'created_at']);
            $table->index(['step_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_comments');
    }
};
