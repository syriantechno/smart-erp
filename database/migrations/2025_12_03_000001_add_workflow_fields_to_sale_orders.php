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
        Schema::table('sale_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('expected_delivery_date');
            $table->unsignedBigInteger('project_id')->nullable()->after('company_id');
            $table->string('priority')->default('normal')->after('project_id');
            $table->unsignedBigInteger('approval_template_id')->nullable()->after('total_amount');
            $table->unsignedBigInteger('approval_request_id')->nullable()->after('approval_template_id');

            $table->index('company_id');
            $table->index('project_id');
            $table->index('approval_template_id');
            $table->index('approval_request_id');

            $table->foreign('company_id')->references('id')->on('companies')->nullOnDelete();
            $table->foreign('project_id')->references('id')->on('projects')->nullOnDelete();
            $table->foreign('approval_template_id')->references('id')->on('approval_templates')->nullOnDelete();
            $table->foreign('approval_request_id')->references('id')->on('approval_requests')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_orders', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['project_id']);
            $table->dropForeign(['approval_template_id']);
            $table->dropForeign(['approval_request_id']);

            $table->dropColumn(['company_id', 'project_id', 'priority', 'approval_template_id', 'approval_request_id']);
        });
    }
};
