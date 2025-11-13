<?php

namespace App\Jobs;

use App\Services\AttendanceService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessAutoCheckout implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $attendanceService = new AttendanceService();
            $result = $attendanceService->processAutoCheckout();

            Log::info('Auto checkout processing completed', [
                'processed' => $result['processed'],
                'total_open' => $result['total_open'],
                'auto_checkout_time' => $result['auto_checkout_time']
            ]);

        } catch (\Exception $e) {
            Log::error('Error processing auto checkout job', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }
}
