<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $customerRole = Role::create(['name' => 'customer']);

        // Create permissions
        $permissions = [
            'manage_products',
            'manage_categories',
            'manage_brands',
            'manage_orders',
            'manage_users',
            'manage_reviews',
            'view_analytics',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign all permissions to admin role
        $adminRole->givePermissionTo(Permission::all());

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@furniturestore.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'status' => true,
        ]);
        $admin->assignRole('admin');

        // Create sample customers
        $customers = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'phone' => '+91 9876543210',
                'email_verified_at' => now(),
                'status' => true,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'phone' => '+91 9876543211',
                'email_verified_at' => now(),
                'status' => true,
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'password' => Hash::make('password'),
                'phone' => '+91 9876543212',
                'email_verified_at' => now(),
                'status' => true,
            ]
        ];

        foreach ($customers as $customerData) {
            $customer = User::create($customerData);
            $customer->assignRole('customer');
        }
    }
}
