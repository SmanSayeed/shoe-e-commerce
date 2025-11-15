<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminLoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        // If already authenticated as admin, redirect to dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // If authenticated as regular user, logout first
        if (Auth::check()) {
            Auth::logout();
        }

        return view('admin.login');
    }

    /**
     * Handle admin login authentication.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Find user first to check role
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ])->onlyInput('email');
        }

        // Check if user is admin
        if ($user->role !== 'admin') {
            return back()->withErrors([
                'email' => 'Access denied. This login is for administrators only.',
            ])->onlyInput('email');
        }

        // Check if account is active
        if (!$user->is_active) {
            return back()->withErrors([
                'email' => 'Your account has been deactivated. Please contact support.',
            ])->onlyInput('email');
        }

        // Attempt authentication with admin guard
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}

