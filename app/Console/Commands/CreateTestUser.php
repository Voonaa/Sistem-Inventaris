<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user for login testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Check if user already exists
        $existingUser = User::where('email', 'test@example.com')->first();
        
        if ($existingUser) {
            // Update the existing user's password
            $existingUser->update([
                'password' => Hash::make('password')
            ]);
            $this->info('Test user password updated successfully.');
            return;
        }
        
        // Create new test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        $this->info('Test user created successfully.');
    }
} 