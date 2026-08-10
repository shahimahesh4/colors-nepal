<?php

namespace App\Filament\Resources\Concerns;

use Illuminate\Database\Eloquent\Model;

trait AuthorizesRolePermissions
{
    protected static function userCanManageResource(): bool
    {
        $permission = config('role_permissions.resources.'.static::class);

        return filled($permission) && (auth()->user()?->hasPermission($permission) ?? false);
    }

    public static function canViewAny(): bool
    {
        return static::userCanManageResource();
    }

    public static function canCreate(): bool
    {
        return static::userCanManageResource();
    }

    public static function canEdit(Model $record): bool
    {
        return static::userCanManageResource();
    }

    public static function canDelete(Model $record): bool
    {
        return static::userCanManageResource();
    }

    public static function canDeleteAny(): bool
    {
        return static::userCanManageResource();
    }
}
