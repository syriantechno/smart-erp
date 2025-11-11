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
            'view users', 'create users', 'edit users', 'delete users',
            'view roles', 'create roles', 'edit roles', 'delete roles',
            'view permissions', 'create permissions', 'edit permissions', 'delete permissions',
            'view departments', 'create departments', 'edit departments', 'delete departments',
            'view employees', 'create employees', 'edit employees', 'delete employees',
            'view attendance', 'create attendance', 'edit attendance', 'delete attendance',
            'view leave', 'create leave', 'edit leave', 'delete leave',
            'view payroll', 'create payroll', 'edit payroll', 'delete payroll',
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
                'name' => 'System Admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'status' => 'active',
            ]
        );

        // Assign admin role to the user
        $admin->assignRole($adminRole);
        
        // Clear the permission cache
        app()['cache']->forget('spatie.permission.cache');
        if (class_exists('Spatie\Permission\Traits\HasRoles')) {
            $admin->assignRole('admin');
        }

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@example.com');
        $this->command->info('Password: password');
    }
}
