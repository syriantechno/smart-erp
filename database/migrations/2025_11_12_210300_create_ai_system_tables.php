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
        Schema::create('ai_interactions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->enum('interaction_type', ['query', 'command', 'analysis', 'generation', 'chat']);
            $table->text('user_input');
            $table->text('ai_response')->nullable();
            $table->json('metadata')->nullable(); // Store additional data like tokens used, model, etc.
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->string('model_used')->nullable();
            $table->integer('tokens_used')->default(0);
            $table->decimal('cost', 8, 4)->default(0);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'created_at']);
            $table->index(['interaction_type']);
            $table->index(['status']);
        });

        Schema::create('ai_automations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('automation_type', ['data_entry', 'report_generation', 'analysis', 'workflow_automation']);
            $table->json('configuration'); // Store automation settings
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['automation_type']);
            $table->index(['is_active']);
        });

        Schema::create('ai_generated_contents', function (Blueprint $table) {
            $table->id();
            $table->string('content_type'); // emails, reports, tasks, etc.
            $table->string('content_title');
            $table->text('generated_content');
            $table->json('parameters_used')->nullable();
            $table->enum('quality_rating', ['poor', 'fair', 'good', 'excellent'])->nullable();
            $table->text('user_feedback')->nullable();
            $table->unsignedBigInteger('interaction_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('interaction_id')->references('id')->on('ai_interactions')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['content_type']);
            $table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_generated_contents');
        Schema::dropIfExists('ai_automations');
        Schema::dropIfExists('ai_interactions');
    }
};
