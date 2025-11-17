<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting\PrefixSetting;

class CreateProjectsPrefixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrefixSetting::updateOrCreate(
            ['document_type' => 'projects'],
            [
                'prefix' => 'PRJ',
                'padding' => 4,
                'start_number' => 1,
                'current_number' => 1,
                'include_year' => false,
                'is_active' => true,
            ]
        );

        $this->command->info('Projects prefix setting created successfully!');
    }
}
