<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $storekeeper = Role::create(['name' => 'Storekeeper']);
        $courier = Role::create(['name' => 'Courier']);
        $client = Role::create(['name' => 'Client']);
        $merchantClient = Role::create(['name' => 'Merchant Client']);

        // Define permissions
        $permissions = [
            'manage users',
            'manage orders',
            'manage deliveries',
            'manage products',
            'view reports',
            'manage inventory',
            'handle deliveries',
            'place orders',
            'manage counters',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $superAdmin->givePermissionTo(Permission::all());
        
        $admin->givePermissionTo([
            'manage users',
            'manage orders',
            'manage deliveries',
            'view reports',
        ]);

        $storekeeper->givePermissionTo([
            'manage products',
            'manage inventory',
            'handle deliveries',
        ]);

        $courier->givePermissionTo(['handle deliveries']);
        
        $client->givePermissionTo(['place orders']);
        
        $merchantClient->givePermissionTo(['manage counters', 'place orders']);
    }
}
