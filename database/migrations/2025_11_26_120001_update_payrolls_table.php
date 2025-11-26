<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('payrolls', 'code')) {
                $table->string('code')->nullable()->after('id');
            }
            if (!Schema::hasColumn('payrolls', 'working_days')) {
                $table->unsignedTinyInteger('working_days')->default(22)->after('basic_salary');
            }
            if (!Schema::hasColumn('payrolls', 'actual_working_days')) {
                $table->unsignedTinyInteger('actual_working_days')->default(0)->after('working_days');
            }
            if (!Schema::hasColumn('payrolls', 'working_hours_per_day')) {
                $table->unsignedTinyInteger('working_hours_per_day')->default(8)->after('actual_working_days');
            }
            if (!Schema::hasColumn('payrolls', 'hourly_rate')) {
                $table->decimal('hourly_rate', 10, 2)->default(0)->after('working_hours_per_day');
            }
            if (!Schema::hasColumn('payrolls', 'overtime_hours')) {
                $table->decimal('overtime_hours', 8, 2)->default(0)->after('hourly_rate');
            }
            if (!Schema::hasColumn('payrolls', 'overtime_multiplier')) {
                $table->decimal('overtime_multiplier', 4, 2)->default(1.5)->after('overtime_hours');
            }
            if (!Schema::hasColumn('payrolls', 'overtime_amount')) {
                $table->decimal('overtime_amount', 12, 2)->default(0)->after('overtime_multiplier');
            }
            if (!Schema::hasColumn('payrolls', 'weekend_overtime_hours')) {
                $table->decimal('weekend_overtime_hours', 8, 2)->default(0)->after('overtime_amount');
            }
            if (!Schema::hasColumn('payrolls', 'weekend_overtime_multiplier')) {
                $table->decimal('weekend_overtime_multiplier', 4, 2)->default(2)->after('weekend_overtime_hours');
            }
            if (!Schema::hasColumn('payrolls', 'weekend_overtime_amount')) {
                $table->decimal('weekend_overtime_amount', 12, 2)->default(0)->after('weekend_overtime_multiplier');
            }
            if (!Schema::hasColumn('payrolls', 'total_overtime_amount')) {
                $table->decimal('total_overtime_amount', 12, 2)->default(0)->after('weekend_overtime_amount');
            }
            if (!Schema::hasColumn('payrolls', 'deduction_details')) {
                $table->json('deduction_details')->nullable()->after('deductions');
            }
            if (!Schema::hasColumn('payrolls', 'bonuses')) {
                $table->decimal('bonuses', 12, 2)->default(0)->after('deduction_details');
            }
            if (!Schema::hasColumn('payrolls', 'bonus_details')) {
                $table->json('bonus_details')->nullable()->after('bonuses');
            }
            if (!Schema::hasColumn('payrolls', 'absent_days')) {
                $table->unsignedTinyInteger('absent_days')->default(0)->after('bonus_details');
            }
            if (!Schema::hasColumn('payrolls', 'absent_deduction')) {
                $table->decimal('absent_deduction', 12, 2)->default(0)->after('absent_days');
            }
            if (!Schema::hasColumn('payrolls', 'late_minutes')) {
                $table->unsignedSmallInteger('late_minutes')->default(0)->after('absent_deduction');
            }
            if (!Schema::hasColumn('payrolls', 'late_deduction')) {
                $table->decimal('late_deduction', 12, 2)->default(0)->after('late_minutes');
            }
            if (!Schema::hasColumn('payrolls', 'half_days')) {
                $table->unsignedTinyInteger('half_days')->default(0)->after('late_deduction');
            }
            if (!Schema::hasColumn('payrolls', 'half_day_deduction')) {
                $table->decimal('half_day_deduction', 12, 2)->default(0)->after('half_days');
            }
            if (!Schema::hasColumn('payrolls', 'gross_salary')) {
                $table->decimal('gross_salary', 12, 2)->default(0)->after('half_day_deduction');
            }
            if (!Schema::hasColumn('payrolls', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('payment_date');
            }
            if (!Schema::hasColumn('payrolls', 'notes')) {
                $table->text('notes')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('payrolls', 'generated_by')) {
                $table->foreignId('generated_by')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('payrolls', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->after('generated_by');
            }
            if (!Schema::hasColumn('payrolls', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $columns = [
                'code', 'working_days', 'actual_working_days', 'working_hours_per_day',
                'hourly_rate', 'overtime_hours', 'overtime_multiplier', 'overtime_amount',
                'weekend_overtime_hours', 'weekend_overtime_multiplier', 'weekend_overtime_amount',
                'total_overtime_amount', 'deduction_details', 'bonuses', 'bonus_details',
                'absent_days', 'absent_deduction', 'late_minutes', 'late_deduction',
                'half_days', 'half_day_deduction', 'gross_salary', 'payment_method',
                'notes', 'generated_by', 'approved_by', 'approved_at'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('payrolls', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
