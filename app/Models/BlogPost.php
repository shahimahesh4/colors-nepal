<?php

namespace App\Models;

use App\Models\Concerns\DeletesUploadedFiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPost extends Model
{
    use DeletesUploadedFiles, HasFactory;

    protected $fillable = ['user_id', 'blog_category_id', 'title', 'slug', 'excerpt', 'content', 'featured_image', 'status', 'published_at', 'meta_title', 'meta_description', 'meta_keywords', 'og_image'];


    protected function uploadedFileAttributes(): array
    {
        return ['featured_image', 'og_image'];
    }

    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
}
