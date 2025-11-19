<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crm_activity_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained('crm_activities')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('comment');
            $table->json('mentions')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crm_activity_comments');
    }
};
