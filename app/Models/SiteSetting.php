<?php

namespace App\Models;

use App\Models\Concerns\DeletesUploadedFiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use DeletesUploadedFiles, HasFactory;

    protected $fillable = ['key', 'value', 'type', 'group'];


    protected function uploadedFileAttributes(): array
    {
        return ($this->type === 'image' || $this->getOriginal('type') === 'image') ? ['value'] : [];
    }

    public static function values(): Collection
    {
        return Cache::rememberForever('site-settings', fn (): Collection => static::query()->pluck('value', 'key'));
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site-settings'));
        static::deleted(fn () => Cache::forget('site-settings'));
    }
}
