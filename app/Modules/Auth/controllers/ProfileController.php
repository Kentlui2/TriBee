<?php

/**
 * G1 - Member 4: Shaina
 * ProfileController - Profile CRUD + Address Book API
 */

namespace App\Modules\Auth\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * G1 - Member 4: Shaina
     * Get authenticated user
     */
    private function getUser(): User
    {
        /** @var User $user */
        $user = Auth::user();
        return $user;
    }

    /**
     * G1 - Member 4: Shaina
     * Show current user profile
     */
    public function show(): JsonResponse
    {
        $user = $this->getUser();
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ]
        ]);
    }

    /**
     * G1 - Member 4: Shaina
     * Update profile
     */
    public function update(Request $request): JsonResponse
    {
        $user = $this->getUser();

        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->fill($validated);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    /**
     * G1 - Member 4: Shaina
     * Delete account
     */
    public function destroy(): JsonResponse
    {
        $user = $this->getUser();
        
        Auth::logout();
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Account deleted successfully'
        ]);
    }

    /**
     * G1 - Member 4: Shaina
     * Change password
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $user = $this->getUser();

        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    }

    // ── Address Book ──────────────────────────────

    /**
     * G1 - Member 4: Shaina
     * Get all addresses
     */
    public function addresses(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [],
            'message' => 'Address Book endpoint ready'
        ]);
    }

    /**
     * G1 - Member 4: Shaina
     * Add address
     */
    public function storeAddress(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'zip_code' => 'required|string|max:10',
            'is_default' => 'boolean',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address added (placeholder)',
            'data' => $validated
        ]);
    }

    /**
     * G1 - Member 4: Shaina
     * Delete address
     */
    public function destroyAddress(int $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => "Address $id deleted (placeholder)"
        ]);
    }
}