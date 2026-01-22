<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionViewController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->where('is_active', true)->get();
        $permissionsByModule = Permission::all()->groupBy('module');
        
        // VIEW: Create this blade file at resources/views/content/settings/roles-permissions/index.blade.php
        return view('content.settings.roles-permissions.index', compact('roles', 'permissionsByModule'));
    }
}
