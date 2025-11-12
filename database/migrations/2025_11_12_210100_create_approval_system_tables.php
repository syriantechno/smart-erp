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
        Schema::create('approval_requests', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description');
            $table->enum('type', [
                'leave_request',
                'purchase_request',
                'expense_claim',
                'loan_request',
                'overtime_request',
                'training_request',
                'equipment_request',
                'other'
            ]);
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');

            // Request details
            $table->json('request_data')->nullable(); // Store specific request details
            $table->decimal('amount', 15, 2)->nullable(); // For financial requests
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('duration_days')->nullable();

            // Relationships
            $table->unsignedBigInteger('requester_id'); // User who made the request
            $table->unsignedBigInteger('current_approver_id')->nullable(); // Current person to approve
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();

            // Approval workflow
            $table->json('approval_levels')->nullable(); // Define approval hierarchy
            $table->integer('current_level')->default(1);
            $table->text('rejection_reason')->nullable();

            // Files/attachments
            $table->json('attachments')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('requester_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('current_approver_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');

            // Indexes
            $table->index(['type', 'status']);
            $table->index(['requester_id']);
            $table->index(['current_approver_id']);
            $table->index(['department_id']);
            $table->index(['company_id']);
            $table->index(['status']);
            $table->index(['priority']);
        });

        Schema::create('approval_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('approval_request_id');
            $table->enum('action', ['submitted', 'approved', 'rejected', 'commented', 'forwarded']);
            $table->text('comments')->nullable();
            $table->unsignedBigInteger('user_id'); // Who performed the action
            $table->integer('level')->nullable(); // Approval level
            $table->timestamps();

            $table->foreign('approval_request_id')->references('id')->on('approval_requests')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->index(['approval_request_id']);
            $table->index(['user_id']);
            $table->index(['action']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_logs');
        Schema::dropIfExists('approval_requests');
    }
};
