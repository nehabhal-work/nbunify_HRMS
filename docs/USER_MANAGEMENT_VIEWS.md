# User Management Views Guide

## Overview
Simple user management interface where you can create/edit users and assign roles to them.

**Only Super Admin and Admin roles** can access these pages.

---

## Views to Create

### 1. Users List Page
**Location:** `resources/views/content/settings/users/index.blade.php`  
**Route:** `/settings/users`  
**Controller Method:** `UserManagementController@index`

**Data Available:**
```php
$users // Collection of users with their roles
```

**What to Display:**
- Table with columns: Name, Email, Level, Roles, Actions
- Create New User button
- Edit/Delete buttons per user
- Show roles as badges/chips

**Sample Structure:**
```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h2>User Management</h2>
        <a href="{{ route('settings.users.create') }}" class="btn btn-primary">
            Create New User
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Level</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->level }}</td>
                <td>
                    @foreach($user->roles as $role)
                        <span class="badge bg-primary">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('settings.users.show', $user->id) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('settings.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('settings.users.destroy', $user->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
```

---

### 2. Create User Page
**Location:** `resources/views/content/settings/users/create.blade.php`  
**Route:** `/settings/users/create`  
**Controller Method:** `UserManagementController@create`

**Data Available:**
```php
$roles // Collection of active roles
```

**Form Fields:**
- Name (text input) - required
- Email (email input) - required, unique
- Password (password input) - required, min 8 characters
- Level (number input) - required (1, 2, or 3)
- Roles (checkboxes or multi-select) - required, at least one role

**Sample Structure:**
```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New User</h2>

    <form action="{{ route('settings.users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                   id="password" name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <select class="form-control @error('level') is-invalid @enderror" 
                    id="level" name="level" required>
                <option value="">Select Level</option>
                <option value="1" {{ old('level') == 1 ? 'selected' : '' }}>Level 1 - Data Entry</option>
                <option value="2" {{ old('level') == 2 ? 'selected' : '' }}>Level 2 - Manager</option>
                <option value="3" {{ old('level') == 3 ? 'selected' : '' }}>Level 3 - Admin</option>
            </select>
            @error('level')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Assign Roles</label>
            @foreach($roles as $role)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" 
                           name="role_ids[]" value="{{ $role->id }}" 
                           id="role_{{ $role->id }}"
                           {{ in_array($role->id, old('role_ids', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="role_{{ $role->id }}">
                        {{ $role->name }}
                        <small class="text-muted">- {{ $role->description }}</small>
                    </label>
                </div>
            @endforeach
            @error('role_ids')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create User</button>
        <a href="{{ route('settings.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
```

---

### 3. Edit User Page
**Location:** `resources/views/content/settings/users/edit.blade.php`  
**Route:** `/settings/users/{id}/edit`  
**Controller Method:** `UserManagementController@edit`

**Data Available:**
```php
$user  // User model with roles
$roles // Collection of active roles
```

**Form Fields:**
- Same as create, but:
  - Pre-filled with user data
  - Password is optional (only if changing)
  - Roles are pre-selected based on user's current roles

**Sample Structure:**
```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit User: {{ $user->name }}</h2>

    <form action="{{ route('settings.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (leave blank to keep current)</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                   id="password" name="password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <select class="form-control @error('level') is-invalid @enderror" 
                    id="level" name="level" required>
                <option value="1" {{ old('level', $user->level) == 1 ? 'selected' : '' }}>Level 1 - Data Entry</option>
                <option value="2" {{ old('level', $user->level) == 2 ? 'selected' : '' }}>Level 2 - Manager</option>
                <option value="3" {{ old('level', $user->level) == 3 ? 'selected' : '' }}>Level 3 - Admin</option>
            </select>
            @error('level')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Assign Roles</label>
            @php
                $userRoleIds = old('role_ids', $user->roles->pluck('id')->toArray());
            @endphp
            @foreach($roles as $role)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" 
                           name="role_ids[]" value="{{ $role->id }}" 
                           id="role_{{ $role->id }}"
                           {{ in_array($role->id, $userRoleIds) ? 'checked' : '' }}>
                    <label class="form-check-label" for="role_{{ $role->id }}">
                        {{ $role->name }}
                        <small class="text-muted">- {{ $role->description }}</small>
                    </label>
                </div>
            @endforeach
            @error('role_ids')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="{{ route('settings.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
```

---

### 4. View User Page (Optional)
**Location:** `resources/views/content/settings/users/view.blade.php`  
**Route:** `/settings/users/{id}`  
**Controller Method:** `UserManagementController@show`

**Data Available:**
```php
$user        // User model with roles and permissions
$permissions // Array of permission slugs
```

**What to Display:**
- User details (name, email, level)
- Assigned roles
- Effective permissions (all permissions from all roles)
- Edit button

**Sample Structure:**
```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h2>User Details</h2>
        <a href="{{ route('settings.users.edit', $user->id) }}" class="btn btn-warning">Edit User</a>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>Basic Information</h5>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Level:</strong> {{ $user->level }}</p>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5>Assigned Roles</h5>
            @foreach($user->roles as $role)
                <span class="badge bg-primary me-2">{{ $role->name }}</span>
            @endforeach
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5>Effective Permissions ({{ count($permissions) }})</h5>
            <div class="row">
                @foreach($permissions as $permission)
                    <div class="col-md-4">
                        <small>• {{ $permission }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <a href="{{ route('settings.users.index') }}" class="btn btn-secondary mt-3">Back to Users</a>
</div>
@endsection
```

---

## Available Roles

When creating/editing users, these roles will be available:

1. **Super Admin** - Full system access with all permissions
2. **Admin** - Administrative access with approval rights
3. **Manager** - Manager with approval permissions
4. **Accountant** - Accounts module access
5. **Data Entry** - Basic data entry access

---

## Validation Rules

### Create User
- `name`: required, string, max 255
- `email`: required, email, unique
- `password`: required, string, min 8
- `level`: required, integer (1, 2, or 3)
- `role_ids`: required, array, at least one role

### Update User
- Same as create, except:
- `email`: unique except current user
- `password`: optional (nullable)

---

## Flash Messages

The controller returns these flash messages:

**Success:**
- "User created successfully"
- "User updated successfully"
- "User deleted successfully"

**Error:**
- "Cannot delete your own account"

Display them in your layout:
```blade
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
```

---

## Routes Available

```php
GET    /settings/users           - List all users
GET    /settings/users/create    - Show create form
POST   /settings/users           - Store new user
GET    /settings/users/{id}      - View user details
GET    /settings/users/{id}/edit - Show edit form
PUT    /settings/users/{id}      - Update user
DELETE /settings/users/{id}      - Delete user
```

---

## Notes

1. **Only Super Admin and Admin** can access these pages (protected by middleware)
2. **Users cannot delete themselves** (validation in controller)
3. **At least one role must be assigned** to each user
4. **Password is optional** when editing (only update if provided)
5. **Permission cache is cleared** automatically when roles are updated
6. **Level field is maintained** for backward compatibility

---

## Quick Checklist

- [ ] Create `resources/views/content/settings/users/index.blade.php`
- [ ] Create `resources/views/content/settings/users/create.blade.php`
- [ ] Create `resources/views/content/settings/users/edit.blade.php`
- [ ] Create `resources/views/content/settings/users/view.blade.php` (optional)
- [ ] Add navigation link to user management page
- [ ] Test create user with role assignment
- [ ] Test edit user and change roles
- [ ] Test delete user
- [ ] Verify permissions work after role assignment
