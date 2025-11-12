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
            ['document_type' => 'shifts', 'prefix' => 'SHIFT'],
            ['document_type' => 'tasks', 'prefix' => 'TASK'],
            ['document_type' => 'materials', 'prefix' => 'MAT'],
            ['document_type' => 'warehouses', 'prefix' => 'WH'],
            ['document_type' => 'categories', 'prefix' => 'CAT'],
            ['document_type' => 'purchase_requests', 'prefix' => 'PR'],
            ['document_type' => 'electronic_mails', 'prefix' => 'MAIL'],
            ['document_type' => 'approval_requests', 'prefix' => 'APR'],
            ['document_type' => 'messages', 'prefix' => 'MSG'],
            ['document_type' => 'ai_interactions', 'prefix' => 'AI'],
            ['document_type' => 'documents', 'prefix' => 'DOC'],
            ['document_type' => 'sale_orders', 'prefix' => 'SO'],
            ['document_type' => 'purchase_orders', 'prefix' => 'PO'],
            ['document_type' => 'delivery_orders', 'prefix' => 'DO'],
            ['document_type' => 'invoices', 'prefix' => 'INV'],
            ['document_type' => 'delivery_notes', 'prefix' => 'DN'],
            ['document_type' => 'estimates', 'prefix' => 'EST'],
            ['document_type' => 'quotations', 'prefix' => 'QUO'],
            ['document_type' => 'receipts', 'prefix' => 'REC'],
        ];

        foreach ($documentTypes as $type) {
            PrefixSetting::updateOrCreate(
                ['document_type' => $type['document_type']],
                [
                    'prefix' => $type['prefix'],
                    'padding' => 4,
                    'start_number' => 1,
                    'current_number' => 1,
                    'include_year' => false,
                    'is_active' => true,
                ]
            );
        }
    }
}
