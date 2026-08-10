<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $fillable = ['role', 'permissions'];

    protected function casts(): array
    {
        return ['permissions' => 'array'];
    }

    public static function permissionsFor(string $role): array
    {
        return cache()->remember("role-permissions.{$role}", 300, fn (): array =>
            static::query()->where('role', $role)->first()?->permissions
                ?? config("role_permissions.defaults.{$role}", [])
        );
    }

    public static function clearCache(string $role): void
    {
        cache()->forget("role-permissions.{$role}");
    }
}
