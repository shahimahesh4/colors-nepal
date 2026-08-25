<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

trait DeletesUploadedFiles
{
    abstract protected function uploadedFileAttributes(): array;

    protected static function bootDeletesUploadedFiles(): void
    {
        static::updated(function ($model): void {
            foreach ($model->uploadedFileAttributes() as $attribute) {
                if ($model->wasChanged($attribute)) {
                    $model->deleteUploadedFile($model->getOriginal($attribute));
                }
            }
        });

        static::deleted(function ($model): void {
            foreach ($model->uploadedFileAttributes() as $attribute) {
                $model->deleteUploadedFile($model->getAttribute($attribute));
            }
        });
    }

    protected function deleteUploadedFile(mixed $path): void
    {
        if (is_string($path)
            && $path !== ''
            && ! str_starts_with($path, 'banners/library/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
