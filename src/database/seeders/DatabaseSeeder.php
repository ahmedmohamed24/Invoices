<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //may run every seeder alone or seed all once
        \App\Models\User::factory(10)->create();
        \App\Models\Department::factory(10)->create();
        \App\Models\Product::factory(10)->create();
        \App\Models\Invoice::factory(50)->create();
        $data = collect([
            'see invoices',
            'edit invoices',
            'delete attach',
            'add invoice',
            'view_permissions',
            'view_roles',
            'archive invoices',
            'delete invoice',
            'restore invoices',
            'add attachment',
            'print invoice',
            'add department',
            'view department',
            'edit department',
            'delete department',
            'view_products',
            'add_product',
            'edit_product',
            'delete_product',
            'view_users',
            'add_user',
            'delete_user',
            'change_user_permission',
            'change_user_status',
            'add_role',
            'delete_role',
            'add_permission',
            'edit_permission',
            'remove_permission',
            'edit_users',
            'edit_roles',
        ]);
        //add the permissions
        $data->map(function ($permission) {
            $temp = new Permission;
            $temp->name = $permission;
            $temp->save();
        });
        //add roles
        $dataUsers = [
            'user', 'admin', 'super admin', 'owner'
        ];
        foreach ($dataUsers as $role) {
            $temp = new Role;
            $temp->name = $role;
            $temp->save();
        }
        //assign permissions for roles
        $userRole = Role::where('name', 'user')->firstOrFail();
        $adminRole = Role::where('name', 'admin')->firstOrFail();
        $superRole = Role::where('name', 'super admin')->firstOrFail();
        $ownerRole = Role::where('name', 'owner')->firstOrFail();

        collect([
            'see invoices',
            'print invoice',
            'view department',
            'view_products'
        ])->map(fn ($permission) => $userRole->givePermissionTo($permission));

        collect([
            'see invoices',
            'edit invoices',
            'add invoice',
            'archive invoices',
            'add attachment',
            'print invoice',
            'add department',
            'view department',
            'edit department',
            'view_products',
            'add_product',
            'edit_product',
            'view_users',
        ])->map(fn ($permission) => $adminRole->givePermissionTo($permission));

        collect([
            'see invoices',
            'edit_users',
            'edit invoices',
            'add invoice',
            'archive invoices',
            'delete invoice',
            'restore invoices',
            'add attachment',
            'print invoice',
            'add department',
            'view department',
            'edit department',
            'delete department',
            'view_products',
            'add_product',
            'edit_product',
            'delete_product',
            'view_users',
            'add_user',
            'change_user_status',
        ])->map(fn ($permission) => $superRole->givePermissionTo($permission));

        $data->map(fn ($permission) => $ownerRole->givePermissionTo($permission));
        User::findOrFail(1)->assignRole('owner');
    }
}
