<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shift;
use App\Models\Company;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();

        if ($companies->isEmpty()) {
            return;
        }

        $shifts = [
            [
                'name' => 'الشيفتة الصباحية',
                'description' => 'شيفتة العمل الصباحية من 8 صباحاً حتى 4 مساءً',
                'start_time' => '08:00',
                'end_time' => '16:00',
                'working_hours' => 8.00,
                'color' => '#007bff',
                'is_active' => true,
                'applicable_to' => 'company',
                'company_id' => $companies->first()->id,
                'work_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
                'break_start' => '12:00',
                'break_end' => '13:00',
                'break_hours' => 1.00,
            ],
            [
                'name' => 'الشيفتة المسائية',
                'description' => 'شيفتة العمل المسائية من 4 مساءً حتى 12 منتصف الليل',
                'start_time' => '16:00',
                'end_time' => '00:00',
                'working_hours' => 8.00,
                'color' => '#28a745',
                'is_active' => true,
                'applicable_to' => 'company',
                'company_id' => $companies->first()->id,
                'work_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
                'break_start' => '20:00',
                'break_end' => '20:30',
                'break_hours' => 0.50,
            ],
            [
                'name' => 'الشيفتة الليلية',
                'description' => 'شيفتة العمل الليلية من 12 منتصف الليل حتى 8 صباحاً',
                'start_time' => '00:00',
                'end_time' => '08:00',
                'working_hours' => 8.00,
                'color' => '#6f42c1',
                'is_active' => true,
                'applicable_to' => 'company',
                'company_id' => $companies->first()->id,
                'work_days' => ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
                'break_start' => '04:00',
                'break_end' => '04:30',
                'break_hours' => 0.50,
            ],
        ];

        foreach ($shifts as $shiftData) {
            Shift::create($shiftData);
        }
    }
}
