<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (auth('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Authenticate the admin and start their session.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = auth('admin')->attempt($credentials, $request->boolean('remember'));

        if (!$user) {
            return back()->withErrors([
                'email' => 'ইমেইল বা পাসওয়ার্ড সঠিক নয়।',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    /**
     * Log the admin out and invalidate their session.
     */
    public function logout(Request $request): RedirectResponse
    {
        auth('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Show the change-password form.
     */
    public function showChangePassword(): View
    {
        return view('admin.auth.change-password');
    }

    /**
     * Update the admin's password.
     */
    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password:admin'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        auth('admin')->user()->update([
            'password' => bcrypt($request->password),
        ]);

        return back()->with('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন হয়েছে।');
    }
}
