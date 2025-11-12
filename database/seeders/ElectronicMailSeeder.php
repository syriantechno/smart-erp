<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ElectronicMail;
use App\Models\User;
use App\Models\Department;
use App\Models\Company;

class ElectronicMailSeeder extends Seeder
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

        // Create sample incoming mails
        ElectronicMail::create([
            'code' => 'MAIL0001',
            'subject' => 'Welcome to Our Company',
            'content' => 'Dear team, welcome to our new electronic mail system. This system will help us communicate more efficiently.',
            'type' => 'incoming',
            'status' => 'read',
            'priority' => 'normal',
            'sender_name' => 'HR Department',
            'sender_email' => 'hr@company.com',
            'recipient_name' => $admin->name,
            'recipient_email' => $admin->email,
            'recipient_user_id' => $admin->id,
            'department_id' => $department?->id,
            'company_id' => $company?->id,
            'is_read' => true,
            'read_at' => now()->subHours(2),
        ]);

        ElectronicMail::create([
            'code' => 'MAIL0002',
            'subject' => 'Urgent: System Maintenance Tonight',
            'content' => 'Important notice: The system will undergo maintenance tonight from 10 PM to 2 AM. Please save your work.',
            'type' => 'incoming',
            'status' => 'received',
            'priority' => 'urgent',
            'sender_name' => 'IT Department',
            'sender_email' => 'it@company.com',
            'recipient_name' => $admin->name,
            'recipient_email' => $admin->email,
            'recipient_user_id' => $admin->id,
            'department_id' => $department?->id,
            'company_id' => $company?->id,
            'is_read' => false,
        ]);

        ElectronicMail::create([
            'code' => 'MAIL0003',
            'subject' => 'Meeting Reminder: Project Review',
            'content' => 'This is a reminder for our project review meeting scheduled for tomorrow at 2 PM in Conference Room A.',
            'type' => 'incoming',
            'status' => 'read',
            'priority' => 'high',
            'sender_name' => 'Project Manager',
            'sender_email' => 'pm@company.com',
            'recipient_name' => $admin->name,
            'recipient_email' => $admin->email,
            'recipient_user_id' => $admin->id,
            'department_id' => $department?->id,
            'company_id' => $company?->id,
            'is_read' => true,
            'read_at' => now()->subHours(1),
            'is_starred' => true,
        ]);

        // Create sample outgoing mails
        ElectronicMail::create([
            'code' => 'MAIL0004',
            'subject' => 'Re: Welcome to Our Company',
            'content' => 'Thank you for the welcome message. I am excited to start working with the team.',
            'type' => 'outgoing',
            'status' => 'sent',
            'priority' => 'normal',
            'sender_name' => $admin->name,
            'sender_email' => $admin->email,
            'sender_user_id' => $admin->id,
            'recipient_name' => 'HR Department',
            'recipient_email' => 'hr@company.com',
            'department_id' => $department?->id,
            'company_id' => $company?->id,
            'sent_at' => now()->subHours(3),
        ]);

        // Create sample draft
        ElectronicMail::create([
            'code' => 'MAIL0005',
            'subject' => 'Draft: Monthly Report',
            'content' => 'This is a draft of the monthly report that needs to be completed...',
            'type' => 'outgoing',
            'status' => 'draft',
            'priority' => 'normal',
            'sender_name' => $admin->name,
            'sender_email' => $admin->email,
            'sender_user_id' => $admin->id,
            'department_id' => $department?->id,
            'company_id' => $company?->id,
        ]);

        $this->command->info('Electronic mail data seeded successfully!');
    }
}
