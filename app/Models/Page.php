<?php

namespace App\Models;

use App\Models\Concerns\DeletesUploadedFiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Page extends Model
{
    use DeletesUploadedFiles, HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
    ];

    protected function uploadedFileAttributes(): array
    {
        return ['image', 'og_image'];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('public-sitemap-data'));
        static::deleted(fn () => Cache::forget('public-sitemap-data'));
    }
}
