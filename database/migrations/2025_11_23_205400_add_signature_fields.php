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
        Schema::table('users', function (Blueprint $table) {
            $table->string('signature_path')->nullable()->after('password');
        });

        Schema::table('approval_logs', function (Blueprint $table) {
            $table->string('signature_path')->nullable()->after('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('approval_logs', function (Blueprint $table) {
            $table->dropColumn('signature_path');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('signature_path');
        });
    }
};
