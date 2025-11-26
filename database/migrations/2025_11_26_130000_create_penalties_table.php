<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penalties', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            
            $table->enum('type', ['written', 'financial'])->default('written');
            $table->string('category')->default('other'); // late, absent, misconduct, violation, other
            $table->string('title');
            $table->text('description')->nullable();
            
            $table->decimal('amount', 12, 2)->default(0); // for financial penalties
            
            $table->date('penalty_date');
            $table->date('effective_from')->nullable();
            $table->date('effective_to')->nullable(); // for written warnings validity
            
            $table->boolean('deduct_from_salary')->default(false);
            $table->boolean('deducted')->default(false);
            $table->foreignId('deducted_in_payroll_id')->nullable()->constrained('payrolls')->nullOnDelete();
            
            $table->enum('severity', ['minor', 'moderate', 'major', 'severe'])->default('minor');
            $table->enum('status', ['pending', 'approved', 'rejected', 'applied'])->default('pending');
            
            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable();
            
            $table->timestamps();
            
            $table->index(['employee_id', 'status']);
            $table->index(['type', 'deducted']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penalties');
    }
};
