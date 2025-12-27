<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);
        $authorRole = Role::create(['name' => 'author']);
        
        // Create permissions
        $permissions = [
            // Content Management
            'create posts',
            'edit posts',
            'delete posts',
            'publish posts',
            'manage categories',
            'manage tags',
            'manage comments',
            
            // Media Management
            'upload media',
            'manage media',
            
            // User Management
            'manage users',
            'assign roles',
            
            // Site Management
            'manage settings',
            'manage pages',
            'manage advertisements',
            'manage newsletters',
            'view analytics',
        ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        
        $editorRole->givePermissionTo([
            'create posts', 'edit posts', 'delete posts', 'publish posts',
            'manage categories', 'manage tags', 'manage comments',
            'upload media', 'manage media', 'manage pages'
        ]);
        
        $authorRole->givePermissionTo([
            'create posts', 'edit posts', 'upload media'
        ]);
    }
}