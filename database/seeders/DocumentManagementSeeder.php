<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentCategory;
use App\Models\Document;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;

class DocumentManagementSeeder extends Seeder
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

        // Create document categories
        $categories = [
            [
                'name' => 'Contracts & Agreements',
                'description' => 'Legal contracts and agreements',
                'color' => '#ef4444',
                'icon' => 'file-text',
                'children' => [
                    ['name' => 'Client Contracts', 'description' => 'Contracts with clients', 'color' => '#f87171', 'icon' => 'users'],
                    ['name' => 'Vendor Agreements', 'description' => 'Agreements with vendors', 'color' => '#fca5a5', 'icon' => 'truck'],
                    ['name' => 'Employment Contracts', 'description' => 'Employee contracts', 'color' => '#fecaca', 'icon' => 'user-check'],
                ]
            ],
            [
                'name' => 'Financial Documents',
                'description' => 'Invoices, receipts, and financial records',
                'color' => '#22c55e',
                'icon' => 'dollar-sign',
                'children' => [
                    ['name' => 'Invoices', 'description' => 'Client invoices', 'color' => '#4ade80', 'icon' => 'receipt'],
                    ['name' => 'Receipts', 'description' => 'Payment receipts', 'color' => '#86efac', 'icon' => 'credit-card'],
                    ['name' => 'Tax Documents', 'description' => 'Tax related documents', 'color' => '#bbf7d0', 'icon' => 'calculator'],
                ]
            ],
            [
                'name' => 'HR Documents',
                'description' => 'Human resources related documents',
                'color' => '#3b82f6',
                'icon' => 'users',
                'children' => [
                    ['name' => 'Employee Records', 'description' => 'Employee personal records', 'color' => '#60a5fa', 'icon' => 'user'],
                    ['name' => 'Policies & Procedures', 'description' => 'Company policies', 'color' => '#93c5fd', 'icon' => 'book-open'],
                    ['name' => 'Training Materials', 'description' => 'Training documents', 'color' => '#bfdbfe', 'icon' => 'graduation-cap'],
                ]
            ],
            [
                'name' => 'Reports & Analytics',
                'description' => 'Business reports and analytics',
                'color' => '#f59e0b',
                'icon' => 'bar-chart-3',
                'children' => [
                    ['name' => 'Monthly Reports', 'description' => 'Monthly business reports', 'color' => '#fbbf24', 'icon' => 'calendar'],
                    ['name' => 'Financial Reports', 'description' => 'Financial analysis reports', 'color' => '#fcd34d', 'icon' => 'trending-up'],
                    ['name' => 'Performance Reports', 'description' => 'Performance metrics', 'color' => '#fde68a', 'icon' => 'activity'],
                ]
            ],
            [
                'name' => 'Legal Documents',
                'description' => 'Legal documents and certificates',
                'color' => '#8b5cf6',
                'icon' => 'shield',
                'children' => [
                    ['name' => 'Certificates', 'description' => 'Business certificates', 'color' => '#a78bfa', 'icon' => 'award'],
                    ['name' => 'Licenses', 'description' => 'Business licenses', 'color' => '#c4b5fd', 'icon' => 'key'],
                    ['name' => 'Legal Agreements', 'description' => 'Legal agreements', 'color' => '#ddd6fe', 'icon' => 'file-signature'],
                ]
            ],
            [
                'name' => 'Technical Documentation',
                'description' => 'Technical manuals and documentation',
                'color' => '#06b6d4',
                'icon' => 'code',
                'children' => [
                    ['name' => 'User Manuals', 'description' => 'Product user manuals', 'color' => '#22d3ee', 'icon' => 'book'],
                    ['name' => 'API Documentation', 'description' => 'API documentation', 'color' => '#67e8f9', 'icon' => 'terminal'],
                    ['name' => 'System Guides', 'description' => 'System setup guides', 'color' => '#a5f3fc', 'icon' => 'settings'],
                ]
            ],
        ];

        $createdCategories = [];

        foreach ($categories as $index => $categoryData) {
            $parent = DocumentCategory::create([
                'name' => $categoryData['name'],
                'description' => $categoryData['description'],
                'color' => $categoryData['color'],
                'icon' => $categoryData['icon'],
                'company_id' => $company?->id,
                'sort_order' => $index,
            ]);

            $createdCategories[] = $parent;

            if (isset($categoryData['children'])) {
                foreach ($categoryData['children'] as $childIndex => $childData) {
                    DocumentCategory::create([
                        'name' => $childData['name'],
                        'description' => $childData['description'],
                        'color' => $childData['color'],
                        'icon' => $childData['icon'],
                        'parent_id' => $parent->id,
                        'company_id' => $company?->id,
                        'sort_order' => $childIndex,
                    ]);
                }
            }
        }

        // Create sample documents
        $sampleDocuments = [
            [
                'title' => 'Service Agreement Template',
                'description' => 'Standard service agreement template for client contracts',
                'document_type' => 'contract',
                'category_id' => $createdCategories[0]->id, // Contracts & Agreements
                'access_level' => 'internal',
                'file_name' => 'service_agreement_template.pdf',
                'file_path' => 'sample_files/service_agreement_template.pdf',
                'file_type' => 'pdf',
                'file_size' => 245760, // 240KB
                'mime_type' => 'application/pdf',
            ],
            [
                'title' => 'Company Employee Handbook',
                'description' => 'Complete employee handbook with policies and procedures',
                'document_type' => 'policy',
                'category_id' => $createdCategories[2]->children->where('name', 'Policies & Procedures')->first()?->id ?? $createdCategories[2]->id,
                'access_level' => 'internal',
                'file_name' => 'employee_handbook_2024.pdf',
                'file_path' => 'sample_files/employee_handbook_2024.pdf',
                'file_type' => 'pdf',
                'file_size' => 1843200, // 1.8MB
                'mime_type' => 'application/pdf',
            ],
            [
                'title' => 'Q4 2024 Financial Report',
                'description' => 'Quarterly financial report for Q4 2024',
                'document_type' => 'report',
                'category_id' => $createdCategories[1]->children->where('name', 'Financial Reports')->first()?->id ?? $createdCategories[1]->id,
                'access_level' => 'confidential',
                'department_id' => $department?->id,
                'file_name' => 'q4_2024_financial_report.xlsx',
                'file_path' => 'sample_files/q4_2024_financial_report.xlsx',
                'file_type' => 'xlsx',
                'file_size' => 512000, // 500KB
                'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ],
            [
                'title' => 'Business License Certificate',
                'description' => 'Official business license certificate valid until 2026',
                'document_type' => 'license',
                'category_id' => $createdCategories[4]->children->where('name', 'Licenses')->first()?->id ?? $createdCategories[4]->id,
                'access_level' => 'internal',
                'expiry_date' => '2026-12-31',
                'file_name' => 'business_license_2024.jpg',
                'file_path' => 'sample_files/business_license_2024.jpg',
                'file_type' => 'jpg',
                'file_size' => 1024000, // 1MB
                'mime_type' => 'image/jpeg',
            ],
            [
                'title' => 'API Documentation v2.1',
                'description' => 'Complete API documentation for version 2.1',
                'document_type' => 'manual',
                'category_id' => $createdCategories[5]->children->where('name', 'API Documentation')->first()?->id ?? $createdCategories[5]->id,
                'access_level' => 'internal',
                'file_name' => 'api_documentation_v2.1.pdf',
                'file_path' => 'sample_files/api_documentation_v2.1.pdf',
                'file_type' => 'pdf',
                'file_size' => 768000, // 750KB
                'mime_type' => 'application/pdf',
            ],
            [
                'title' => 'Monthly Sales Report - November 2024',
                'description' => 'Detailed sales performance report for November 2024',
                'document_type' => 'report',
                'category_id' => $createdCategories[3]->children->where('name', 'Monthly Reports')->first()?->id ?? $createdCategories[3]->id,
                'access_level' => 'confidential',
                'department_id' => $department?->id,
                'file_name' => 'november_2024_sales_report.pdf',
                'file_path' => 'sample_files/november_2024_sales_report.pdf',
                'file_type' => 'pdf',
                'file_size' => 358400, // 350KB
                'mime_type' => 'application/pdf',
            ],
        ];

        foreach ($sampleDocuments as $docData) {
            $docData['code'] = app(\App\Services\DocumentCodeGenerator::class)->generate('documents');
            $docData['uploaded_by'] = $admin->id;
            $docData['company_id'] = $company?->id;

            Document::create($docData);
        }

        $this->command->info('Document management data seeded successfully!');
        $this->command->info('Created ' . count($createdCategories) . ' main categories with subcategories');
        $this->command->info('Created ' . count($sampleDocuments) . ' sample documents');
    }
}
