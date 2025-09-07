<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Role::truncate();
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $sellerRole = Role::create(['name' => 'seller']);
        $buyerRole = Role::create(['name' => 'buyer']);

        // Create permissions
        $permissions = [
            // User management
            'manage-users',
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            
            // Seller management
            'manage-sellers',
            'view-sellers',
            'create-sellers',
            'edit-sellers',
            'delete-sellers',
            
            // Product management
            'manage-products',
            'view-products',
            'create-products',
            'edit-products',
            'delete-products',
            
            // Order management
            'manage-orders',
            'view-orders',
            'create-orders',
            'edit-orders',
            'delete-orders',
            
            // Category management
            'manage-categories',
            'view-categories',
            'create-categories',
            'edit-categories',
            'delete-categories',
            
            // Dashboard access
            'view-admin-dashboard',
            'view-seller-dashboard',
            'view-buyer-dashboard',
            
            // Profile management
            'manage-own-profile',
            'view-own-profile',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        
        $sellerRole->givePermissionTo([
            'manage-own-profile',
            'view-own-profile',
            'manage-products',
            'view-products',
            'create-products',
            'edit-products',
            'delete-products',
            'view-orders',
            'view-seller-dashboard',
        ]);
        
        $buyerRole->givePermissionTo([
            'manage-own-profile',
            'view-own-profile',
            'view-products',
            'create-orders',
            'view-orders',
            'view-buyer-dashboard',
        ]);
    }
}