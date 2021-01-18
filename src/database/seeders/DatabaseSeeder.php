<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
    }
}
