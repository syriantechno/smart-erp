<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('name');
            $table->string('code')->nullable();
            $table->decimal('rate', 8, 3); // e.g. 15.000 = 15%
            $table->enum('type', ['value_added', 'withholding', 'other'])->default('value_added');
            $table->unsignedBigInteger('sales_account_id')->nullable();
            $table->unsignedBigInteger('purchase_account_id')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('sales_account_id')->references('id')->on('accountings')->onDelete('restrict');
            $table->foreign('purchase_account_id')->references('id')->on('accountings')->onDelete('restrict');
            $table->index(['company_id', 'type', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taxes');
    }
};
