<?php

namespace App\Modules\Auth\Services;

use App\Models\User;
use App\Modules\Auth\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Register a new user with default "customer" role
     */
    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Auto-assign customer role
        $customerRole = Role::where('name', 'customer')->first();
        if ($customerRole) {
            $user->role_id = $customerRole->id;
            $user->save();
        }

        return $user;
    }

    /**
     * Login user with email and password
     */
    public function login(array $credentials): bool
    {
        if (!Auth::attempt($credentials, request()->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        session()->regenerate();
        return true;
    }

    /**
     * Logout current user
     */
    public function logout(): void
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
    }
}