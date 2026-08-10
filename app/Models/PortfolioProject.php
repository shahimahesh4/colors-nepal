<?php

namespace App\Models;

use App\Models\Concerns\DeletesUploadedFiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioProject extends Model
{
    use DeletesUploadedFiles, HasFactory;

    protected $fillable = ['portfolio_category_id', 'title', 'slug', 'client_name', 'summary', 'content', 'cover_image', 'technologies', 'project_url', 'completed_at', 'status', 'is_featured', 'sort_order', 'meta_title', 'meta_description', 'meta_keywords', 'og_image'];


    protected function uploadedFileAttributes(): array
    {
        return ['cover_image', 'og_image'];
    }

    protected function casts(): array
    {
        return ['technologies' => 'array', 'completed_at' => 'date', 'is_featured' => 'boolean'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PortfolioCategory::class, 'portfolio_category_id');
    }
}
