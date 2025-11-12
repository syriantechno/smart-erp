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
        Schema::create('accountings', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['asset', 'liability', 'equity', 'income', 'expense'])->default('asset');
            $table->enum('category', ['current_asset', 'fixed_asset', 'current_liability', 'long_term_liability', 'owner_equity', 'retained_earnings', 'operating_income', 'other_income', 'cost_of_goods_sold', 'operating_expense', 'other_expense'])->nullable();
            $table->unsignedBigInteger('parent_id')->nullable(); // For hierarchical accounts
            $table->boolean('is_active')->default(true);
            $table->integer('level')->default(1); // Account level in hierarchy
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('accountings')->onDelete('cascade');
            $table->index(['type', 'category']);
            $table->index('is_active');
        });

        // Create journal entries table
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->date('entry_date');
            $table->text('description');
            $table->enum('status', ['draft', 'posted', 'voided'])->default('draft');
            $table->unsignedBigInteger('created_by');
            $table->decimal('total_debit', 15, 2)->default(0);
            $table->decimal('total_credit', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->index(['entry_date', 'status']);
        });

        // Create journal entry lines table
        Schema::create('journal_entry_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_entry_id');
            $table->unsignedBigInteger('account_id');
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->text('memo')->nullable();
            $table->timestamps();

            $table->foreign('journal_entry_id')->references('id')->on('journal_entries')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accountings')->onDelete('cascade');
            $table->index(['journal_entry_id', 'account_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_entry_lines');
        Schema::dropIfExists('journal_entries');
        Schema::dropIfExists('accountings');
    }
};
