<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class PermissionService
{
    public static function checkPermission(User $user, string $permission): bool
    {
        return $user->hasPermission($permission);
    }

    public static function checkAnyPermission(User $user, array $permissions): bool
    {
        return $user->hasAnyPermission($permissions);
    }

    public static function checkRole(User $user, string|array $roles): bool
    {
        return $user->hasRole($roles);
    }

    public static function getUserPermissions(User $user): array
    {
        return Cache::remember("user_{$user->id}_permissions", 3600, function () use ($user) {
            return $user->getAllPermissions();
        });
    }

    public static function clearUserPermissionsCache(User $user): void
    {
        Cache::forget("user_{$user->id}_permissions");
    }
}
