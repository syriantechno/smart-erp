<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse\PurchaseOrder;
use App\Models\User;
use Carbon\Carbon;

class PurchaseOrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::limit(3)->get();
        
        if ($users->isEmpty()) {
            $this->command->info('No users found. Please run UserSeeder first.');
            return;
        }

        $purchaseOrders = [
            [
                'code' => 'PO-2024-001',
                'title' => 'Office Supplies Purchase',
                'description' => 'Monthly office supplies procurement',
                'status' => 'pending',
                'order_date' => Carbon::now()->subDays(5),
                'expected_delivery_date' => Carbon::now()->addDays(10),
                'supplier_id' => null, // Will be set if suppliers exist
                'total_amount' => 1250.00,
                'created_by' => $users->first()->id,
                'approved_by' => null,
                'is_active' => true,
            ],
            [
                'code' => 'PO-2024-002',
                'title' => 'Computer Equipment',
                'description' => 'New laptops and accessories for development team',
                'status' => 'approved',
                'order_date' => Carbon::now()->subDays(3),
                'expected_delivery_date' => Carbon::now()->addDays(7),
                'supplier_id' => null,
                'total_amount' => 5500.00,
                'created_by' => $users->first()->id,
                'approved_by' => $users->count() > 1 ? $users->get(1)->id : null,
                'is_active' => true,
            ],
            [
                'code' => 'PO-2024-003',
                'title' => 'Raw Materials',
                'description' => 'Production materials for Q4',
                'status' => 'pending',
                'order_date' => Carbon::now()->subDays(1),
                'expected_delivery_date' => Carbon::now()->addDays(14),
                'supplier_id' => null,
                'total_amount' => 3200.00,
                'created_by' => $users->count() > 2 ? $users->get(2)->id : $users->first()->id,
                'approved_by' => null,
                'is_active' => true,
            ],
            [
                'code' => 'PO-2024-004',
                'title' => 'Maintenance Supplies',
                'description' => 'Equipment maintenance and repair supplies',
                'status' => 'delivered',
                'order_date' => Carbon::now()->subDays(15),
                'expected_delivery_date' => Carbon::now()->subDays(5),
                'supplier_id' => null,
                'total_amount' => 850.00,
                'created_by' => $users->first()->id,
                'approved_by' => $users->count() > 1 ? $users->get(1)->id : null,
                'is_active' => true,
            ],
            [
                'code' => 'PO-2024-005',
                'title' => 'Marketing Materials',
                'description' => 'Brochures, banners, and promotional items',
                'status' => 'cancelled',
                'order_date' => Carbon::now()->subDays(20),
                'expected_delivery_date' => Carbon::now()->subDays(10),
                'supplier_id' => null,
                'total_amount' => 750.00,
                'created_by' => $users->count() > 2 ? $users->get(2)->id : $users->first()->id,
                'approved_by' => null,
                'is_active' => false,
            ]
        ];

        foreach ($purchaseOrders as $poData) {
            PurchaseOrder::create($poData);
        }

        $this->command->info('Purchase Orders seeded successfully!');
    }
}
