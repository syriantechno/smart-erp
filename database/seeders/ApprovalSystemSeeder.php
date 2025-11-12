<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApprovalRequest;
use App\Models\User;
use App\Models\Department;
use App\Models\Company;

class ApprovalSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@erp.com')->first();
        $company = Company::first();
        $department = Department::first();

        if (!$admin) {
            $this->command->error('Admin user not found. Please run AdminUserSeeder first.');
            return;
        }

        // Create sample approval requests
        $requests = [
            [
                'code' => 'APR0001',
                'title' => 'Annual Leave Request - 5 Days',
                'description' => 'I would like to request 5 days of annual leave from December 20-24, 2024.',
                'type' => 'leave_request',
                'status' => 'approved',
                'priority' => 'normal',
                'start_date' => '2024-12-20',
                'end_date' => '2024-12-24',
                'duration_days' => 5,
                'department_id' => $department?->id,
                'company_id' => $company?->id,
                'approval_levels' => [
                    ['level' => 1, 'approver_id' => $admin->id, 'role' => 'Manager']
                ],
                'current_approver_id' => $admin->id,
                'current_level' => 1,
            ],
            [
                'code' => 'APR0002',
                'title' => 'Office Equipment Purchase',
                'description' => 'Request to purchase new office equipment including laptops and monitors for the development team.',
                'type' => 'purchase_request',
                'status' => 'pending',
                'priority' => 'high',
                'amount' => 5000.00,
                'department_id' => $department?->id,
                'company_id' => $company?->id,
                'approval_levels' => [
                    ['level' => 1, 'approver_id' => $admin->id, 'role' => 'Department Manager'],
                    ['level' => 2, 'approver_id' => $admin->id, 'role' => 'Senior Management']
                ],
                'current_approver_id' => $admin->id,
                'current_level' => 1,
            ],
            [
                'code' => 'APR0003',
                'title' => 'Business Trip Expense Claim',
                'description' => 'Claim for business trip expenses including flights, accommodation, and meals.',
                'type' => 'expense_claim',
                'status' => 'rejected',
                'priority' => 'normal',
                'amount' => 1200.00,
                'department_id' => $department?->id,
                'company_id' => $company?->id,
                'approval_levels' => [
                    ['level' => 1, 'approver_id' => $admin->id, 'role' => 'Manager']
                ],
                'current_approver_id' => $admin->id,
                'current_level' => 1,
                'rejection_reason' => 'Missing original receipts for accommodation expenses.',
            ],
            [
                'code' => 'APR0004',
                'title' => 'Overtime Work Request',
                'description' => 'Request for overtime work on Saturday to complete urgent project deadline.',
                'type' => 'overtime_request',
                'status' => 'approved',
                'priority' => 'urgent',
                'start_date' => '2024-11-16',
                'end_date' => '2024-11-16',
                'duration_days' => 1,
                'department_id' => $department?->id,
                'company_id' => $company?->id,
                'approval_levels' => [
                    ['level' => 1, 'approver_id' => $admin->id, 'role' => 'Manager']
                ],
                'current_approver_id' => $admin->id,
                'current_level' => 1,
            ],
            [
                'code' => 'APR0005',
                'title' => 'Training Course Registration',
                'description' => 'Request to attend Laravel Advanced Development course next month.',
                'type' => 'training_request',
                'status' => 'pending',
                'priority' => 'normal',
                'amount' => 800.00,
                'start_date' => '2024-12-15',
                'end_date' => '2024-12-17',
                'duration_days' => 3,
                'department_id' => $department?->id,
                'company_id' => $company?->id,
                'approval_levels' => [
                    ['level' => 1, 'approver_id' => $admin->id, 'role' => 'Manager'],
                    ['level' => 2, 'approver_id' => $admin->id, 'role' => 'HR Manager']
                ],
                'current_approver_id' => $admin->id,
                'current_level' => 1,
            ],
        ];

        foreach ($requests as $requestData) {
            $requestData['requester_id'] = $admin->id;
            ApprovalRequest::create($requestData);
        }

        $this->command->info('Approval system data seeded successfully!');
    }
}
