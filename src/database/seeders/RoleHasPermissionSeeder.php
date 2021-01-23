<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = collect([
            'see invoices',
            'edit invoices',
            'edit_users',
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
            'view_permissions',
            'view_roles',
            'add_user',
            'delete_user',
            'change_user_permission',
            'change_user_status',
            'add_role',
            'delete_role',
            'add_permission',
            'edit_permission',
            'remove_permission',
            'edit_roles',
        ]);
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
