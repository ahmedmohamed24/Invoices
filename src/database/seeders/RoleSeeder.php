<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            'user','admin','super admin','owner'
        ];
        foreach($data as $role){
            $temp=new Role;
            $temp->name=$role;
            $temp->save();
        }
    }
}
