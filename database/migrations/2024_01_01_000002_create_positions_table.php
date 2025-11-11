<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('job_description')->nullable();
            $table->text('requirements')->nullable();
            
            // Foreign key - will be added later in a separate migration
            $table->unsignedBigInteger('department_id');
            
            // Salary information
            $table->decimal('salary_range_min', 10, 2)->nullable();
            $table->decimal('salary_range_max', 10, 2)->nullable();
            $table->string('employment_type')->default('full-time');
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('positions');
    }
};
