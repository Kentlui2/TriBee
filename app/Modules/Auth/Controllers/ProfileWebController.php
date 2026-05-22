<?php

declare(strict_types=1);

namespace App\Modules\Auth\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileWebController extends Controller
{
    public function show(): \Illuminate\View\View
    {
        /** @var User $user */
        $user = Auth::user();

        return view('auth.profile.show', compact('user'));
    }

    public function edit(): \Illuminate\View\View
    {
        /** @var User $user */
        $user = Auth::user();

        return view('auth.profile.edit', compact('user'));
    }

    public function addresses(): \Illuminate\View\View
    {
        /** @var User $user */
        $user = Auth::user();

        return view('auth.profile.address', compact('user'));
    }
}