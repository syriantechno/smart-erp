<?php

namespace App\Console\Commands;

use App\Services\AttendanceService;
use Illuminate\Console\Command;

class GenerateAutoAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:generate-auto {--date= : Date to generate attendance for (YYYY-MM-DD)} {--all : Generate for all employees}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate automatic attendance records for employees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $attendanceService = new AttendanceService();
        $date = $this->option('date') ?: now()->format('Y-m-d');

        $this->info("Generating auto attendance for date: {$date}");

        $result = $attendanceService->generateAutoAttendance($date);

        $this->info("Auto attendance generation completed:");
        $this->line("- Date: {$result['date']}");
        $this->line("- Created: {$result['created']} records");
        $this->line("- Skipped: {$result['skipped']} records");
        $this->line("- Total employees: {$result['total']}");

        return 0;
    }
}
