<?php

namespace App\Models;

use App\Models\Concerns\DeletesUploadedFiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Service extends Model
{
    use DeletesUploadedFiles, HasFactory;

    protected $fillable = ['title', 'slug', 'summary', 'content', 'icon', 'image', 'status', 'is_featured', 'sort_order', 'meta_title', 'meta_description', 'meta_keywords', 'og_image'];

    protected function uploadedFileAttributes(): array
    {
        return ['image', 'og_image'];
    }

    protected function casts(): array
    {
        return ['is_featured' => 'boolean'];
    }

    public function features(): HasMany
    {
        return $this->hasMany(ServiceFeature::class)->orderBy('sort_order');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(ServiceFaq::class)->orderBy('sort_order');
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('header-services'));
        static::deleted(fn () => Cache::forget('header-services'));
    }
}
