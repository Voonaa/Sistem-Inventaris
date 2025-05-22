<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class NocsrfAuthController extends Controller
{
    /**
     * Login user via API without CSRF protection
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            Log::info('NoCSRF Login attempt', ['email' => $request->email]);
            
            // Validate request
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);
            
            // Find user
            $user = User::where('email', $credentials['email'])->first();
            
            // Check if user exists and password is correct
            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials',
                ], 401);
            }
            
            // Generate token
            $token = $user->createToken('auth_token')->plainTextToken;
            
            // Log successful login
            Log::info('User logged in successfully via NoCSRF controller', ['user_id' => $user->id]);
            
            // Return token and user data
            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            Log::error('NoCSRF Login exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Login failed: ' . $e->getMessage(),
            ], 500);
        }
    }
} 