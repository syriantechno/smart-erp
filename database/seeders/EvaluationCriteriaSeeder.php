<?php

namespace Database\Seeders;

use App\Models\HR\EvaluationCriterion;
use Illuminate\Database\Seeder;

class EvaluationCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criteria = [
            ['Attendance', 'attendance'],
            ['Punctuality', 'punctuality'],
            ['Behavior', 'behavior'],
            ['Discipline', 'discipline'],
            ['Technical Skills', 'technical_skills'],
            ['Communication Skills', 'communication_skills'],
            ['Teamwork', 'teamwork'],
            ['Problem Solving', 'problem_solving'],
            ['Productivity', 'productivity'],
            ['Initiative', 'initiative'],
        ];

        foreach ($criteria as $index => [$name, $code]) {
            EvaluationCriterion::updateOrCreate(
                ['code' => $code],
                [
                    'name' => $name,
                    'max_score' => 10,
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
