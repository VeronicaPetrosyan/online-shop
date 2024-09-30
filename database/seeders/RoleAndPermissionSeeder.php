<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $managerRole = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);

        Permission::firstOrCreate(['name' => 'manage products', 'guard_name' => 'admin']);
        Permission::firstOrCreate(['name' => 'update product', 'guard_name' => 'admin']);

        $managerRole->givePermissionTo('manage products');
        $adminRole->givePermissionTo(Permission::all());

        $manager = Admin::find(2);
        if ($manager && !$manager->hasRole('manager')) {
            $manager->assignRole('manager');
        }

        $admin = Admin::find(1);
        if ($admin && !$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
