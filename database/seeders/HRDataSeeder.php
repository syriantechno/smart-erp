<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Department;
use App\Models\Position;

class HRDataSeeder extends Seeder
{
    public function run(): void
    {
        // Get first active company
        $company = Company::where('is_active', true)->first();

        if (!$company) {
            return;
        }

        // Create departments
        $departments = [
            [
                'name' => 'قسم تقنية المعلومات',
                'description' => 'إدارة أنظمة المعلومات والتطوير',
                'company_id' => $company->id,
                'is_active' => true,
            ],
            [
                'name' => 'قسم الموارد البشرية',
                'description' => 'إدارة الموظفين والموارد البشرية',
                'company_id' => $company->id,
                'is_active' => true,
            ],
            [
                'name' => 'قسم المحاسبة والمالية',
                'description' => 'إدارة الحسابات والشؤون المالية',
                'company_id' => $company->id,
                'is_active' => true,
            ],
        ];

        foreach ($departments as $deptData) {
            $department = Department::firstOrCreate(
                ['name' => $deptData['name'], 'company_id' => $deptData['company_id']],
                $deptData
            );

            // Create positions for each department
            $positions = $this->getPositionsForDepartment($department->name);

            foreach ($positions as $posData) {
                Position::firstOrCreate(
                    ['title' => $posData['title'], 'department_id' => $department->id],
                    array_merge($posData, ['department_id' => $department->id, 'is_active' => true])
                );
            }
        }
    }

    private function getPositionsForDepartment($departmentName): array
    {
        $positionsMap = [
            'قسم تقنية المعلومات' => [
                ['title' => 'مدير تقنية المعلومات', 'salary_range_min' => 15000, 'salary_range_max' => 25000],
                ['title' => 'مطور برمجيات', 'salary_range_min' => 8000, 'salary_range_max' => 15000],
                ['title' => 'مصمم واجهات', 'salary_range_min' => 6000, 'salary_range_max' => 10000],
                ['title' => 'مدير قاعدة بيانات', 'salary_range_min' => 10000, 'salary_range_max' => 18000],
                ['title' => 'مهندس شبكات', 'salary_range_min' => 7000, 'salary_range_max' => 12000],
            ],
            'قسم الموارد البشرية' => [
                ['title' => 'مدير الموارد البشرية', 'salary_range_min' => 12000, 'salary_range_max' => 20000],
                ['title' => 'أخصائي موارد بشرية', 'salary_range_min' => 6000, 'salary_range_max' => 10000],
                ['title' => 'منسق تدريب', 'salary_range_min' => 5000, 'salary_range_max' => 8000],
                ['title' => 'مسؤول تعويضات ومزايا', 'salary_range_min' => 5500, 'salary_range_max' => 9000],
            ],
            'قسم المحاسبة والمالية' => [
                ['title' => 'مدير مالي', 'salary_range_min' => 14000, 'salary_range_max' => 22000],
                ['title' => 'محاسب', 'salary_range_min' => 5000, 'salary_range_max' => 9000],
                ['title' => 'مراجع حسابات', 'salary_range_min' => 7000, 'salary_range_max' => 13000],
                ['title' => 'محلل مالي', 'salary_range_min' => 6000, 'salary_range_max' => 11000],
            ],
        ];

        return $positionsMap[$departmentName] ?? [];
    }
}
