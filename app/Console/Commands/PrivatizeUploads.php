<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PrivatizeUploads extends Command
{
    protected $signature = 'uploads:privatize';
    protected $description = 'Move legacy public portraits into authenticated private storage';

    public function handle(): int
    {
        $target = storage_path('app/private/releveurs');
        File::ensureDirectoryExists($target, 0750);
        $files = array_filter(File::files(public_path('uploads')), fn ($file) => $file->getFilename() !== '.gitkeep');
        foreach ($files as $file) {
            if (file_exists($target.'/'.$file->getFilename())) {
                $this->error('Destination conflict; no files moved. Resolve duplicate filenames first.');
                return self::FAILURE;
            }
        }
        foreach ($files as $file) {
            File::move($file->getPathname(), $target.'/'.$file->getFilename());
        }
        $this->info(count($files).' files moved to private storage.');
        return self::SUCCESS;
    }
}
