<?php

namespace Database\Seeders;

use App\Models\Approval\ApprovalTemplate;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApprovalTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get different users for approval levels
        $users = User::take(3)->get();
        
        if ($users->count() < 2) {
            return; // Need at least 2 different users
        }
        
        $firstApprover = $users[0]; // Department Manager
        $secondApprover = $users[1]; // General Manager
        $financeApprover = $users[2] ?? $users[0]; // Finance Manager (fallback to first if not enough)

        // Purchase Order Approval Template
        ApprovalTemplate::create([
            'name' => 'Purchase Order Approval',
            'type' => 'purchase_order',
            'description' => 'Standard approval workflow for purchase orders',
            'levels' => [
                [
                    'level' => 1,
                    'name' => 'Department Manager',
                    'approver_id' => $firstApprover->id,
                    'can_reject' => true,
                    'is_required' => true
                ],
                [
                    'level' => 2,
                    'name' => 'General Manager',
                    'approver_id' => $secondApprover->id,
                    'can_reject' => true,
                    'is_required' => true
                ]
            ],
            'is_active' => true
        ]);

        // Invoice Approval Template
        ApprovalTemplate::create([
            'name' => 'Invoice Approval',
            'type' => 'invoice',
            'description' => 'Standard approval workflow for invoices',
            'levels' => [
                [
                    'level' => 1,
                    'name' => 'Financial Manager',
                    'approver_id' => $financeApprover->id,
                    'can_reject' => true,
                    'is_required' => true
                ],
                [
                    'level' => 2,
                    'name' => 'General Manager',
                    'approver_id' => $secondApprover->id,
                    'can_reject' => true,
                    'is_required' => true
                ]
            ],
            'is_active' => true
        ]);

        // Expense Approval Template
        ApprovalTemplate::create([
            'name' => 'Expense Approval',
            'type' => 'expense',
            'description' => 'Standard approval workflow for expenses',
            'levels' => [
                [
                    'level' => 1,
                    'name' => 'Department Manager',
                    'approver_id' => $firstApprover->id,
                    'can_reject' => true,
                    'is_required' => true
                ],
                [
                    'level' => 2,
                    'name' => 'Financial Manager',
                    'approver_id' => $financeApprover->id,
                    'can_reject' => true,
                    'is_required' => true
                ]
            ],
            'is_active' => true
        ]);
    }
}
