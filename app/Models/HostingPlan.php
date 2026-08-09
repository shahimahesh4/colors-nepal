<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostingPlan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'features', 'monthly_price', 'yearly_price', 'currency', 'status', 'is_featured', 'sort_order'];

    protected function casts(): array
    {
        return ['features' => 'array', 'monthly_price' => 'integer', 'yearly_price' => 'integer', 'is_featured' => 'boolean'];
    }
}
