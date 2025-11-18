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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('translated_name')->nullable()->after('last_name');
            $table->string('iqama_position')->nullable()->after('position');
            $table->boolean('is_company_housing')->default(false)->after('address');
            $table->string('housing_room_number')->nullable()->after('is_company_housing');
            $table->string('housing_unit_number')->nullable()->after('housing_room_number');
            $table->boolean('has_system_access')->default(false)->after('user_id');
            $table->string('system_password')->nullable()->after('has_system_access');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'translated_name',
                'iqama_position',
                'is_company_housing',
                'housing_room_number',
                'housing_unit_number',
                'has_system_access',
                'system_password',
            ]);
        });
    }
};
