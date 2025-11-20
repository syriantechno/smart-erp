<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء بيانات تجريبية شاملة لجميع الأنظمة

        // 1. إنشاء الشركات
        $companies = [
            [
                'name' => 'شركة التقنية المتقدمة',
                'email' => 'info@advanced-tech.com',
                'phone' => '+966501234567',
                'address' => 'الرياض، المملكة العربية السعودية',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'مجموعة الأعمال التجارية',
                'email' => 'contact@business-group.com',
                'phone' => '+966507654321',
                'address' => 'جدة، المملكة العربية السعودية',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('companies')->insert($companies);

        // 2. إنشاء الأقسام
        $departments = [
            [
                'company_id' => 1,
                'name' => 'قسم تطوير البرمجيات',
                'description' => 'مسؤول عن تطوير وصيانة أنظمة البرمجيات',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => 1,
                'name' => 'قسم إدارة المشاريع',
                'description' => 'إدارة وتنسيق المشاريع التقنية',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => 2,
                'name' => 'قسم المبيعات',
                'description' => 'إدارة المبيعات والتسويق',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => 2,
                'name' => 'قسم الموارد البشرية',
                'description' => 'إدارة الموظفين والتوظيف',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('departments')->insert($departments);

        // 3. إنشاء الموظفين
        $employees = [
            [
                'code' => 'EMP001',
                'employee_id' => '12345',
                'first_name' => 'أحمد',
                'middle_name' => 'محمد',
                'last_name' => 'العلي',
                'email' => 'ahmed.ali@advanced-tech.com',
                'phone' => '+966501234567',
                'position' => 'مدير تطوير',
                'salary' => 15000.00,
                'company_id' => 1,
                'department_id' => 1,
                'hire_date' => '2023-01-15',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'EMP002',
                'employee_id' => '12346',
                'first_name' => 'فاطمة',
                'middle_name' => 'أحمد',
                'last_name' => 'الزهراني',
                'email' => 'fatima.alzahrani@advanced-tech.com',
                'phone' => '+966507654321',
                'position' => 'مطور برمجيات',
                'salary' => 12000.00,
                'company_id' => 1,
                'department_id' => 1,
                'hire_date' => '2023-03-01',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'EMP003',
                'employee_id' => '12347',
                'first_name' => 'محمد',
                'middle_name' => 'عبدالله',
                'last_name' => 'القحطاني',
                'email' => 'mohammed.alkhathami@business-group.com',
                'phone' => '+966509876543',
                'position' => 'مدير المبيعات',
                'salary' => 14000.00,
                'company_id' => 2,
                'department_id' => 3,
                'hire_date' => '2023-02-10',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'EMP004',
                'employee_id' => '12348',
                'first_name' => 'سارة',
                'middle_name' => 'خالد',
                'last_name' => 'الأنصاري',
                'email' => 'sara.alansari@business-group.com',
                'phone' => '+966503456789',
                'position' => 'مدير الموارد البشرية',
                'salary' => 13000.00,
                'company_id' => 2,
                'department_id' => 4,
                'hire_date' => '2023-04-05',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('employees')->insert($employees);

        // 4. إنشاء طلبات الإجازة التجريبية
        $leaves = [
            [
                'code' => 'LV-2025-001',
                'employee_id' => 1,
                'department_id' => 1,
                'company_id' => 1,
                'leave_type' => 'annual',
                'reason_category' => 'vacation',
                'start_date' => '2025-10-02',
                'end_date' => '2025-10-06',
                'days_count' => 5,
                'is_paid' => true,
                'status' => 'approved',
                'reason_details' => 'إجازة عائلية إلى دبي',
                'notes' => 'تمت الموافقة من المدير المالي',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'LV-2025-002',
                'employee_id' => 2,
                'department_id' => 1,
                'company_id' => 1,
                'leave_type' => 'sick',
                'reason_category' => 'medical',
                'start_date' => '2025-11-12',
                'end_date' => '2025-11-14',
                'days_count' => 3,
                'is_paid' => true,
                'status' => 'pending',
                'reason_details' => 'مراجعة طبية خارجية',
                'notes' => 'بانتظار التقرير الطبي',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'LV-2025-003',
                'employee_id' => 3,
                'department_id' => 3,
                'company_id' => 2,
                'leave_type' => 'emergency',
                'reason_category' => 'family',
                'start_date' => '2025-09-21',
                'end_date' => '2025-09-23',
                'days_count' => 3,
                'is_paid' => true,
                'status' => 'approved',
                'reason_details' => 'ظرف عائلي طارئ',
                'notes' => 'تم تعويضه بالمندوب الإقليمي',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'LV-2025-004',
                'employee_id' => 4,
                'department_id' => 4,
                'company_id' => 2,
                'leave_type' => 'unpaid',
                'reason_category' => 'remote',
                'start_date' => '2025-08-01',
                'end_date' => '2025-08-10',
                'days_count' => 10,
                'is_paid' => false,
                'status' => 'rejected',
                'reason_details' => 'طلب إجازة غير مدفوعة للعمل عن بعد خارج البلاد',
                'notes' => 'تعارض مع تسليمات حرجة',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('leaves')->insert($leaves);

        // 4. إنشاء المشاريع
        $projects = [
            [
                'code' => 'PROJ001',
                'name' => 'نظام إدارة المخزون',
                'description' => 'تطوير نظام شامل لإدارة المخزون والمستودعات',
                'manager_id' => 1, // أحمد محمد العلي
                'company_id' => 1,
                'department_id' => 1,
                'status' => 'active',
                'priority' => 'high',
                'budget' => 150000.00,
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-30',
                'progress_percentage' => 65,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PROJ002',
                'name' => 'تطبيق التجارة الإلكترونية',
                'description' => 'بناء منصة تجارة إلكترونية متكاملة',
                'manager_id' => 2, // فاطمة أحمد الزهراني
                'company_id' => 1,
                'department_id' => 1,
                'status' => 'planning',
                'priority' => 'medium',
                'budget' => 200000.00,
                'start_date' => '2024-03-01',
                'end_date' => '2024-12-31',
                'progress_percentage' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'PROJ003',
                'name' => 'نظام إدارة العلاقات مع العملاء',
                'description' => 'تطوير CRM متطور لإدارة العلاقات مع العملاء',
                'manager_id' => 3, // محمد عبدالله القحطاني
                'company_id' => 2,
                'department_id' => 3,
                'status' => 'active',
                'priority' => 'critical',
                'budget' => 300000.00,
                'start_date' => '2024-02-15',
                'end_date' => '2024-11-15',
                'progress_percentage' => 45,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('projects')->insert($projects);

        // 5. إنشاء الشيفت
        $shifts = [
            [
                'code' => 'SHIFT001',
                'name' => 'الشيفت الصباحي',
                'start_time' => '08:00:00',
                'end_time' => '16:00:00',
                'description' => 'الشيفت الرسمي من 8 صباحاً إلى 4 مساءً',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SHIFT002',
                'name' => 'الشيفت المسائي',
                'start_time' => '16:00:00',
                'end_time' => '00:00:00',
                'description' => 'الشيفت المسائي من 4 مساءً إلى 12 منتصف الليل',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SHIFT003',
                'name' => 'الشيفت الليلي',
                'start_time' => '00:00:00',
                'end_time' => '08:00:00',
                'description' => 'الشيفت الليلي من 12 منتصف الليل إلى 8 صباحاً',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('shifts')->insert($shifts);

        // 6. إنشاء الرواتب
        $payrolls = [
            [
                'employee_id' => 1, // أحمد محمد العلي
                'month' => 11,
                'year' => 2024,
                'basic_salary' => 15000.00,
                'allowances' => 2000.00,
                'deductions' => 500.00,
                'net_salary' => 16500.00,
                'status' => 'paid',
                'payment_date' => '2024-11-30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 2, // فاطمة أحمد الزهراني
                'month' => 11,
                'year' => 2024,
                'basic_salary' => 12000.00,
                'allowances' => 1500.00,
                'deductions' => 300.00,
                'net_salary' => 13200.00,
                'status' => 'paid',
                'payment_date' => '2024-11-30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 3, // محمد عبدالله القحطاني
                'month' => 11,
                'year' => 2024,
                'basic_salary' => 14000.00,
                'allowances' => 1800.00,
                'deductions' => 400.00,
                'net_salary' => 15400.00,
                'status' => 'paid',
                'payment_date' => '2024-11-30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('payrolls')->insert($payrolls);

        // 7. إنشاء مرشحي التوظيف
        $recruitments = [
            [
                'code' => 'REC001',
                'candidate_name' => 'علي المحمد',
                'email' => 'ali.mohammed@email.com',
                'phone' => '+966501112233',
                'position' => 'مطور ويب',
                'company_id' => 1,
                'department_id' => 1,
                'experience' => 'خبرة 3 سنوات في تطوير الويب',
                'education_level' => 'بكالوريوس هندسة الحاسوب',
                'skills' => 'PHP, Laravel, JavaScript, React',
                'status' => 'interview',
                'application_date' => '2024-11-01',
                'interview_date' => '2024-11-15',
                'expected_salary' => 10000.00,
                'notes' => 'مرشح جيد لديه خبرة جيدة في Laravel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'REC002',
                'candidate_name' => 'نور الأحمد',
                'email' => 'nour.ahmed@email.com',
                'phone' => '+966502223344',
                'position' => 'مصمم واجهات',
                'company_id' => 1,
                'department_id' => 1,
                'experience' => 'خبرة 2 سنوات في تصميم الواجهات',
                'education_level' => 'بكالوريوس التصميم الرقمي',
                'skills' => 'Figma, Adobe XD, Photoshop, UI/UX',
                'status' => 'applied',
                'application_date' => '2024-11-05',
                'interview_date' => null,
                'expected_salary' => 8000.00,
                'notes' => 'مهتمة بالتطوير الرقمي والتصميم',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'REC003',
                'candidate_name' => 'سعد الخالدي',
                'email' => 'saad.khalidi@email.com',
                'phone' => '+966503334455',
                'position' => 'مدير مشاريع',
                'company_id' => 2,
                'department_id' => 3,
                'experience' => 'خبرة 5 سنوات في إدارة المشاريع',
                'education_level' => 'ماجستير إدارة الأعمال',
                'skills' => 'إدارة المشاريع, Agile, Scrum, PMP',
                'status' => 'hired',
                'application_date' => '2024-10-20',
                'interview_date' => '2024-11-01',
                'expected_salary' => 18000.00,
                'notes' => 'تم توظيفه كمدير مشاريع في قسم التطوير',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('recruitments')->insert($recruitments);

        // 8. إنشاء تسجيلات الحضور
        $attendances = [
            [
                'employee_id' => 1,
                'attendance_date' => '2024-11-13',
                'check_in' => '08:15:00',
                'check_out' => '16:45:00',
                'working_hours' => 8.5,
                'status' => 'present',
                'notes' => 'حضور منتظم',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 2,
                'attendance_date' => '2024-11-13',
                'check_in' => '08:30:00',
                'check_out' => '16:30:00',
                'working_hours' => 8.0,
                'status' => 'present',
                'notes' => 'حضور جيد',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 3,
                'attendance_date' => '2024-11-12',
                'check_in' => '16:00:00',
                'check_out' => '23:30:00',
                'working_hours' => 7.5,
                'status' => 'present',
                'notes' => 'شيفت مسائي',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('attendances')->insert($attendances);

        $this->command->info('تم إدراج البيانات التجريبية بنجاح! 🎉');
        $this->command->info('الشركات: ' . count($companies));
        $this->command->info('الأقسام: ' . count($departments));
        $this->command->info('الموظفين: ' . count($employees));
        $this->command->info('المشاريع: ' . count($projects));
        $this->command->info('الشيفت: ' . count($shifts));
        $this->command->info('الرواتب: ' . count($payrolls));
        $this->command->info('المرشحين: ' . count($recruitments));
        $this->command->info('تسجيلات الحضور: ' . count($attendances));
    }
}
