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
        Schema::create('prefix_settings', function (Blueprint $table) {
            $table->id();
            $table->string('document_type')->unique();
            $table->string('prefix', 10);
            $table->integer('padding')->default(4);
            $table->integer('start_number')->default(1);
            $table->integer('current_number')->default(1);
            $table->boolean('include_year')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prefix_settings');
    }
};
