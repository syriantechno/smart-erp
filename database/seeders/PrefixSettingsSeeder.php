<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PrefixSetting;

class PrefixSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentTypes = [
            ['document_type' => 'department', 'prefix' => 'DEPT'],
            ['document_type' => 'position', 'prefix' => 'POS'],
            ['document_type' => 'employees', 'prefix' => 'EMP'],
            ['document_type' => 'invoices', 'prefix' => 'INV'],
            ['document_type' => 'sales_orders', 'prefix' => 'SO'],
            ['document_type' => 'purchase_orders', 'prefix' => 'PO'],
            ['document_type' => 'delivery_notes', 'prefix' => 'DN'],
            ['document_type' => 'estimates', 'prefix' => 'EST'],
            ['document_type' => 'quotations', 'prefix' => 'QUO'],
            ['document_type' => 'receipts', 'prefix' => 'REC'],
        ];

        foreach ($documentTypes as $type) {
            PrefixSetting::create([
                'document_type' => $type['document_type'],
                'prefix' => $type['prefix'],
                'padding' => 4,
                'start_number' => 1,
                'current_number' => 1,
                'include_year' => false,
                'is_active' => true,
            ]);
        }
    }
}
