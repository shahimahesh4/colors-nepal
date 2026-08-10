<?php

namespace App\Models;

use App\Models\Concerns\DeletesUploadedFiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use DeletesUploadedFiles, HasFactory;

    protected $fillable = ['name', 'role', 'company', 'content', 'rating', 'avatar', 'status', 'is_featured', 'sort_order'];


    protected function uploadedFileAttributes(): array
    {
        return ['avatar'];
    }

    protected function casts(): array
    {
        return ['is_featured' => 'boolean', 'rating' => 'integer'];
    }
}
