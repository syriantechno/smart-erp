<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'name' => 'شركة التكنولوجيا المتقدمة',
                'logo' => null,
                'address' => 'شارع الملك فهد، الرياض',
                'commercial_registration' => 'CR1010010001',
                'tax_number' => 'TAX300123456789',
                'phone' => '+966501234567',
                'email' => 'info@advanced-tech.com',
                'website' => 'https://www.advanced-tech.com',
                'country' => 'السعودية',
                'city' => 'الرياض',
                'postal_code' => '12345',
                'is_active' => true,
            ],
            [
                'name' => 'مجموعة الأعمال التجارية',
                'logo' => null,
                'address' => 'شارع التحرير، جدة',
                'commercial_registration' => 'CR1010020002',
                'tax_number' => 'TAX300123456790',
                'phone' => '+966507654321',
                'email' => 'contact@business-group.com',
                'website' => 'https://www.business-group.com',
                'country' => 'السعودية',
                'city' => 'جدة',
                'postal_code' => '23456',
                'is_active' => true,
            ],
            [
                'name' => 'شركة الابتكار الرقمي',
                'logo' => null,
                'address' => 'شارع الملك عبدالعزيز، الدمام',
                'commercial_registration' => 'CR1010030003',
                'tax_number' => 'TAX300123456791',
                'phone' => '+966509876543',
                'email' => 'hello@digital-innovation.com',
                'website' => 'https://www.digital-innovation.com',
                'country' => 'السعودية',
                'city' => 'الدمام',
                'postal_code' => '34567',
                'is_active' => true,
            ],
            [
                'name' => 'مؤسسة التطوير والاستشارات',
                'logo' => null,
                'address' => 'شارع الملك سلمان، المدينة المنورة',
                'commercial_registration' => 'CR1010040004',
                'tax_number' => 'TAX300123456792',
                'phone' => '+966503216549',
                'email' => 'info@dev-consulting.com',
                'website' => 'https://www.dev-consulting.com',
                'country' => 'السعودية',
                'city' => 'المدينة المنورة',
                'postal_code' => '45678',
                'is_active' => false,
            ],
            [
                'name' => 'شركة الحلول المتكاملة',
                'logo' => null,
                'address' => 'شارع الملك خالد، مكة المكرمة',
                'commercial_registration' => 'CR1010050005',
                'tax_number' => 'TAX300123456793',
                'phone' => '+966504567890',
                'email' => 'contact@integrated-solutions.com',
                'website' => 'https://www.integrated-solutions.com',
                'country' => 'السعودية',
                'city' => 'مكة المكرمة',
                'postal_code' => '56789',
                'is_active' => true,
            ],
        ];

        foreach ($companies as $company) {
            \App\Models\Company::firstOrCreate(
                ['name' => $company['name']], // Check for existing by name
                $company // Use all data if creating new
            );
        }
    }
}
