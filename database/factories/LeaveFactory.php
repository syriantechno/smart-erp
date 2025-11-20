<?php

namespace Database\Factories;

use App\Models\HR\Employee;
use App\Models\HR\Leave;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\HR\Leave>
 */
class LeaveFactory extends Factory
{
    protected $model = Leave::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $employee = Employee::inRandomOrder()->first();

        $start = $this->faker->dateTimeBetween('-2 months', '+2 months');
        $end = (clone $start)->modify('+' . $this->faker->numberBetween(1, 7) . ' days');

        $types = ['annual', 'sick', 'unpaid', 'emergency', 'maternity'];
        $reasons = ['vacation', 'medical', 'family', 'remote', 'other'];
        $statuses = ['pending', 'approved', 'rejected'];

        return [
            'code' => 'LV-' . Str::upper(Str::random(7)),
            'employee_id' => $employee?->id ?? Employee::factory(),
            'department_id' => $employee?->department_id,
            'company_id' => $employee?->company_id,
            'leave_type' => $this->faker->randomElement($types),
            'reason_category' => $this->faker->randomElement($reasons),
            'start_date' => $start,
            'end_date' => $end,
            'days_count' => max($start->diff($end)->days + 1, 1),
            'is_paid' => $this->faker->boolean(80),
            'status' => $this->faker->randomElement($statuses),
            'reason_details' => $this->faker->sentence(8),
            'notes' => $this->faker->boolean(40) ? $this->faker->sentence(10) : null,
            'approved_by' => null,
            'approved_at' => null,
        };
    }
}
