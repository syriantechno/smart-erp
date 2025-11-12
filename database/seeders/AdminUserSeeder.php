<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create or get admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->guard_name = 'web';
        $adminRole->save();

        // Create permissions if they don't exist
        $permissions = [
            // User Management
            'view users', 'create users', 'edit users', 'delete users',

            // Role Management
            'view roles', 'create roles', 'edit roles', 'delete roles',

            // Permission Management
            'view permissions', 'create permissions', 'edit permissions', 'delete permissions',

            // Department Management
            'view departments', 'create departments', 'edit departments', 'delete departments',

            // Employee Management
            'view employees', 'create employees', 'edit employees', 'delete employees',

            // Attendance Management
            'view attendance', 'create attendance', 'edit attendance', 'delete attendance',

            // Leave Management
            'view leave', 'create leave', 'edit leave', 'delete leave',

            // Payroll Management
            'view payroll', 'create payroll', 'edit payroll', 'delete payroll',

            // Accounting System
            'view accounting', 'create accounting', 'edit accounting', 'delete accounting',
            'view financial reports', 'export financial reports',

            // Project Management
            'view projects', 'create projects', 'edit projects', 'delete projects',
            'view project tasks', 'create project tasks', 'edit project tasks', 'delete project tasks',

            // Task Management
            'view tasks', 'create tasks', 'edit tasks', 'delete tasks',

            // Document Management
            'view documents', 'create documents', 'edit documents', 'delete documents',
            'manage document categories', 'view all documents',

            // Electronic Mail
            'view emails', 'send emails', 'delete emails', 'manage email settings',

            // Chat System
            'view chat', 'send messages', 'manage chat channels', 'delete messages',

            // Recruitment System
            'view recruitment', 'create job postings', 'edit job postings', 'delete job postings',
            'view applications', 'manage interviews',

            // Settings Management
            'view settings', 'edit settings', 'manage system settings',

            // AI Assistant
            'use ai assistant', 'manage ai settings',

            // Approval System
            'view approvals', 'approve requests', 'reject requests', 'manage approval workflows',

            // Internal Chat
            'access internal chat', 'manage chat groups',

            // Manufacturing System
            'view manufacturing', 'create manufacturing', 'edit manufacturing', 'delete manufacturing',
            'manage production orders', 'view production reports', 'manage inventory',

            // System Administration
            'system backup', 'system restore', 'manage system logs', 'clear cache',
        ];

        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(
                ['name' => $permissionName],
                ['guard_name' => 'web']
            );
        }

        // Assign all permissions to admin role
        $adminRole->syncPermissions(Permission::all());

        // Create admin user if not exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@erp.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('Admin@123'),
                'email_verified_at' => now(),
                'status' => 'active',
                'phone' => '+966501234567',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Ensure admin has admin role
        if (!$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }

        // Clear the permission cache
        app()['cache']->forget('spatie.permission.cache');

        $this->command->info('================================================');
        $this->command->info('🎉 Admin User Created Successfully!');
        $this->command->info('================================================');
        $this->command->info('👤 Name: System Administrator');
        $this->command->info('📧 Email: admin@erp.com');
        $this->command->info('🔑 Password: Admin@123');
        $this->command->info('📱 Phone: +966501234567');
        $this->command->info('🔒 Role: Admin (Full Access)');
        $this->command->info('================================================');
        $this->command->info('✅ Total Permissions Assigned: ' . Permission::count());
        $this->command->info('================================================');
        $this->command->info('🔐 You can now login with the admin credentials above');
        $this->command->info('================================================');
    }
}
