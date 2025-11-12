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
        Schema::create('electronic_mails', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('subject');
            $table->text('content');
            $table->enum('type', ['incoming', 'outgoing'])->default('incoming');
            $table->enum('status', ['draft', 'sent', 'received', 'read', 'archived'])->default('draft');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');

            // Sender information
            $table->string('sender_name')->nullable();
            $table->string('sender_email')->nullable();
            $table->unsignedBigInteger('sender_user_id')->nullable();

            // Recipient information
            $table->string('recipient_name')->nullable();
            $table->string('recipient_email')->nullable();
            $table->unsignedBigInteger('recipient_user_id')->nullable();

            // Additional fields
            $table->json('attachments')->nullable();
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();

            // References
            $table->unsignedBigInteger('parent_id')->nullable(); // For replies/threads
            $table->boolean('is_starred')->default(false);
            $table->boolean('is_read')->default(false);

            // Organization
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();

            $table->timestamp('sent_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('sender_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('recipient_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('electronic_mails')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');

            // Indexes
            $table->index(['type', 'status']);
            $table->index(['sender_user_id']);
            $table->index(['recipient_user_id']);
            $table->index(['department_id']);
            $table->index(['company_id']);
            $table->index(['parent_id']);
            $table->index(['is_starred']);
            $table->index(['is_read']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electronic_mails');
    }
};
