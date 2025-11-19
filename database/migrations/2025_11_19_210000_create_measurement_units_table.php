<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('measurement_units', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('symbol')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('measurement_units')->insert([
            ['code' => 'piece', 'name' => 'Piece', 'symbol' => 'pc', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'kg', 'name' => 'Kilogram', 'symbol' => 'kg', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'liter', 'name' => 'Liter', 'symbol' => 'L', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'meter', 'name' => 'Meter', 'symbol' => 'm', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measurement_units');
    }
};
