<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignId('approval_template_id')
                ->nullable()
                ->after('status')
                ->constrained('approval_templates')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'approval_template_id')) {
                $table->dropConstrainedForeignId('approval_template_id');
            }
        });
    }
};

