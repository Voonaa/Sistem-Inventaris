<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin',
            'description' => 'Administrator with full access to all features',
        ]);
        
        Role::create([
            'name' => 'operator',
            'description' => 'Staff who can manage inventory and borrowing records',
        ]);
        
        Role::create([
            'name' => 'viewer',
            'description' => 'User with read-only access to the system',
        ]);
    }
}
