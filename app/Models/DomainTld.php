<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomainTld extends Model
{
    use HasFactory;

    protected $fillable = ['extension', 'registration_price', 'renewal_price', 'currency', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['registration_price' => 'integer', 'renewal_price' => 'integer', 'is_active' => 'boolean'];
    }
}
