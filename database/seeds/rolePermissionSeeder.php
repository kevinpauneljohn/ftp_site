<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class rolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'super admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'graphic artist']);
        Role::create(['name' => 'reseller']);
        Role::create(['name' => 'sales']);

        Permission::create(['name' => 'add role'])->assignRole('super admin');
        Permission::create(['name' => 'edit role'])->assignRole('super admin');
        Permission::create(['name' => 'delete role'])->assignRole('super admin');

    }
}
