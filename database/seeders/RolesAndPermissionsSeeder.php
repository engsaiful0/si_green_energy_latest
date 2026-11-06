<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $adminRole = Role::create([
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => 'Full system access with all permissions',
        ]);

        $editorRole = Role::create([
            'name' => 'Editor',
            'slug' => 'editor',
            'description' => 'Can manage content but not system settings',
        ]);

        $authorRole = Role::create([
            'name' => 'Author',
            'slug' => 'author',
            'description' => 'Can create and edit own content',
        ]);

        // Create Permissions
        $permissions = [
            // Dashboard
            ['name' => 'View Dashboard', 'slug' => 'dashboard.view', 'module' => 'dashboard', 'description' => 'View admin dashboard'],

            // Users
            ['name' => 'View Users', 'slug' => 'users.view', 'module' => 'users', 'description' => 'View user list'],
            ['name' => 'Create Users', 'slug' => 'users.create', 'module' => 'users', 'description' => 'Create new users'],
            ['name' => 'Edit Users', 'slug' => 'users.edit', 'module' => 'users', 'description' => 'Edit existing users'],
            ['name' => 'Delete Users', 'slug' => 'users.delete', 'module' => 'users', 'description' => 'Delete users'],

            // Pages
            ['name' => 'View Pages', 'slug' => 'pages.view', 'module' => 'pages', 'description' => 'View pages'],
            ['name' => 'Create Pages', 'slug' => 'pages.create', 'module' => 'pages', 'description' => 'Create new pages'],
            ['name' => 'Edit Pages', 'slug' => 'pages.edit', 'module' => 'pages', 'description' => 'Edit existing pages'],
            ['name' => 'Delete Pages', 'slug' => 'pages.delete', 'module' => 'pages', 'description' => 'Delete pages'],

            // Products
            ['name' => 'View Products', 'slug' => 'products.view', 'module' => 'products', 'description' => 'View products'],
            ['name' => 'Create Products', 'slug' => 'products.create', 'module' => 'products', 'description' => 'Create new products'],
            ['name' => 'Edit Products', 'slug' => 'products.edit', 'module' => 'products', 'description' => 'Edit existing products'],
            ['name' => 'Delete Products', 'slug' => 'products.delete', 'module' => 'products', 'description' => 'Delete products'],

            // Services
            ['name' => 'View Services', 'slug' => 'services.view', 'module' => 'services', 'description' => 'View services'],
            ['name' => 'Create Services', 'slug' => 'services.create', 'module' => 'services', 'description' => 'Create new services'],
            ['name' => 'Edit Services', 'slug' => 'services.edit', 'module' => 'services', 'description' => 'Edit existing services'],
            ['name' => 'Delete Services', 'slug' => 'services.delete', 'module' => 'services', 'description' => 'Delete services'],

            // Projects
            ['name' => 'View Projects', 'slug' => 'projects.view', 'module' => 'projects', 'description' => 'View projects'],
            ['name' => 'Create Projects', 'slug' => 'projects.create', 'module' => 'projects', 'description' => 'Create new projects'],
            ['name' => 'Edit Projects', 'slug' => 'projects.edit', 'module' => 'projects', 'description' => 'Edit existing projects'],
            ['name' => 'Delete Projects', 'slug' => 'projects.delete', 'module' => 'projects', 'description' => 'Delete projects'],

            // Blog
            ['name' => 'View Blog Posts', 'slug' => 'blog.view', 'module' => 'blog', 'description' => 'View blog posts'],
            ['name' => 'Create Blog Posts', 'slug' => 'blog.create', 'module' => 'blog', 'description' => 'Create new blog posts'],
            ['name' => 'Edit Blog Posts', 'slug' => 'blog.edit', 'module' => 'blog', 'description' => 'Edit existing blog posts'],
            ['name' => 'Delete Blog Posts', 'slug' => 'blog.delete', 'module' => 'blog', 'description' => 'Delete blog posts'],

            // Settings
            ['name' => 'View Settings', 'slug' => 'settings.view', 'module' => 'settings', 'description' => 'View system settings'],
            ['name' => 'Edit Settings', 'slug' => 'settings.edit', 'module' => 'settings', 'description' => 'Edit system settings'],
        ];

        $createdPermissions = [];
        foreach ($permissions as $permission) {
            $createdPermissions[] = Permission::create($permission);
        }

        // Attach all permissions to Admin role
        $adminRole->permissions()->attach($createdPermissions);

        // Attach content permissions to Editor role
        $editorRole->permissions()->attach(
            Permission::whereIn('slug', [
                'dashboard.view',
                'pages.view', 'pages.create', 'pages.edit',
                'products.view', 'products.create', 'products.edit',
                'services.view', 'services.create', 'services.edit',
                'projects.view', 'projects.create', 'projects.edit',
                'blog.view', 'blog.create', 'blog.edit',
            ])->get()
        );

        // Attach limited permissions to Author role
        $authorRole->permissions()->attach(
            Permission::whereIn('slug', [
                'dashboard.view',
                'blog.view', 'blog.create', 'blog.edit',
            ])->get()
        );
    }
}
