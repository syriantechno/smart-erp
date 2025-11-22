<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->enum('method', ['cash', 'bank'])->default('cash');
            $table->unsignedBigInteger('cash_box_id')->nullable();
            $table->unsignedBigInteger('bank_account_id')->nullable();
            $table->unsignedBigInteger('account_id'); // counterparty account
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->date('voucher_date');
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->enum('status', ['draft', 'posted', 'cancelled'])->default('draft');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('cash_box_id')->references('id')->on('cash_boxes')->onDelete('set null');
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('set null');
            $table->foreign('account_id')->references('id')->on('accountings')->onDelete('restrict');
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('set null');
            $table->index(['company_id', 'method', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_vouchers');
    }
};
