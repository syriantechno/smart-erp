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
        // Add new columns to tasks table
        Schema::table('tasks', function (Blueprint $table) {
            // Parent task for subtasks
            $table->unsignedBigInteger('parent_id')->nullable()->after('project_id');
            $table->foreign('parent_id')->references('id')->on('tasks')->onDelete('cascade');
            
            // Time tracking
            $table->decimal('actual_hours', 8, 2)->nullable()->after('estimated_hours');
            $table->timestamp('started_at')->nullable()->after('actual_hours');
            $table->timestamp('completed_at')->nullable()->after('started_at');
            
            // Recurring tasks
            $table->boolean('is_recurring')->default(false)->after('is_active');
            $table->string('recurrence_pattern')->nullable()->after('is_recurring'); // daily, weekly, monthly, yearly
            $table->date('recurrence_end_date')->nullable()->after('recurrence_pattern');
            
            // Progress tracking
            $table->integer('progress_percentage')->default(0)->after('status');
            
            // Watchers (users who want to be notified)
            $table->json('watchers')->nullable()->after('assigned_by');
            
            // Dependencies
            $table->json('depends_on')->nullable()->after('watchers'); // Task IDs this task depends on
            $table->json('blocks')->nullable()->after('depends_on'); // Task IDs blocked by this task
            
            // Additional metadata
            $table->string('task_type')->default('task')->after('code'); // task, bug, feature, improvement
            $table->integer('story_points')->nullable()->after('estimated_hours');
            $table->string('sprint')->nullable()->after('story_points');
            
            // Indexes
            $table->index('parent_id');
            $table->index('task_type');
            $table->index('is_recurring');
            $table->index('progress_percentage');
        });

        // Create task attachments table
        Schema::create('task_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('uploaded_by');
            $table->string('filename');
            $table->string('original_filename');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->unsignedBigInteger('file_size')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->index('task_id');
        });

        // Create task time logs table
        Schema::create('task_time_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->decimal('hours', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_billable')->default(true);
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['task_id', 'user_id']);
            $table->index('started_at');
        });

        // Create task checklists table (more advanced than steps)
        Schema::create('task_checklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->string('title');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->index('task_id');
        });

        // Create task checklist items table
        Schema::create('task_checklist_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checklist_id');
            $table->string('title');
            $table->boolean('is_completed')->default(false);
            $table->unsignedBigInteger('completed_by')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('checklist_id')->references('id')->on('task_checklists')->onDelete('cascade');
            $table->foreign('completed_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            
            $table->index('checklist_id');
        });

        // Create task labels/tags table
        Schema::create('task_labels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color')->default('#6b7280');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index('company_id');
        });

        // Create task_label pivot table
        Schema::create('task_label', function (Blueprint $table) {
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('label_id');
            $table->timestamps();

            $table->primary(['task_id', 'label_id']);
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('label_id')->references('id')->on('task_labels')->onDelete('cascade');
        });

        // Create task activity log table
        Schema::create('task_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('user_id');
            $table->string('action'); // created, updated, status_changed, assigned, commented, etc.
            $table->string('field')->nullable(); // which field was changed
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['task_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_activities');
        Schema::dropIfExists('task_label');
        Schema::dropIfExists('task_labels');
        Schema::dropIfExists('task_checklist_items');
        Schema::dropIfExists('task_checklists');
        Schema::dropIfExists('task_time_logs');
        Schema::dropIfExists('task_attachments');

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn([
                'parent_id',
                'actual_hours',
                'started_at',
                'completed_at',
                'is_recurring',
                'recurrence_pattern',
                'recurrence_end_date',
                'progress_percentage',
                'watchers',
                'depends_on',
                'blocks',
                'task_type',
                'story_points',
                'sprint',
            ]);
        });
    }
};
