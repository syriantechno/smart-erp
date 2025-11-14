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
        // Drop old table if it exists
        Schema::dropIfExists('user_mail_accounts');

        Schema::create('user_mail_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('label')->default('Default Mail Account');

            // Outgoing (SMTP)
            $table->string('smtp_host');
            $table->unsignedSmallInteger('smtp_port')->default(587);
            $table->string('smtp_encryption')->nullable(); // ssl / tls / null
            $table->string('smtp_username');
            $table->string('smtp_password'); // store encrypted/secured

            // Incoming (IMAP / POP3)
            $table->enum('incoming_protocol', ['imap', 'pop3'])->default('imap');
            $table->string('incoming_host')->nullable();
            $table->unsignedSmallInteger('incoming_port')->nullable();
            $table->string('incoming_encryption')->nullable();
            $table->string('incoming_username')->nullable();
            $table->string('incoming_password')->nullable();

            // From information
            $table->string('from_name')->nullable();
            $table->string('from_email')->nullable();

            // State
            $table->boolean('is_default')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_successful_connection_at')->nullable();
            $table->unsignedTinyInteger('failed_attempts')->default(0);

            $table->timestamps();

            $table->index(['user_id', 'is_default']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_mail_accounts');
    }
};
