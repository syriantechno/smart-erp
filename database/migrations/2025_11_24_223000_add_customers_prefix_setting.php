<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting\PrefixSetting;

return new class extends Migration
{
    public function up(): void
    {
        // Create prefix setting for customers if it doesn't exist
        if (!PrefixSetting::where('document_type', 'customers')->exists()) {
            PrefixSetting::create([
                'document_type' => 'customers',
                'prefix' => 'CUST',
                'start_number' => 1,
                'current_number' => 0,
                'is_active' => true,
            ]);
        }
    }

    public function down(): void
    {
        // Remove customers prefix setting
        PrefixSetting::where('document_type', 'customers')->delete();
    }
};
