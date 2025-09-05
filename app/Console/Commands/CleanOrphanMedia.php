<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;

class CleanOrphanMedia extends Command
{
    protected $signature = 'media:clean-orphans';
    protected $description = 'Delete media records for missing files';

    public function handle()
    {
        Media::where('model_type', 'App\Models\User')->delete();
        
        Media::all()->each(function ($media) {
            if (!Storage::exists($media->getPath())) {
                $media->delete();
                $this->info("Deleted orphan media: {$media->id}");
            }
        });
    }
}