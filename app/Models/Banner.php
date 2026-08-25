<?php

namespace App\Models;

use App\Models\Concerns\DeletesUploadedFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use DeletesUploadedFiles;

    public const DEFAULT_IMAGE = 'settings/home-hero-default.png';

    protected $fillable = [
        'page_key', 'title', 'description', 'image', 'button_text', 'button_url', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    protected function uploadedFileAttributes(): array
    {
        return ['image'];
    }

    protected function deleteUploadedFile(mixed $path): void
    {
        if (is_string($path)
            && $path !== ''
            && $path !== self::DEFAULT_IMAGE
            && ! str_starts_with($path, 'banners/library/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
