<?php

namespace App\Traits;

trait AuthorizesPermissions
{
    protected function authorizePermission(string $permission): void
    {
        if (!auth()->user()->hasPermission($permission)) {
            abort(403, 'Unauthorized - Missing permission: ' . $permission);
        }
    }

    protected function authorizeAnyPermission(array $permissions): void
    {
        if (!auth()->user()->hasAnyPermission($permissions)) {
            abort(403, 'Unauthorized - Missing required permissions');
        }
    }

    protected function authorizeRole(string|array $roles): void
    {
        if (!auth()->user()->hasRole($roles)) {
            abort(403, 'Unauthorized - Missing required role');
        }
    }
}
