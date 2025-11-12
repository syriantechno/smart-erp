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
        Schema::create('document_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('color', 7)->default('#3b82f6'); // Hex color
            $table->string('icon')->default('folder'); // Lucide icon name
            $table->unsignedBigInteger('parent_id')->nullable(); // For nested categories
            $table->unsignedBigInteger('company_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('document_categories')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->index(['company_id', 'parent_id']);
            $table->index(['is_active']);
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type');
            $table->integer('file_size'); // in bytes
            $table->string('mime_type');
            $table->enum('document_type', [
                'contract',
                'invoice',
                'report',
                'certificate',
                'license',
                'agreement',
                'policy',
                'manual',
                'other'
            ])->default('other');

            $table->enum('status', ['active', 'archived', 'deleted'])->default('active');
            $table->enum('access_level', ['public', 'internal', 'confidential', 'restricted'])->default('internal');

            // Relationships
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('uploaded_by');

            // Version control
            $table->string('version')->default('1.0');
            $table->unsignedBigInteger('parent_document_id')->nullable(); // For versioning

            // Metadata
            $table->json('tags')->nullable();
            $table->json('metadata')->nullable(); // Additional file metadata
            $table->date('expiry_date')->nullable();
            $table->boolean('requires_signature')->default(false);

            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('document_categories')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('parent_document_id')->references('id')->on('documents')->onDelete('set null');

            $table->index(['category_id', 'status']);
            $table->index(['company_id', 'department_id']);
            $table->index(['document_type']);
            $table->index(['access_level']);
            $table->index(['uploaded_by']);
        });

        Schema::create('document_shares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('shared_with_user_id')->nullable();
            $table->unsignedBigInteger('shared_with_department_id')->nullable();
            $table->enum('share_type', ['user', 'department'])->default('user');
            $table->enum('permission', ['view', 'download', 'edit'])->default('view');
            $table->timestamp('expires_at')->nullable();
            $table->unsignedBigInteger('shared_by');
            $table->timestamps();

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('shared_with_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shared_with_department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('shared_by')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['document_id', 'shared_with_user_id']);
            $table->index(['document_id', 'share_type']);
        });

        Schema::create('document_versions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->string('version');
            $table->string('file_name');
            $table->string('file_path');
            $table->integer('file_size');
            $table->text('change_notes')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->index(['document_id', 'version']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_versions');
        Schema::dropIfExists('document_shares');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('document_categories');
    }
};
