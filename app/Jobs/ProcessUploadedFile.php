<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class ProcessUploadedFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $filePath;
    /**
     * Create a new job instance.
     */
    public function __construct($filPath)
    {
        $this->filePath = $filPath;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
         try {
            $contents = Storage::disk('public')->get($this->filePath);
            $newPath = str_replace('uploads/', 'processed/', $this->filePath);
            Storage::disk('public')->put($newPath, $contents);

            Log::info("Processed file saved to: $newPath");

        } catch (\Exception $e) {
            Log::error("Failed to process file {$this->filePath}: " . $e->getMessage());
            throw $e;
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::error("File processing failed: " . $this->filePath . " | " . $exception->getMessage());
    }
}
