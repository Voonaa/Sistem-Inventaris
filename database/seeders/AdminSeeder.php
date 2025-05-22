<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Akun Admin 1
        User::create([
            'name' => 'Admin Satu',
            'email' => 'admin1@sasmita.sch.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Akun Admin 2
        User::create([
            'name' => 'Admin Dua',
            'email' => 'admin2@sasmita.sch.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Akun Admin 3
        User::create([
            'name' => 'Admin Tiga',
            'email' => 'admin3@sasmita.sch.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
    }
}
