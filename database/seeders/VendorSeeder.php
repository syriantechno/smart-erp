<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier\Vendor;
use App\Services\DocumentCodeGenerator;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $codeGenerator = app(DocumentCodeGenerator::class);

        $vendors = [
            [
                'name' => 'ABC Supply Company',
                'email' => 'info@abcsupply.com',
                'phone' => '+1-555-0101',
                'address' => '123 Business Ave, New York, NY 10001',
                'contact_person' => 'John Smith',
                'contact_person_phone' => '+1-555-0102',
                'contact_person_email' => 'john@abcsupply.com',
                'website' => 'https://www.abcsupply.com',
                'tax_id' => 'TAX-001',
                'payment_terms' => 'Net 30',
                'notes' => 'Reliable supplier for office supplies',
                'is_active' => true,
            ],
            [
                'name' => 'Global Electronics Ltd',
                'email' => 'sales@globalelectronics.com',
                'phone' => '+1-555-0201',
                'address' => '456 Tech Park, San Francisco, CA 94105',
                'contact_person' => 'Sarah Johnson',
                'contact_person_phone' => '+1-555-0202',
                'contact_person_email' => 'sarah@globalelectronics.com',
                'website' => 'https://www.globalelectronics.com',
                'tax_id' => 'TAX-002',
                'payment_terms' => 'Net 45',
                'notes' => 'Electronics and IT equipment supplier',
                'is_active' => true,
            ],
            [
                'name' => 'Premium Materials Inc',
                'email' => 'contact@premiummaterials.com',
                'phone' => '+1-555-0301',
                'address' => '789 Industrial Blvd, Chicago, IL 60601',
                'contact_person' => 'Michael Brown',
                'contact_person_phone' => '+1-555-0302',
                'contact_person_email' => 'michael@premiummaterials.com',
                'website' => 'https://www.premiummaterials.com',
                'tax_id' => 'TAX-003',
                'payment_terms' => 'COD',
                'notes' => 'Raw materials and manufacturing supplies',
                'is_active' => true,
            ],
            [
                'name' => 'Logistics Express Co',
                'email' => 'logistics@expressco.com',
                'phone' => '+1-555-0401',
                'address' => '321 Shipping Lane, Houston, TX 77001',
                'contact_person' => 'Emily Davis',
                'contact_person_phone' => '+1-555-0402',
                'contact_person_email' => 'emily@expressco.com',
                'website' => 'https://www.expressco.com',
                'tax_id' => 'TAX-004',
                'payment_terms' => 'Net 15',
                'notes' => 'Shipping and logistics services',
                'is_active' => false,
            ],
        ];

        foreach ($vendors as $vendor) {
            $vendor['code'] = $codeGenerator->generate('vendors');
            Vendor::create($vendor);
        }

        $this->command->info('Vendor seeder completed successfully!');
    }
}
