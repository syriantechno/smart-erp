<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->unsignedTinyInteger('month');
            $table->unsignedSmallInteger('year');
            
            // Salary Base
            $table->decimal('basic_salary', 12, 2);
            $table->unsignedTinyInteger('working_days')->default(22);
            $table->unsignedTinyInteger('actual_working_days')->default(0);
            $table->unsignedTinyInteger('working_hours_per_day')->default(8);
            $table->decimal('hourly_rate', 10, 2)->default(0);
            
            // Overtime
            $table->decimal('overtime_hours', 8, 2)->default(0);
            $table->decimal('overtime_multiplier', 4, 2)->default(1.5);
            $table->decimal('overtime_amount', 12, 2)->default(0);
            
            // Weekend Overtime
            $table->decimal('weekend_overtime_hours', 8, 2)->default(0);
            $table->decimal('weekend_overtime_multiplier', 4, 2)->default(2);
            $table->decimal('weekend_overtime_amount', 12, 2)->default(0);
            
            $table->decimal('total_overtime_amount', 12, 2)->default(0);
            
            // Deductions
            $table->decimal('deductions', 12, 2)->default(0);
            $table->json('deduction_details')->nullable();
            
            // Bonuses
            $table->decimal('bonuses', 12, 2)->default(0);
            $table->json('bonus_details')->nullable();
            
            // Attendance Deductions
            $table->unsignedTinyInteger('absent_days')->default(0);
            $table->decimal('absent_deduction', 12, 2)->default(0);
            $table->unsignedSmallInteger('late_minutes')->default(0);
            $table->decimal('late_deduction', 12, 2)->default(0);
            $table->unsignedTinyInteger('half_days')->default(0);
            $table->decimal('half_day_deduction', 12, 2)->default(0);
            
            // Totals
            $table->decimal('gross_salary', 12, 2)->default(0);
            $table->decimal('net_salary', 12, 2)->default(0);
            
            // Status & Payment
            $table->enum('status', ['pending', 'approved', 'paid', 'cancelled'])->default('pending');
            $table->date('payment_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->text('notes')->nullable();
            
            // Audit
            $table->foreignId('generated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->unique(['employee_id', 'month', 'year']);
            $table->index(['year', 'month']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
