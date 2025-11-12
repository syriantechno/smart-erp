<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting Database Seeding...');
        $this->command->info('================================================');

        $this->call([
            AdminUserSeeder::class,
            CompanySeeder::class,
            SystemSettingsSeeder::class,
            PrefixSettingsSeeder::class,
            HRDataSeeder::class, // Add HR data seeder
            // Add other seeders here
        ]);

        $this->command->info('================================================');
        $this->command->info('✅ Database Seeding Completed Successfully!');
        $this->command->info('================================================');
        $this->command->info('🎯 Next Steps:');
        $this->command->info('  1. Run: php artisan migrate:fresh --seed');
        $this->command->info('  2. Login with admin credentials');
        $this->command->info('  3. Start using the ERP system!');
        $this->command->info('================================================');
    }
}
