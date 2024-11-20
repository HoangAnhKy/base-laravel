<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'app:clear-temp-files';
    protected $signature = 'temp:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear temporary files in storage/temp folder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tempPath = storage_path('app/private/temp');
        $filesCleared = 0;

        if (File::exists($tempPath)) {
            foreach (glob($tempPath . '/*') as $file) {
                if (filemtime($file) < (time())) {
                    unlink($file);
                    $filesCleared++;
                }
            }
        }

        $this->info("Cleared $filesCleared temporary file(s).");
    }
}
