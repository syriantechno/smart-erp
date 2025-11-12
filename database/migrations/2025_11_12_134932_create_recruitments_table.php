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
        Schema::create('recruitments', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('candidate_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->date('application_date');
            $table->string('position');
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('company_id');
            $table->text('experience')->nullable();
            $table->string('education_level')->nullable();
            $table->text('skills')->nullable();
            $table->enum('status', ['applied', 'screening', 'interview', 'offered', 'hired', 'rejected'])->default('applied');
            $table->text('notes')->nullable();
            $table->date('interview_date')->nullable();
            $table->string('interviewer')->nullable();
            $table->decimal('expected_salary', 10, 2)->nullable();
            $table->decimal('offered_salary', 10, 2)->nullable();
            $table->date('joining_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('position_id')->references('id')->on('positions')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitments');
    }
};
