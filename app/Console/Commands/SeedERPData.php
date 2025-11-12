<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedERPData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:seed {--fresh : Drop all tables and re-run all migrations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the ERP system with initial data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Smart ERP System - Database Seeding');
        $this->line('================================================');

        if ($this->option('fresh')) {
            $this->warn('⚠️  Fresh migration will drop all existing data!');
            if (!$this->confirm('Are you sure you want to continue?')) {
                $this->info('❌ Operation cancelled.');
                return;
            }

            $this->info('🔄 Dropping all tables...');
            Artisan::call('migrate:reset', [], $this->getOutput());
            $this->newLine();

            $this->info('📦 Running fresh migrations...');
            Artisan::call('migrate', [], $this->getOutput());
            $this->newLine();
        }

        $this->info('🌱 Seeding ERP data...');
        $this->line('================================================');

        // Seed Admin User
        $this->info('👤 Creating Admin User...');
        Artisan::call('db:seed', ['--class' => 'AdminUserSeeder'], $this->getOutput());
        $this->newLine();

        // Seed Companies
        $this->info('🏢 Creating Companies...');
        Artisan::call('db:seed', ['--class' => 'CompanySeeder'], $this->getOutput());
        $this->newLine();

        // Seed System Settings
        $this->info('⚙️ Creating System Settings...');
        Artisan::call('db:seed', ['--class' => 'SystemSettingsSeeder'], $this->getOutput());
        $this->newLine();

        // Seed Prefix Settings
        $this->info('🏷️ Creating Prefix Settings...');
        Artisan::call('db:seed', ['--class' => 'PrefixSettingsSeeder'], $this->getOutput());
        $this->newLine();

        // Seed HR Data (if exists)
        try {
            $this->info('👥 Creating HR Data...');
            Artisan::call('db:seed', ['--class' => 'HRDataSeeder'], $this->getOutput());
            $this->newLine();
        } catch (\Exception $e) {
            $this->warn('⚠️  HR Data Seeder not found, skipping...');
        }

        $this->line('================================================');
        $this->info('✅ ERP Seeding Completed Successfully!');
        $this->line('================================================');

        // Display summary
        $this->displaySummary();

        $this->newLine();
        $this->info('🎯 Next Steps:');
        $this->line('  1. Start the development server: php artisan serve');
        $this->line('  2. Visit: http://localhost:8000');
        $this->line('  3. Login with admin credentials below');
        $this->newLine();

        $this->displayAdminCredentials();

        return self::SUCCESS;
    }

    /**
     * Display seeding summary
     */
    private function displaySummary()
    {
        $this->info('📊 Seeding Summary:');
        $this->line('  • Admin Users: ' . \App\Models\User::count());
        $this->line('  • Companies: ' . \App\Models\Company::count());
        $this->line('  • System Settings: ' . \App\Models\Setting::count());
        $this->line('  • Roles: ' . \Spatie\Permission\Models\Role::count());
        $this->line('  • Permissions: ' . \Spatie\Permission\Models\Permission::count());

        if (class_exists('\App\Models\Department')) {
            $this->line('  • Departments: ' . \App\Models\Department::count());
        }

        if (class_exists('\App\Models\Employee')) {
            $this->line('  • Employees: ' . \App\Models\Employee::count());
        }
    }

    /**
     * Display admin login credentials
     */
    private function displayAdminCredentials()
    {
        $this->line('================================================');
        $this->info('🔐 Admin Login Credentials:');
        $this->line('================================================');
        $this->line('👤 Name: System Administrator');
        $this->line('📧 Email: admin@erp.com');
        $this->line('🔑 Password: Admin@123');
        $this->line('📱 Phone: +966501234567');
        $this->line('🔒 Role: Admin (Full Access)');
        $this->line('================================================');
        $this->info('🎉 Ready to use Smart ERP System!');
        $this->line('================================================');
    }
}
