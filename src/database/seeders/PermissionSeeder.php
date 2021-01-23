<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'see invoices',
            'edit invoices',
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
        ];
        foreach ($data as $permission) {
            $temp = new Permission;
            $temp->name = $permission;
            $temp->save();
        }
    }
}
