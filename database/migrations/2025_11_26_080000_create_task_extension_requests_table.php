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
        Schema::create('task_extension_requests', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('requested_by'); // الموظف الذي طلب التمديد
            $table->unsignedBigInteger('reviewed_by')->nullable(); // المدير الذي راجع الطلب
            $table->date('current_due_date'); // تاريخ الاستحقاق الحالي
            $table->date('requested_due_date'); // تاريخ الاستحقاق المطلوب
            $table->integer('extension_days'); // عدد أيام التمديد
            $table->text('reason'); // سبب طلب التمديد
            $table->text('review_notes')->nullable(); // ملاحظات المراجع
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');

            $table->index(['task_id', 'status']);
            $table->index('requested_by');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_extension_requests');
    }
};
