<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Masters Module
            ['name' => 'View Companies', 'slug' => 'companies.view', 'module' => 'masters'],
            ['name' => 'Create Companies', 'slug' => 'companies.create', 'module' => 'masters'],
            ['name' => 'Edit Companies', 'slug' => 'companies.edit', 'module' => 'masters'],
            ['name' => 'Delete Companies', 'slug' => 'companies.delete', 'module' => 'masters'],
            
            ['name' => 'View Head Offices', 'slug' => 'head-offices.view', 'module' => 'masters'],
            ['name' => 'Create Head Offices', 'slug' => 'head-offices.create', 'module' => 'masters'],
            ['name' => 'Edit Head Offices', 'slug' => 'head-offices.edit', 'module' => 'masters'],
            ['name' => 'Delete Head Offices', 'slug' => 'head-offices.delete', 'module' => 'masters'],
            
            ['name' => 'View Branches', 'slug' => 'branches.view', 'module' => 'masters'],
            ['name' => 'Create Branches', 'slug' => 'branches.create', 'module' => 'masters'],
            ['name' => 'Edit Branches', 'slug' => 'branches.edit', 'module' => 'masters'],
            ['name' => 'Delete Branches', 'slug' => 'branches.delete', 'module' => 'masters'],
            
            ['name' => 'View Departments', 'slug' => 'departments.view', 'module' => 'masters'],
            ['name' => 'Create Departments', 'slug' => 'departments.create', 'module' => 'masters'],
            ['name' => 'Edit Departments', 'slug' => 'departments.edit', 'module' => 'masters'],
            ['name' => 'Delete Departments', 'slug' => 'departments.delete', 'module' => 'masters'],
            
            ['name' => 'View Designations', 'slug' => 'designations.view', 'module' => 'masters'],
            ['name' => 'Create Designations', 'slug' => 'designations.create', 'module' => 'masters'],
            ['name' => 'Edit Designations', 'slug' => 'designations.edit', 'module' => 'masters'],
            ['name' => 'Delete Designations', 'slug' => 'designations.delete', 'module' => 'masters'],
            
            ['name' => 'View Employees', 'slug' => 'employees.view', 'module' => 'masters'],
            ['name' => 'Create Employees', 'slug' => 'employees.create', 'module' => 'masters'],
            ['name' => 'Edit Employees', 'slug' => 'employees.edit', 'module' => 'masters'],
            ['name' => 'Delete Employees', 'slug' => 'employees.delete', 'module' => 'masters'],
            
            // Clients Module
            ['name' => 'View Clients', 'slug' => 'clients.view', 'module' => 'clients'],
            ['name' => 'Create Clients', 'slug' => 'clients.create', 'module' => 'clients'],
            ['name' => 'Edit Clients', 'slug' => 'clients.edit', 'module' => 'clients'],
            ['name' => 'Delete Clients', 'slug' => 'clients.delete', 'module' => 'clients'],
            ['name' => 'Approve Clients', 'slug' => 'clients.approve', 'module' => 'clients'],
            
            ['name' => 'View Client Families', 'slug' => 'client-families.view', 'module' => 'clients'],
            ['name' => 'Create Client Families', 'slug' => 'client-families.create', 'module' => 'clients'],
            ['name' => 'Edit Client Families', 'slug' => 'client-families.edit', 'module' => 'clients'],
            ['name' => 'Delete Client Families', 'slug' => 'client-families.delete', 'module' => 'clients'],
            
            ['name' => 'View Client Banks', 'slug' => 'client-banks.view', 'module' => 'clients'],
            ['name' => 'Create Client Banks', 'slug' => 'client-banks.create', 'module' => 'clients'],
            ['name' => 'Edit Client Banks', 'slug' => 'client-banks.edit', 'module' => 'clients'],
            ['name' => 'Delete Client Banks', 'slug' => 'client-banks.delete', 'module' => 'clients'],
            
            ['name' => 'View Pre-Clients', 'slug' => 'preclients.view', 'module' => 'clients'],
            ['name' => 'Create Pre-Clients', 'slug' => 'preclients.create', 'module' => 'clients'],
            ['name' => 'Edit Pre-Clients', 'slug' => 'preclients.edit', 'module' => 'clients'],
            ['name' => 'Delete Pre-Clients', 'slug' => 'preclients.delete', 'module' => 'clients'],
            
            // Investment Module
            ['name' => 'View Schemes', 'slug' => 'schemes.view', 'module' => 'investment'],
            ['name' => 'Create Schemes', 'slug' => 'schemes.create', 'module' => 'investment'],
            ['name' => 'Edit Schemes', 'slug' => 'schemes.edit', 'module' => 'investment'],
            ['name' => 'Delete Schemes', 'slug' => 'schemes.delete', 'module' => 'investment'],
            ['name' => 'Approve Schemes', 'slug' => 'schemes.approve', 'module' => 'investment'],
            
            ['name' => 'View Investments', 'slug' => 'investments.view', 'module' => 'investment'],
            ['name' => 'Create Investments', 'slug' => 'investments.create', 'module' => 'investment'],
            ['name' => 'Edit Investments', 'slug' => 'investments.edit', 'module' => 'investment'],
            ['name' => 'Delete Investments', 'slug' => 'investments.delete', 'module' => 'investment'],
            ['name' => 'Approve Investments', 'slug' => 'investments.approve', 'module' => 'investment'],
            
            ['name' => 'View Investment SI', 'slug' => 'investment-si.view', 'module' => 'investment'],
            ['name' => 'Create Investment SI', 'slug' => 'investment-si.create', 'module' => 'investment'],
            ['name' => 'Edit Investment SI', 'slug' => 'investment-si.edit', 'module' => 'investment'],
            ['name' => 'Delete Investment SI', 'slug' => 'investment-si.delete', 'module' => 'investment'],
            ['name' => 'Approve Investment SI', 'slug' => 'investment-si.approve', 'module' => 'investment'],
            
            // Accounts Module
            ['name' => 'View Vendors', 'slug' => 'vendors.view', 'module' => 'accounts'],
            ['name' => 'Create Vendors', 'slug' => 'vendors.create', 'module' => 'accounts'],
            ['name' => 'Edit Vendors', 'slug' => 'vendors.edit', 'module' => 'accounts'],
            ['name' => 'Delete Vendors', 'slug' => 'vendors.delete', 'module' => 'accounts'],
            
            ['name' => 'View Purchases', 'slug' => 'purchases.view', 'module' => 'accounts'],
            ['name' => 'Create Purchases', 'slug' => 'purchases.create', 'module' => 'accounts'],
            ['name' => 'Edit Purchases', 'slug' => 'purchases.edit', 'module' => 'accounts'],
            ['name' => 'Delete Purchases', 'slug' => 'purchases.delete', 'module' => 'accounts'],
            
            ['name' => 'View Sales', 'slug' => 'sales.view', 'module' => 'accounts'],
            ['name' => 'Create Sales', 'slug' => 'sales.create', 'module' => 'accounts'],
            ['name' => 'Edit Sales', 'slug' => 'sales.edit', 'module' => 'accounts'],
            ['name' => 'Delete Sales', 'slug' => 'sales.delete', 'module' => 'accounts'],
            
            ['name' => 'View Expenses', 'slug' => 'expenses.view', 'module' => 'accounts'],
            ['name' => 'Create Expenses', 'slug' => 'expenses.create', 'module' => 'accounts'],
            ['name' => 'Edit Expenses', 'slug' => 'expenses.edit', 'module' => 'accounts'],
            ['name' => 'Delete Expenses', 'slug' => 'expenses.delete', 'module' => 'accounts'],
            
            ['name' => 'View Ledger', 'slug' => 'ledger.view', 'module' => 'accounts'],
            
            // Settings Module
            ['name' => 'Manage Roles', 'slug' => 'roles.manage', 'module' => 'settings'],
            ['name' => 'Manage Permissions', 'slug' => 'permissions.manage', 'module' => 'settings'],
            ['name' => 'Manage Users', 'slug' => 'users.manage', 'module' => 'settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
    }
}
