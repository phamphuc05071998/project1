<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Define permissions
        $permissions = [
            'create posts',
            'edit own posts',
            'delete own posts',
            'approve posts',
            'create categories',
            'approve authors',
            'assign categories',
        ];

        // Create permissions if they do not exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles if they do not exist
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $authorRole = Role::firstOrCreate(['name' => 'author']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Assign permissions to roles
        $authorRole->syncPermissions(['create posts', 'edit own posts', 'delete own posts']);
        $editorRole->syncPermissions(['approve posts', 'create categories', 'approve authors', 'assign categories']);
        $adminRole->syncPermissions(Permission::all());

        // Create the first admin user if they do not exist
        $admin1 = User::firstOrCreate(
            ['email' => 'admin1@example.com'],
            [
                'name' => 'Admin User 1',
                'password' => bcrypt('123456'), // Change this to a secure password
            ]
        );

        // Assign the admin role to the first admin user
        $admin1->assignRole($adminRole);

        // Create the second admin user if they do not exist
        $admin2 = User::firstOrCreate(
            ['email' => 'admin2@example.com'],
            [
                'name' => 'Admin User 2',
                'password' => bcrypt('123456'), // Change this to a secure password
            ]
        );

        // Assign the admin role to the second admin user
        $admin2->assignRole($adminRole);
    }
}
