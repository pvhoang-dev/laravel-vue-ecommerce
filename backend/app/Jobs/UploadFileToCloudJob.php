<?php

namespace App\Jobs;

use App\Models\ProductImage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadFileToCloudJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected ProductImage $productImage)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $model = $this->productImage;
        $localPath = Storage::path($model->path);
        Log::debug("Uploading file on S3. " . $localPath);
        try {
            $success = Storage::disk('s3')->put('ecom/' . $model->path, Storage::disk('public')->get($model->path));
            if ($success) {
                Log::debug("Uploaded. Updating the database.");
            } else {
                Log::error('Unable to upload files to S3');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
