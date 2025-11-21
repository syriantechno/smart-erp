<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            if (!Schema::hasColumn('materials', 'sku')) {
                $table->string('sku')->nullable()->unique()->after('name');
            }

            if (!Schema::hasColumn('materials', 'barcode')) {
                $table->string('barcode')->nullable()->unique()->after('sku');
            }
        });
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            if (Schema::hasColumn('materials', 'barcode')) {
                $table->dropUnique('materials_barcode_unique');
                $table->dropColumn('barcode');
            }

            if (Schema::hasColumn('materials', 'sku')) {
                $table->dropUnique('materials_sku_unique');
                $table->dropColumn('sku');
            }
        });
    }
};
