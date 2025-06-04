<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Find or create the Super Admin role
        $role = Role::firstOrCreate(
            ['name' => 'Super Admin'], 
            ['guard_name' => 'web']
        );

        // Create the Super Admin user if not exists
        $user = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'phone' => '123456789',
                'password' => '0000', 
                'role' => 'super_admin', 
                
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('model_has_roles')->insert([
            'role_id' => $role->id,
            'model_id' => $user->id,
            'model_type' => 'App\Models\User',  // Explicitly specify the model type
        ]);
    }
}
