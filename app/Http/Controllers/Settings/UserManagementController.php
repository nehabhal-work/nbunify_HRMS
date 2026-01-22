<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        // VIEW: Create this blade file at resources/views/content/settings/users/index.blade.php
        return view('content.settings.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::where('is_active', true)->get();
        // VIEW: Create this blade file at resources/views/content/settings/users/create.blade.php
        return view('content.settings.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'level' => 'required|integer',
            'role_ids' => 'required|array',
            'role_ids.*' => 'exists:roles,id'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'level' => $validated['level'],
            'email_verified_at' => now(),
        ]);

        $user->roles()->sync($validated['role_ids']);

        return redirect()->route('settings.users.index')->with('success', 'User created successfully');
    }

    public function show(string $id)
    {
        $user = User::with('roles.permissions')->findOrFail($id);
        $permissions = $user->getAllPermissions();
        // VIEW: Create this blade file at resources/views/content/settings/users/view.blade.php
        return view('content.settings.users.view', compact('user', 'permissions'));
    }

    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::where('is_active', true)->get();
        // VIEW: Create this blade file at resources/views/content/settings/users/edit.blade.php
        return view('content.settings.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'level' => 'required|integer',
            'role_ids' => 'required|array',
            'role_ids.*' => 'exists:roles,id'
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'level' => $validated['level'],
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $user->roles()->sync($validated['role_ids']);
        PermissionService::clearUserPermissionsCache($user);

        return redirect()->route('settings.users.index')->with('success', 'User updated successfully');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Cannot delete your own account');
        }

        $user->delete();
        return redirect()->route('settings.users.index')->with('success', 'User deleted successfully');
    }
}
