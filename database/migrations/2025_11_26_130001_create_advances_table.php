<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advances', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            
            $table->enum('type', ['salary_advance', 'loan'])->default('salary_advance');
            $table->decimal('amount', 12, 2);
            $table->text('reason')->nullable();
            
            $table->date('request_date');
            $table->date('approval_date')->nullable();
            $table->date('disbursement_date')->nullable();
            
            $table->unsignedSmallInteger('installments')->default(1); // number of monthly installments
            $table->decimal('installment_amount', 12, 2)->default(0);
            $table->unsignedSmallInteger('paid_installments')->default(0);
            $table->decimal('remaining_amount', 12, 2)->default(0);
            
            $table->date('start_deduction_date')->nullable(); // when to start deducting
            
            $table->enum('status', ['pending', 'approved', 'rejected', 'disbursed', 'completed', 'cancelled'])->default('pending');
            
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            $table->index(['employee_id', 'status']);
            $table->index('status');
        });

        Schema::create('advance_deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advance_id')->constrained('advances')->onDelete('cascade');
            $table->foreignId('payroll_id')->nullable()->constrained('payrolls')->nullOnDelete();
            $table->decimal('amount', 12, 2);
            $table->date('deduction_date');
            $table->unsignedSmallInteger('installment_number');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advance_deductions');
        Schema::dropIfExists('advances');
    }
};
