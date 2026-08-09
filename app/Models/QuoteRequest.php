<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'assigned_to', 'name', 'email', 'phone', 'company', 'services', 'budget_min', 'budget_max', 'currency', 'timeline', 'message', 'status'];

    protected function casts(): array
    {
        return ['services' => 'array', 'budget_min' => 'integer', 'budget_max' => 'integer'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
