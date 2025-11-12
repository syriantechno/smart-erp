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
        // جدول أوامر الإنتاج
        Schema::create('production_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_cost', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->enum('status', ['draft', 'confirmed', 'in_progress', 'completed', 'cancelled'])->default('draft');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('notes')->nullable();
            $table->json('specifications')->nullable(); // متطلبات خاصة للمنتج
            $table->timestamps();
        });

        // جدول مراحل الإنتاج
        Schema::create('production_stages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('sequence')->default(1); // ترتيب المرحلة
            $table->integer('estimated_hours')->default(0);
            $table->decimal('stage_cost', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // جدول تفاصيل أوامر الإنتاج
        Schema::create('production_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_order_id')->constrained('production_orders')->onDelete('cascade');
            $table->foreignId('production_stage_id')->constrained('production_stages');
            $table->integer('quantity');
            $table->decimal('unit_cost', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('completed_quantity')->default(0);
            $table->enum('status', ['pending', 'in_progress', 'completed', 'skipped'])->default('pending');
            $table->text('notes')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users'); // الموظف المسؤول
            $table->timestamps();
        });

        // جدول المواد المستخدمة في الإنتاج
        Schema::create('production_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_order_id')->constrained('production_orders')->onDelete('cascade');
            $table->string('material_name');
            $table->string('material_code')->nullable();
            $table->decimal('required_quantity', 10, 2);
            $table->decimal('used_quantity', 10, 2)->default(0);
            $table->decimal('unit_cost', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->enum('status', ['pending', 'allocated', 'used', 'returned'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // جدول آلات الإنتاج
        Schema::create('production_machines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('model')->nullable();
            $table->text('description')->nullable();
            $table->enum('type', ['manual', 'semi_automatic', 'automatic', 'cnc'])->default('manual');
            $table->enum('status', ['active', 'maintenance', 'out_of_order', 'retired'])->default('active');
            $table->decimal('hourly_rate', 8, 2)->default(0); // تكلفة الساعة
            $table->integer('capacity_per_hour')->default(0); // القدرة الإنتاجية
            $table->json('specifications')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('last_maintenance')->nullable();
            $table->date('next_maintenance')->nullable();
            $table->timestamps();
        });

        // جدول جدولة الآلات
        Schema::create('machine_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained('production_machines');
            $table->foreignId('production_order_id')->constrained('production_orders');
            $table->dateTime('scheduled_start');
            $table->dateTime('scheduled_end');
            $table->dateTime('actual_start')->nullable();
            $table->dateTime('actual_end')->nullable();
            $table->integer('planned_hours');
            $table->integer('actual_hours')->default(0);
            $table->enum('status', ['scheduled', 'running', 'completed', 'cancelled'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // جدول الجودة والفحص
        Schema::create('quality_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_order_id')->constrained('production_orders');
            $table->string('check_name');
            $table->text('description')->nullable();
            $table->enum('check_type', ['incoming', 'in_process', 'final', 'random'])->default('final');
            $table->enum('status', ['pending', 'passed', 'failed', 'rework_required'])->default('pending');
            $table->foreignId('checked_by')->constrained('users');
            $table->dateTime('checked_at');
            $table->integer('sample_size')->nullable();
            $table->integer('defect_count')->default(0);
            $table->text('findings')->nullable();
            $table->text('recommendations')->nullable();
            $table->json('measurements')->nullable(); // قياسات محددة
            $table->timestamps();
        });

        // جدول المخازن الإنتاجية
        Schema::create('production_warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->enum('type', ['raw_materials', 'work_in_progress', 'finished_goods', 'scrap'])->default('raw_materials');
            $table->boolean('is_active')->default(true);
            $table->decimal('capacity', 10, 2)->nullable(); // السعة بالمتر المكعب
            $table->foreignId('manager_id')->nullable()->constrained('users');
            $table->timestamps();
        });

        // جدول حركة المخزون الإنتاجي
        Schema::create('production_inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id')->constrained('production_warehouses');
            $table->foreignId('production_order_id')->nullable()->constrained('production_orders');
            $table->string('item_name');
            $table->string('item_code')->nullable();
            $table->enum('movement_type', ['in', 'out', 'transfer', 'adjustment'])->default('in');
            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_cost', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->enum('reason', ['production_input', 'production_output', 'scrap', 'adjustment', 'transfer'])->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });

        // جدول تقارير الإنتاج
        Schema::create('production_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique();
            $table->enum('report_type', ['daily', 'weekly', 'monthly', 'custom'])->default('daily');
            $table->date('report_date');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_orders')->default(0);
            $table->integer('completed_orders')->default(0);
            $table->integer('in_progress_orders')->default(0);
            $table->decimal('total_production_cost', 12, 2)->default(0);
            $table->decimal('total_material_cost', 12, 2)->default(0);
            $table->decimal('total_labor_cost', 12, 2)->default(0);
            $table->decimal('total_machine_cost', 12, 2)->default(0);
            $table->integer('total_defects')->default(0);
            $table->decimal('efficiency_percentage', 5, 2)->default(0); // كفاءة الإنتاج
            $table->text('summary')->nullable();
            $table->json('details')->nullable();
            $table->foreignId('generated_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_reports');
        Schema::dropIfExists('production_inventory_movements');
        Schema::dropIfExists('production_warehouses');
        Schema::dropIfExists('quality_checks');
        Schema::dropIfExists('machine_schedules');
        Schema::dropIfExists('production_machines');
        Schema::dropIfExists('production_materials');
        Schema::dropIfExists('production_order_details');
        Schema::dropIfExists('production_stages');
        Schema::dropIfExists('production_orders');
        Schema::dropIfExists('manufacturings');
    }
};
