# ACL (Access Control Layer) Implementation Guide

## Overview
This system implements Role-Based Access Control (RBAC) with user groups, roles, and granular permissions.

## Database Structure

### Tables
- **roles** - User groups (Super Admin, Admin, Manager, Accountant, Data Entry)
- **permissions** - Granular permissions (clients.view, clients.create, etc.)
- **role_permission** - Pivot table linking roles to permissions
- **user_role** - Pivot table linking users to roles

## Permission Naming Convention
Format: `{module}.{action}`

Examples:
- `clients.view` - View clients
- `clients.create` - Create clients
- `clients.approve` - Approve clients
- `investments.edit` - Edit investments

## Usage

### 1. Route-Level Protection

```php
// Single permission (OR logic - user needs ANY of these)
Route::get('/clients', [ClientController::class, 'index'])
    ->middleware('permission:clients.view');

// Multiple permissions (OR logic)
Route::resource('clients', ClientController::class)
    ->middleware('permission:clients.view,clients.create,clients.edit,clients.delete');

// Role-based protection
Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('role:admin,super-admin');
```

### 2. Controller-Level Protection

Add the `AuthorizesPermissions` trait to your controller:

```php
use App\Http\Controllers\AuthorizesPermissions;

class ClientController extends Controller
{
    use AuthorizesPermissions;

    public function approve($id)
    {
        // Check single permission
        $this->authorizePermission('clients.approve');
        
        // Your logic here
    }

    public function specialAction()
    {
        // Check multiple permissions (OR logic)
        $this->authorizeAnyPermission(['clients.approve', 'clients.delete']);
        
        // Your logic here
    }

    public function adminAction()
    {
        // Check role
        $this->authorizeRole('admin');
        // or multiple roles
        $this->authorizeRole(['admin', 'super-admin']);
        
        // Your logic here
    }
}
```

### 3. Direct User Model Methods

```php
// Check if user has permission
if (auth()->user()->hasPermission('clients.create')) {
    // Allow action
}

// Check if user has any of the permissions
if (auth()->user()->hasAnyPermission(['clients.create', 'clients.edit'])) {
    // Allow action
}

// Check if user has role
if (auth()->user()->hasRole('admin')) {
    // Allow action
}

// Check multiple roles
if (auth()->user()->hasRole(['admin', 'manager'])) {
    // Allow action
}

// Get all user permissions
$permissions = auth()->user()->getAllPermissions();
```

### 4. Using PermissionService

```php
use App\Services\PermissionService;

// Check permission
if (PermissionService::checkPermission(auth()->user(), 'clients.create')) {
    // Allow action
}

// Check any permission
if (PermissionService::checkAnyPermission(auth()->user(), ['clients.create', 'clients.edit'])) {
    // Allow action
}

// Get cached user permissions
$permissions = PermissionService::getUserPermissions(auth()->user());

// Clear permission cache (call after role/permission changes)
PermissionService::clearUserPermissionsCache(auth()->user());
```

## Available Roles

1. **Super Admin** - Full system access
2. **Admin** - Administrative access with approval rights
3. **Manager** - Manager with approval permissions
4. **Accountant** - Accounts module access
5. **Data Entry** - Basic data entry access

## Available Permissions by Module

### Masters Module
- companies.view, companies.create, companies.edit, companies.delete
- head-offices.view, head-offices.create, head-offices.edit, head-offices.delete
- branches.view, branches.create, branches.edit, branches.delete
- departments.view, departments.create, departments.edit, departments.delete
- designations.view, designations.create, designations.edit, designations.delete
- employees.view, employees.create, employees.edit, employees.delete

### Clients Module
- clients.view, clients.create, clients.edit, clients.delete, clients.approve
- client-families.view, client-families.create, client-families.edit, client-families.delete
- client-banks.view, client-banks.create, client-banks.edit, client-banks.delete
- preclients.view, preclients.create, preclients.edit, preclients.delete

### Investment Module
- schemes.view, schemes.create, schemes.edit, schemes.delete, schemes.approve
- investments.view, investments.create, investments.edit, investments.delete, investments.approve
- investment-si.view, investment-si.create, investment-si.edit, investment-si.delete, investment-si.approve

### Accounts Module
- vendors.view, vendors.create, vendors.edit, vendors.delete
- purchases.view, purchases.create, purchases.edit, purchases.delete
- sales.view, sales.create, sales.edit, sales.delete
- expenses.view, expenses.create, expenses.edit, expenses.delete
- ledger.view

### Settings Module
- roles.manage, permissions.manage, users.manage

## Managing Roles and Permissions

### Assign Role to User
```php
$user = User::find($userId);
$role = Role::where('slug', 'admin')->first();
$user->roles()->attach($role->id);
```

### Remove Role from User
```php
$user->roles()->detach($roleId);
```

### Assign Permission to Role
```php
$role = Role::find($roleId);
$permission = Permission::where('slug', 'clients.create')->first();
$role->permissions()->attach($permission->id);
```

### Sync Multiple Permissions to Role
```php
$role->permissions()->sync([1, 2, 3, 4]); // permission IDs
```

## Seeding

Run migrations and seeders:
```bash
php artisan migrate
php artisan db:seed
```

Or seed specific seeders:
```bash
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=UserSeeder
```

## Best Practices

1. **Always use middleware on routes** - First line of defense
2. **Add controller checks for sensitive actions** - Double protection for critical operations
3. **Clear permission cache** - After changing user roles or role permissions
4. **Use descriptive permission names** - Follow the module.action convention
5. **Keep level field** - Maintain backward compatibility with existing level-based checks

## Troubleshooting

### User can't access route
1. Check if user has assigned role: `$user->roles`
2. Check if role has required permission: `$role->permissions`
3. Clear permission cache: `PermissionService::clearUserPermissionsCache($user)`

### Permission not working
1. Verify permission exists in database
2. Verify role has the permission assigned
3. Check middleware is registered in bootstrap/app.php
4. Check route has correct middleware applied

## Migration from Level-Based System

The `level` field is maintained for backward compatibility. New ACL system works alongside it.

To migrate:
1. Assign appropriate roles to users based on their level
2. Gradually replace level checks with permission checks
3. Eventually deprecate level field (optional)
