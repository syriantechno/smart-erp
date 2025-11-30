<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add all missing payroll columns for advanced payroll calculation
     */
    public function up(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            // Add code column
            if (!Schema::hasColumn('payrolls', 'code')) {
                $table->string('code')->nullable()->after('id');
            }
            
            // Working days columns
            if (!Schema::hasColumn('payrolls', 'working_days')) {
                $table->integer('working_days')->default(22)->after('basic_salary');
            }
            if (!Schema::hasColumn('payrolls', 'actual_working_days')) {
                $table->decimal('actual_working_days', 5, 2)->default(0)->after('working_days');
            }
            if (!Schema::hasColumn('payrolls', 'working_hours_per_day')) {
                $table->integer('working_hours_per_day')->default(8)->after('actual_working_days');
            }
            if (!Schema::hasColumn('payrolls', 'hourly_rate')) {
                $table->decimal('hourly_rate', 10, 2)->default(0)->after('working_hours_per_day');
            }
            if (!Schema::hasColumn('payrolls', 'earned_salary')) {
                $table->decimal('earned_salary', 10, 2)->default(0)->after('hourly_rate');
            }
            
            // Overtime columns
            if (!Schema::hasColumn('payrolls', 'overtime_hours')) {
                $table->decimal('overtime_hours', 8, 2)->default(0)->after('earned_salary');
            }
            if (!Schema::hasColumn('payrolls', 'overtime_multiplier')) {
                $table->decimal('overtime_multiplier', 4, 2)->default(1.5)->after('overtime_hours');
            }
            if (!Schema::hasColumn('payrolls', 'overtime_amount')) {
                $table->decimal('overtime_amount', 10, 2)->default(0)->after('overtime_multiplier');
            }
            if (!Schema::hasColumn('payrolls', 'weekend_overtime_hours')) {
                $table->decimal('weekend_overtime_hours', 8, 2)->default(0)->after('overtime_amount');
            }
            if (!Schema::hasColumn('payrolls', 'weekend_overtime_multiplier')) {
                $table->decimal('weekend_overtime_multiplier', 4, 2)->default(2)->after('weekend_overtime_hours');
            }
            if (!Schema::hasColumn('payrolls', 'weekend_overtime_amount')) {
                $table->decimal('weekend_overtime_amount', 10, 2)->default(0)->after('weekend_overtime_multiplier');
            }
            if (!Schema::hasColumn('payrolls', 'total_overtime_amount')) {
                $table->decimal('total_overtime_amount', 10, 2)->default(0)->after('weekend_overtime_amount');
            }
            
            // Absence and late columns
            if (!Schema::hasColumn('payrolls', 'absent_days')) {
                $table->integer('absent_days')->default(0)->after('total_overtime_amount');
            }
            if (!Schema::hasColumn('payrolls', 'absent_deduction')) {
                $table->decimal('absent_deduction', 10, 2)->default(0)->after('absent_days');
            }
            if (!Schema::hasColumn('payrolls', 'half_days')) {
                $table->integer('half_days')->default(0)->after('absent_deduction');
            }
            if (!Schema::hasColumn('payrolls', 'half_day_deduction')) {
                $table->decimal('half_day_deduction', 10, 2)->default(0)->after('half_days');
            }
            if (!Schema::hasColumn('payrolls', 'late_minutes')) {
                $table->integer('late_minutes')->default(0)->after('half_day_deduction');
            }
            if (!Schema::hasColumn('payrolls', 'late_deduction')) {
                $table->decimal('late_deduction', 10, 2)->default(0)->after('late_minutes');
            }
            
            // Unpaid leave columns
            if (!Schema::hasColumn('payrolls', 'unpaid_leave_days')) {
                $table->integer('unpaid_leave_days')->default(0)->after('late_deduction');
            }
            if (!Schema::hasColumn('payrolls', 'unpaid_leave_deduction')) {
                $table->decimal('unpaid_leave_deduction', 10, 2)->default(0)->after('unpaid_leave_days');
            }
            
            // Deduction and bonus details (JSON)
            if (!Schema::hasColumn('payrolls', 'deduction_details')) {
                $table->json('deduction_details')->nullable()->after('deductions');
            }
            if (!Schema::hasColumn('payrolls', 'bonus_details')) {
                $table->json('bonus_details')->nullable()->after('deduction_details');
            }
            
            // Gross salary
            if (!Schema::hasColumn('payrolls', 'gross_salary')) {
                $table->decimal('gross_salary', 10, 2)->default(0)->after('bonus_details');
            }
            
            // Bonuses column (if not exists)
            if (!Schema::hasColumn('payrolls', 'bonuses')) {
                $table->decimal('bonuses', 10, 2)->default(0)->after('gross_salary');
            }
            
            // Payment and approval columns
            if (!Schema::hasColumn('payrolls', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('payment_date');
            }
            if (!Schema::hasColumn('payrolls', 'notes')) {
                $table->text('notes')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('payrolls', 'generated_by')) {
                $table->unsignedBigInteger('generated_by')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('payrolls', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable()->after('generated_by');
            }
            if (!Schema::hasColumn('payrolls', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $columns = [
                'code', 'working_days', 'actual_working_days', 'working_hours_per_day',
                'hourly_rate', 'earned_salary', 'overtime_hours', 'overtime_multiplier',
                'overtime_amount', 'weekend_overtime_hours', 'weekend_overtime_multiplier',
                'weekend_overtime_amount', 'total_overtime_amount', 'absent_days',
                'absent_deduction', 'half_days', 'half_day_deduction', 'late_minutes',
                'late_deduction', 'unpaid_leave_days', 'unpaid_leave_deduction',
                'deduction_details', 'bonus_details', 'gross_salary', 'bonuses',
                'payment_method', 'notes', 'generated_by', 'approved_by', 'approved_at'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('payrolls', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
