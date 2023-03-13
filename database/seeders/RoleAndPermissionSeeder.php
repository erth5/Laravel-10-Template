<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'show_permissions',
        ]);
        Permission::create([
            'name' => 'edit_permissions',
        ]);
        Permission::create([
            'name' => 'show_own_permissions',
        ]);
        Permission::create([
            'name' => 'edit_own_permissions',
        ]);

        $userRole = Role::create(['name' => 'user'])
            ->givePermissionTo('show_own_permissions');

        $adminRole = Role::create(['name' => 'admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        $adminRole->syncPermissions($permissions);
        $user = User::where('email', 'fdsdwp@protonmail.com')->first();
        $user->assignRole([$adminRole->id]);

        $superAdmin = Role::create(['name' => 'Super Admin']);
        $user->assignRole([$superAdmin->id]);
    }
}
