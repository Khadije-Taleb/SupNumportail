<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class InitialPasswordController extends Controller
{
    /**
     * Display the password change view for first-time login.
     */
    public function create(): View
    {
        return view('auth.change-password');
    }

    /**
     * Update the user's password and set premiere_connexion to false.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
            'premiere_connexion' => false,
        ]);

        return redirect()->route('dashboard')->with('status', 'password-updated');
    }
}
