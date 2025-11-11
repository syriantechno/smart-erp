<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add foreign key to departments table
        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('manager_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('departments')->onDelete('set null');
        });

        // Add foreign key to positions table
        Schema::table('positions', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['manager_id']);
            $table->dropForeign(['parent_id']);
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
        });
    }
};
