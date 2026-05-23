<?php

namespace App\Modules\Auth\Services;

use App\Modules\Auth\Models\Role;
use App\Modules\Auth\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(array $data): User
    {
        /** @var User $user */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $customerRole = Role::where('name', 'customer')->first();
        if ($customerRole) {
            $user->role_id = $customerRole->id;
            $user->save();
        }

        return $user;
    }

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

    public function logout(): void
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
    }
}