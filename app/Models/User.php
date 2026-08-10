<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'phone', 'password', 'is_admin', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed', 'is_admin' => 'boolean'];
    }

    protected static function booted(): void
    {
        static::saving(function (User $user): void {
            if ($user->isDirty('role')) {
                $user->is_admin = $user->role === 'admin';
            } elseif ($user->isDirty('is_admin')) {
                $user->role = $user->is_admin ? 'admin' : ($user->role ?: 'customer');
            }
        });
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->role === 'admin' || $this->is_admin) {
            return true;
        }

        return in_array($permission, RolePermission::permissionsFor($this->role ?: 'customer'), true);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'admin' && $this->hasPermission('access_admin_panel');
    }

    public function blogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class);
    }

    public function quoteRequests(): HasMany
    {
        return $this->hasMany(QuoteRequest::class);
    }

    public function assignedQuoteRequests(): HasMany
    {
        return $this->hasMany(QuoteRequest::class, 'assigned_to');
    }
}
