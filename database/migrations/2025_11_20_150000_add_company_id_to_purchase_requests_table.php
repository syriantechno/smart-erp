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
        if (! Schema::hasColumn('purchase_requests', 'company_id')) {
            Schema::table('purchase_requests', function (Blueprint $table) {
                $table->foreignId('company_id')
                    ->nullable()
                    ->after('requested_by')
                    ->constrained('companies')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('purchase_requests', 'company_id')) {
            Schema::table('purchase_requests', function (Blueprint $table) {
                $table->dropConstrainedForeignId('company_id');
            });
        }
    }
};
