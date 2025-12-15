<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view orders',
            'manage orders',
            'view users',
            'manage users',
            'view reports',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Assign all permissions to admin
        $adminRole->givePermissionTo(Permission::all());

        // Assign basic permissions to customer
        $customerRole->givePermissionTo(['view products', 'view orders']);

        // Create default admin user if no users exist
        if (User::count() === 0) {
            $admin = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
            ]);
            $admin->assignRole('admin');
            
            $customer = User::create([
                'name' => 'Customer User',
                'email' => 'customer@example.com',
                'password' => Hash::make('password123'),
            ]);
            $customer->assignRole('customer');
        } else {
            // Assign admin role to the first user in the database
            $firstUser = User::first();
            if ($firstUser && !$firstUser->hasRole('admin')) {
                $firstUser->assignRole('admin');
                $this->command->info("Admin role assigned to: {$firstUser->email}");
            }
            
            // Ensure all existing users have customer role
            $users = User::whereDoesntHave('roles')->get();
            foreach ($users as $user) {
                if ($user->id !== $firstUser->id) {
                    $user->assignRole('customer');
                }
            }
        }
        
        $this->command->info('Roles and permissions seeded successfully!');
    }
}