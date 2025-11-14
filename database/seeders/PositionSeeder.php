<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        // Get first department or create one if none exists
        $department = Department::first();
        if (!$department) {
            $department = Department::create([
                'name' => 'Information Technology',
                'code' => 'IT001',
                'is_active' => true,
            ]);
        }

        $positions = [
            [
                'title' => 'Software Developer',
                'description' => 'Develop and maintain software applications',
                'department_id' => $department->id,
                'salary_range_min' => 3000.00,
                'salary_range_max' => 6000.00,
                'is_active' => true,
            ],
            [
                'title' => 'Project Manager',
                'description' => 'Manage software development projects',
                'department_id' => $department->id,
                'salary_range_min' => 4000.00,
                'salary_range_max' => 8000.00,
                'is_active' => true,
            ],
            [
                'title' => 'System Analyst',
                'description' => 'Analyze system requirements and design solutions',
                'department_id' => $department->id,
                'salary_range_min' => 3500.00,
                'salary_range_max' => 7000.00,
                'is_active' => true,
            ],
            [
                'title' => 'Quality Assurance Engineer',
                'description' => 'Test software applications and ensure quality',
                'department_id' => $department->id,
                'salary_range_min' => 2800.00,
                'salary_range_max' => 5500.00,
                'is_active' => true,
            ],
            [
                'title' => 'DevOps Engineer',
                'description' => 'Manage infrastructure and deployment processes',
                'department_id' => $department->id,
                'salary_range_min' => 3500.00,
                'salary_range_max' => 7500.00,
                'is_active' => true,
            ],
        ];

        foreach ($positions as $positionData) {
            Position::create($positionData);
        }
    }
}
