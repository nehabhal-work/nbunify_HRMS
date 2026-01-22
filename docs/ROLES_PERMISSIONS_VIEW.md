# Roles & Permissions View (Read-Only)

## Overview
A read-only page that displays all roles and their assigned permissions. This helps users understand what access each role has.

**Access:** All authenticated users can view this page (no special role required)

---

## View to Create

### Roles & Permissions Page (Read-Only)
**Location:** `resources/views/content/settings/roles-permissions/index.blade.php`  
**Route:** `/settings/roles-permissions`  
**Controller Method:** `RolePermissionViewController@index`

**Data Available:**
```php
$roles                // Collection of roles with their permissions
$permissionsByModule  // Permissions grouped by module (masters, clients, investment, accounts)
```

---

## Sample Blade Template

```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Roles & Permissions</h2>
    <p class="text-muted">View all available roles and their permissions</p>

    @foreach($roles as $role)
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                {{ $role->name }}
                @if(!$role->is_active)
                    <span class="badge bg-secondary">Inactive</span>
                @endif
            </h4>
            <small>{{ $role->description }}</small>
        </div>
        <div class="card-body">
            @php
                $rolePermissions = $role->permissions->groupBy('module');
            @endphp

            @if($rolePermissions->isEmpty())
                <p class="text-muted">No permissions assigned to this role.</p>
            @else
                <div class="row">
                    @foreach($rolePermissions as $module => $permissions)
                    <div class="col-md-6 mb-3">
                        <h6 class="text-uppercase text-primary">{{ ucfirst($module) }} Module</h6>
                        <ul class="list-unstyled">
                            @foreach($permissions as $permission)
                            <li>
                                <i class="bi bi-check-circle text-success"></i>
                                {{ $permission->name }}
                                <small class="text-muted">({{ $permission->slug }})</small>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection
```

---

## Alternative Layout: Accordion Style

```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Roles & Permissions</h2>
    <p class="text-muted">View all available roles and their permissions</p>

    <div class="accordion" id="rolesAccordion">
        @foreach($roles as $index => $role)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{ $role->id }}">
                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapse{{ $role->id }}" 
                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                        aria-controls="collapse{{ $role->id }}">
                    <strong>{{ $role->name }}</strong>
                    <span class="ms-2 text-muted">- {{ $role->description }}</span>
                    <span class="badge bg-primary ms-auto">{{ $role->permissions->count() }} permissions</span>
                </button>
            </h2>
            <div id="collapse{{ $role->id }}" 
                 class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                 aria-labelledby="heading{{ $role->id }}" 
                 data-bs-parent="#rolesAccordion">
                <div class="accordion-body">
                    @php
                        $rolePermissions = $role->permissions->groupBy('module');
                    @endphp

                    @if($rolePermissions->isEmpty())
                        <p class="text-muted">No permissions assigned to this role.</p>
                    @else
                        <div class="row">
                            @foreach($rolePermissions as $module => $permissions)
                            <div class="col-md-6 mb-3">
                                <h6 class="text-uppercase text-primary">
                                    <i class="bi bi-folder"></i> {{ ucfirst($module) }} Module
                                </h6>
                                <ul class="list-group list-group-flush">
                                    @foreach($permissions as $permission)
                                    <li class="list-group-item">
                                        <i class="bi bi-check-circle text-success"></i>
                                        {{ $permission->name }}
                                        <br>
                                        <small class="text-muted">{{ $permission->slug }}</small>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
```

---

## Alternative Layout: Table/Matrix View

```blade
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Roles & Permissions Matrix</h2>
    <p class="text-muted">Quick overview of which roles have which permissions</p>

    @foreach($permissionsByModule as $module => $permissions)
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">{{ ucfirst($module) }} Module</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Permission</th>
                            @foreach($roles as $role)
                            <th class="text-center">{{ $role->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td>
                                {{ $permission->name }}
                                <br>
                                <small class="text-muted">{{ $permission->slug }}</small>
                            </td>
                            @foreach($roles as $role)
                            <td class="text-center">
                                @if($role->permissions->contains('id', $permission->id))
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                @else
                                    <i class="bi bi-x-circle text-muted"></i>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
```

---

## What Each Layout Shows:

### 1. Card Layout (First Sample)
- Each role in a separate card
- Permissions grouped by module inside each card
- Clean and easy to read
- **Best for:** Viewing one role at a time

### 2. Accordion Layout (Second Sample)
- Collapsible sections for each role
- Saves space, shows all roles at once
- Click to expand and see permissions
- **Best for:** Many roles, quick overview

### 3. Matrix/Table Layout (Third Sample)
- Grid showing roles vs permissions
- Checkmarks show which role has which permission
- Grouped by module
- **Best for:** Comparing roles side-by-side

---

## Available Roles (From Seeder):

1. **Super Admin** - Full system access with all permissions
2. **Admin** - Administrative access with approval rights
3. **Manager** - Manager with approval permissions
4. **Accountant** - Accounts module access
5. **Data Entry** - Basic data entry access

---

## Permission Modules:

- **Masters** - Companies, Branches, Departments, Designations, Employees
- **Clients** - Clients, Client Families, Client Banks, Pre-clients
- **Investment** - Schemes, Investments, Investment SI
- **Accounts** - Vendors, Purchases, Sales, Expenses, Ledger
- **Settings** - Roles, Permissions, Users

---

## Route Information:

**URL:** `/settings/roles-permissions`  
**Route Name:** `settings.roles-permissions`  
**Access:** All authenticated users (no role restriction)  
**Method:** GET

---

## Usage in Navigation:

Add this link to your settings menu:

```blade
<a href="{{ route('settings.roles-permissions') }}" class="nav-link">
    <i class="bi bi-shield-check"></i> Roles & Permissions
</a>
```

---

## Notes:

1. **Read-only** - No edit/delete buttons, just viewing
2. **All users can access** - Helps everyone understand role structure
3. **Shows active roles only** - Inactive roles are marked but still shown
4. **Grouped by module** - Easy to see module-level permissions
5. **No sensitive data** - Just role names and permission names

---

## Quick Checklist:

- [ ] Create `resources/views/content/settings/roles-permissions/index.blade.php`
- [ ] Choose layout style (Card, Accordion, or Matrix)
- [ ] Add navigation link to settings menu
- [ ] Test with different user roles
- [ ] Verify all roles and permissions display correctly
