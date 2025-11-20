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
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->foreignId('approval_template_id')
                ->nullable()
                ->after('warehouse_id')
                ->constrained('approval_templates')
                ->nullOnDelete();

            $table->foreignId('approval_request_id')
                ->nullable()
                ->after('approval_template_id')
                ->constrained('approval_requests')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_requests', 'approval_request_id')) {
                $table->dropConstrainedForeignId('approval_request_id');
            }

            if (Schema::hasColumn('purchase_requests', 'approval_template_id')) {
                $table->dropConstrainedForeignId('approval_template_id');
            }
        });
    }
};
