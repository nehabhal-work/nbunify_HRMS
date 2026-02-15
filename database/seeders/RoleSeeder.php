<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Full system access with all permissions',
                'permissions' => 'all'
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrative access with approval rights',
                'permissions' => [
                    'companies.*', 'head-offices.*', 'branches.*', 'departments.*', 'designations.*', 'employees.*',
                    'clients.*', 'client-families.*', 'client-banks.*', 'preclients.*',
                    'schemes.*', 'investments.*', 'investment-si.*',
                    'vendors.*', 'purchases.*', 'sales.*', 'expenses.*', 'ledger.view'
                ]
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'description' => 'Manager with approval permissions',
                'permissions' => [
                    'clients.view', 'clients.approve', 'clients.edit','clients.create',
                    'client-families.view', 'client-banks.view',
                    'schemes.view', 'schemes.create', 'schemes.edit','schemes.approve',
                    'investments.view', 'investments.approve', 'investment-si.view', 'investment-si.approve',
                    'vendors.view', 'purchases.view', 'sales.view', 'expenses.view', 'ledger.view',
                    'investments.mark-paid',
                ]
            ],
            [
                'name' => 'Accountant',
                'slug' => 'accountant',
                'description' => 'Accounts module access',
                'permissions' => [
                    'vendors.*', 'purchases.*', 'sales.*', 'expenses.*', 'ledger.view',
                    'clients.view', 'investments.view', 'investment-si.*','investment-si.approve',
                    'investments.mark-paid',
                ]
            ],
            [
                'name' => 'Data Entry',
                'slug' => 'data-entry',
                'description' => 'Basic data entry access',
                'permissions' => [
                    'clients.view', 'clients.approve', 'clients.edit','clients.create',
                    'client-families.view', 'client-families.create', 'client-families.edit',
                    'client-banks.view', 'client-banks.create', 'client-banks.edit',
                    'preclients.*',
                    'schemes.view', 'schemes.create', 'schemes.edit','schemes.approve',
                    'investments.*',
                    'investment-si.view', 'investment-si.create', 'investment-si.edit'
                ]
            ],
        ];

        foreach ($roles as $roleData) {
            $role = Role::updateOrCreate(
                ['slug' => $roleData['slug']],
                [
                    'name' => $roleData['name'],
                    'description' => $roleData['description'],
                    'is_active' => true
                ]
            );

            if ($roleData['permissions'] === 'all') {
                $permissions = Permission::all();
                $role->permissions()->sync($permissions->pluck('id'));
            } else {
                $permissionIds = [];
                foreach ($roleData['permissions'] as $permSlug) {
                    if (str_ends_with($permSlug, '.*')) {
                        $module = str_replace('.*', '', $permSlug);
                        $perms = Permission::where('slug', 'like', $module . '.%')->pluck('id');
                        $permissionIds = array_merge($permissionIds, $perms->toArray());
                    } else {
                        $perm = Permission::where('slug', $permSlug)->first();
                        if ($perm) $permissionIds[] = $perm->id;
                    }
                }
                $role->permissions()->sync(array_unique($permissionIds));
            }
        }
    }
}
