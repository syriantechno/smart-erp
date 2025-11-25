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
        // جدول قوالب التصنيع (Bill of Materials Templates)
        Schema::create('bom_templates', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // BOM-001
            $table->string('name'); // باب خشبي
            $table->text('description')->nullable();
            $table->foreignId('output_material_id')->constrained('materials')->comment('المنتج النهائي'); // الباب
            $table->integer('output_quantity')->default(1)->comment('كمية المخرجات لكل دورة');
            $table->string('output_unit')->default('pcs');
            $table->decimal('labor_cost', 12, 2)->default(0)->comment('تكلفة العمالة');
            $table->decimal('overhead_cost', 12, 2)->default(0)->comment('تكاليف إضافية');
            $table->integer('estimated_time_minutes')->default(0)->comment('الوقت المقدر بالدقائق');
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->foreignId('company_id')->nullable()->constrained('companies');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });

        // جدول مكونات قالب التصنيع (BOM Components)
        Schema::create('bom_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bom_template_id')->constrained('bom_templates')->onDelete('cascade');
            $table->foreignId('material_id')->constrained('materials')->comment('المادة الخام');
            $table->decimal('quantity', 12, 4)->comment('الكمية المطلوبة');
            $table->string('unit')->default('pcs');
            $table->decimal('waste_percentage', 5, 2)->default(0)->comment('نسبة الهدر المتوقعة');
            $table->text('notes')->nullable();
            $table->integer('sequence')->default(0)->comment('ترتيب المكون');
            $table->timestamps();
        });

        // جدول أوامر التصنيع المحسن
        Schema::create('manufacturing_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // MO-2025-0001
            $table->foreignId('bom_template_id')->constrained('bom_templates');
            $table->integer('quantity')->comment('كمية المنتج المطلوب تصنيعها');
            $table->integer('completed_quantity')->default(0);
            $table->date('planned_start_date');
            $table->date('planned_end_date')->nullable();
            $table->dateTime('actual_start_date')->nullable();
            $table->dateTime('actual_end_date')->nullable();
            $table->enum('status', ['draft', 'confirmed', 'in_progress', 'completed', 'cancelled'])->default('draft');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->foreignId('source_warehouse_id')->nullable()->constrained('warehouses')->comment('مستودع المواد الخام');
            $table->foreignId('destination_warehouse_id')->nullable()->constrained('warehouses')->comment('مستودع المنتجات');
            $table->decimal('estimated_cost', 12, 2)->default(0);
            $table->decimal('actual_cost', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('company_id')->nullable()->constrained('companies');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        // جدول استهلاك المواد في أمر التصنيع
        Schema::create('manufacturing_order_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manufacturing_order_id')->constrained('manufacturing_orders')->onDelete('cascade');
            $table->foreignId('material_id')->constrained('materials');
            $table->decimal('required_quantity', 12, 4)->comment('الكمية المطلوبة');
            $table->decimal('consumed_quantity', 12, 4)->default(0)->comment('الكمية المستهلكة فعلياً');
            $table->decimal('wasted_quantity', 12, 4)->default(0)->comment('الكمية المهدورة');
            $table->decimal('unit_cost', 12, 2)->default(0);
            $table->decimal('total_cost', 12, 2)->default(0);
            $table->enum('status', ['pending', 'reserved', 'consumed', 'returned'])->default('pending');
            $table->timestamps();
        });

        // جدول مخرجات التصنيع
        Schema::create('manufacturing_outputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manufacturing_order_id')->constrained('manufacturing_orders')->onDelete('cascade');
            $table->foreignId('material_id')->constrained('materials')->comment('المنتج النهائي');
            $table->integer('quantity')->comment('الكمية المنتجة');
            $table->integer('good_quantity')->default(0)->comment('الكمية الجيدة');
            $table->integer('defect_quantity')->default(0)->comment('الكمية المعيبة');
            $table->decimal('unit_cost', 12, 2)->default(0)->comment('تكلفة الوحدة');
            $table->decimal('total_cost', 12, 2)->default(0);
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses');
            $table->dateTime('produced_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufacturing_outputs');
        Schema::dropIfExists('manufacturing_order_materials');
        Schema::dropIfExists('manufacturing_orders');
        Schema::dropIfExists('bom_components');
        Schema::dropIfExists('bom_templates');
    }
};
