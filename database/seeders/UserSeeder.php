<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@sasmita.ac.id',
            'role' => 'admin',
            'phone_number' => '081234567890',
            'address' => 'Jl. Admin No. 1, Tangerang',
            'password' => Hash::make('password'),
        ]);
        
        // Create operator user
        User::create([
            'name' => 'Staff Perpustakaan',
            'email' => 'staff@sasmita.ac.id',
            'role' => 'operator',
            'phone_number' => '085678901234',
            'address' => 'Jl. Staff No. 2, Tangerang',
            'password' => Hash::make('password'),
        ]);
        
        // Create viewer user
        User::create([
            'name' => 'Guru Bahasa',
            'email' => 'guru@sasmita.ac.id',
            'role' => 'viewer',
            'phone_number' => '089012345678',
            'address' => 'Jl. Guru No. 3, Tangerang',
            'password' => Hash::make('password'),
        ]);
        
        // Create additional users with random roles
        User::factory()->count(3)->create(['role' => 'admin']);
        User::factory()->count(2)->create(['role' => 'operator']);
        User::factory()->count(2)->create(['role' => 'viewer']);
    }
}
