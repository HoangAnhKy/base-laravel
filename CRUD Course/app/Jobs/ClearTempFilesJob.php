<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ClearTempFilesJob implements ShouldQueue
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
        //
        try {
            // Chạy lệnh Artisan để xóa các file temp
            Artisan::call('temp:clear');
            Log::info('ClearTempFilesJob: files:cleartemp executed successfully.');
        } catch (\Exception $e) {
            Log::error('ClearTempFilesJob: Error executing files:cleartemp - ' . $e->getMessage());
        }

        // Dispatch lại job sau 1 phút để chạy tiếp
        self::dispatch()->delay(now()->addMinute());
    }
}
