<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleHasPermission;
use App\Models\User;
use App\Models\UserHasRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roleData = array('Admin', 'Viewer', 'Editor');
        foreach ($roleData as $role) {
            $role = Role::create(['name' => $role]);
        }

        $permissionData = array('create', 'read', 'update', 'delete');
        foreach ($permissionData as $permission) {
            $permission = Permission::create(['name' => $permission]);
        }

        // assign permissions to roles
        $mapping = array(
            'Admin' => array('create', 'read', 'update', 'delete'),
            'Viewer' => array('read'),
            'Editor' => array('create', 'read', 'update'),
        );
        foreach ($mapping as $role => $permissions) {
            $role = Role::where('name', $role)->first();

            foreach ($permissions as $permission) {
                $permission = Permission::where('name', $permission)->first();
                RoleHasPermission::create([
                    'role_id' => $role->id,
                    'permission_id' => $permission->id,
                ]);
            }
        }
        $userData = array(
            array(
                'name' => fake()->name(),
                'email' => 'admin@email.com',
                'password' => 'password',
                'role' => 'Admin'
            ),
            array(
                'name' => fake()->name(),
                'email' => 'viewer@email.com',
                'password' => 'password',
                'role' => 'Viewer'
            ),
            array(
                'name' => fake()->name(),
                'email' => 'editor@email.com',
                'password' => 'password',
                'role' => 'Editor'
            ),
        );
        // create users
        foreach ($userData as $value) {
            $user = User::create([
                'name' => $value['name'],
                'email' => $value['email'],
                'password' => $value['password'],
            ]);
            $role = Role::where('name', $value['role'])->first();
            UserHasRole::create([
                'user_id' => $user->id,
                'role_id' => $role->id,
            ]);
        }
    }
}
