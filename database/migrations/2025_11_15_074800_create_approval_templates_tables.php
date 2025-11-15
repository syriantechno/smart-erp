<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('entity_type')->nullable();
            $table->string('action_type')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['entity_type', 'action_type', 'is_active']);
        });

        Schema::create('approval_template_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('approval_template_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('step_order');
            $table->foreignId('approver_user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('approval_requests', function (Blueprint $table) {
            $table->foreignId('approval_template_id')
                ->nullable()
                ->after('company_id')
                ->constrained('approval_templates')
                ->nullOnDelete();

            $table->nullableMorphs('approvable');
        });
    }

    public function down(): void
    {
        Schema::table('approval_requests', function (Blueprint $table) {
            if (Schema::hasColumn('approval_requests', 'approval_template_id')) {
                $table->dropConstrainedForeignId('approval_template_id');
            }

            if (Schema::hasColumn('approval_requests', 'approvable_id') && Schema::hasColumn('approval_requests', 'approvable_type')) {
                $table->dropMorphs('approvable');
            }
        });

        Schema::dropIfExists('approval_template_steps');
        Schema::dropIfExists('approval_templates');
    }
};
