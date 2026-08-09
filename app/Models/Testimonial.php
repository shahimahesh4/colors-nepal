<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'role', 'company', 'content', 'rating', 'avatar', 'status', 'is_featured', 'sort_order'];

    protected function casts(): array
    {
        return ['is_featured' => 'boolean', 'rating' => 'integer'];
    }
}
