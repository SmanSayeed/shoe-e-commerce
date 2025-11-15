<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    public function login(){
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ])->onlyInput('email');
        }

        // Reject admin users - they must use admin login page
        if ($user->role === 'admin') {
            return back()->withErrors([
                'email' => 'Admin users must use the admin login page.',
            ])->onlyInput('email');
        }

        if (!$user->is_active) {
            return back()->withErrors([
                'email' => 'Your account has been deactivated. Please contact support.',
            ])->onlyInput('email');
        }

        // Only authenticate customer and vendor users with web guard
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Logout from both guards
        Auth::logout();
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    private function redirectBasedOnRole(User $user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
            case 'customer':
                return redirect('/')->with('success', 'Welcome back!');
            case 'vendor':
                return redirect('/')->with('success', 'Welcome back!');
            default:
                return redirect('/')->with('success', 'Welcome back!');
        }
    }

    public function register(Request $request)
    {
        if ($request->isMethod('get')) {
            if (Auth::check()) {
                return $this->redirectBasedOnRole(Auth::user());
            }
            return view('auth.register');
        }

        // Handle POST request (form submission)
        try {
            // Enhanced validation with custom error messages
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'min:2',
                    'max:255',
                    'regex:/^[a-zA-Z\s]+$/',
                ],
                'email' => [
                    'required',
                    'string',
                    'email:rfc,dns',
                    'max:255',
                    'unique:users,email',
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:255',
                    'confirmed',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', // At least one lowercase, one uppercase, one number
                ],
                'password_confirmation' => [
                    'required',
                    'string',
                ],
                'terms' => [
                    'required',
                    'accepted',
                ],
            ], [
                'name.required' => 'Full name is required.',
                'name.min' => 'Full name must be at least 2 characters.',
                'name.max' => 'Full name cannot exceed 255 characters.',
                'name.regex' => 'Full name can only contain letters and spaces.',
                'email.required' => 'Email address is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email address is already registered. Please use a different email or try logging in.',
                'email.max' => 'Email address cannot exceed 255 characters.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters long.',
                'password.max' => 'Password cannot exceed 255 characters.',
                'password.confirmed' => 'Password confirmation does not match.',
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
                'password_confirmation.required' => 'Please confirm your password.',
                'terms.required' => 'You must accept the terms and conditions to register.',
                'terms.accepted' => 'You must accept the terms and conditions to register.',
            ]);

            // Sanitize input
            $name = trim($validated['name']);
            $email = strtolower(trim($validated['email']));

            // Additional validation: Check if email is already in use (double-check)
            $existingUser = User::where('email', $email)->first();
            if ($existingUser) {
                return back()->withErrors([
                    'email' => 'This email address is already registered. Please use a different email or try logging in.',
                ])->withInput($request->except('password', 'password_confirmation'));
            }

            // Create user with transaction for data integrity
            DB::beginTransaction();

            try {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($validated['password']), // Explicitly hash password
                    'role' => 'customer', // Default role for new registrations
                    'is_active' => true,
                    'email_verified_at' => null, // Email verification can be added later
                ]);

                DB::commit();

                // Log the user in after successful registration
                Auth::login($user);

                // Regenerate session to prevent session fixation
                $request->session()->regenerate();

                // Return success response
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Welcome! Your account has been created successfully.',
                        'redirect' => route('home'),
                    ], 201);
                }

                return redirect('/')->with('success', 'Welcome! Your account has been created successfully.');

            } catch (\Illuminate\Database\QueryException $e) {
                DB::rollBack();
                
                // Handle database-specific errors
                $errorCode = $e->getCode();
                if ($errorCode == 23000) { // Integrity constraint violation (duplicate entry)
                    return back()->withErrors([
                        'email' => 'This email address is already registered. Please use a different email or try logging in.',
                    ])->withInput($request->except('password', 'password_confirmation'));
                }

                Log::error('Registration database error: ' . $e->getMessage(), [
                    'email' => $email,
                    'error_code' => $errorCode,
                ]);

                return back()->withErrors([
                    'error' => 'Registration failed due to a database error. Please try again later or contact support if the problem persists.',
                ])->withInput($request->except('password', 'password_confirmation'));

            } catch (\Exception $e) {
                DB::rollBack();
                
                Log::error('Registration error: ' . $e->getMessage(), [
                    'email' => $email,
                    'trace' => $e->getTraceAsString(),
                ]);

                return back()->withErrors([
                    'error' => 'An unexpected error occurred during registration. Please try again later or contact support if the problem persists.',
                ])->withInput($request->except('password', 'password_confirmation'));
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors with input data (except passwords)
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed. Please check your input.',
                    'errors' => $e->errors(),
                ], 422);
            }

            return back()
                ->withErrors($e->errors())
                ->withInput($request->except('password', 'password_confirmation'));

        } catch (\Exception $e) {
            Log::error('Registration unexpected error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An unexpected error occurred. Please try again later.',
                ], 500);
            }

            return back()->withErrors([
                'error' => 'An unexpected error occurred during registration. Please try again later or contact support if the problem persists.',
            ])->withInput($request->except('password', 'password_confirmation'));
        }
    }

public function forgot_password(Request $request)
{
    if ($request->isMethod('get')) {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.forgot-password');
    }

    $request->validate([
        'email' => ['required', 'email'],
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return redirect()->route('check-email', ['email' => $request->email])->withErrors([
            'email' => 'No account found with this email address.',
        ]);
    }

    if (!$user->is_active) {
        return redirect()->route('check-email', ['email' => $request->email])->withErrors([
            'email' => 'Your account has been deactivated. Please contact support.',
        ]);
    }

    // Generate and send password reset token (only once)
    $token = Password::createToken($user);
    $user->sendPasswordResetNotification($token);

    return redirect()->route('check-email', ['email' => $request->email])->with('success', 'Password reset link has been sent to your email address.');
}

    public function check_email(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        $email = $request->query('email');
        $message = session('success');

        // If no email provided and no success message, redirect to forgot password
        if (!$email && !$message) {
            return redirect()->route('forgot-password');
        }

        return view('auth.check-email', compact('email', 'message'));
    }

    public function reset_password(Request $request)
    {
        if ($request->isMethod('get')) {
            if (Auth::check()) {
                return $this->redirectBasedOnRole(Auth::user());
            }

            // Check if token and email are provided
            $token = $request->query('token');
            $email = $request->query('email');

            if (!$token || !$email) {
                return redirect()->route('forgot-password')->withErrors([
                    'email' => 'Invalid password reset link. Please request a new one.'
                ]);
            }

            return view('auth.reset-password', compact('token', 'email'));
        }

        // Handle POST request (form submission)
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ])->onlyInput('email');
        }

        if (!$user->is_active) {
            return back()->withErrors([
                'email' => 'Your account has been deactivated. Please contact support.',
            ])->onlyInput('email');
        }

        // Attempt to reset the password
        $status = app('auth.password.broker')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = $password;
                $user->save();

                // Reset login attempts after successful password reset
                $user->resetLoginAttempts();
            }
        );

        if ($status == 'passwords.token') {
            return back()->withErrors([
                'token' => 'Invalid or expired password reset token.',
            ]);
        }

        if ($status == 'passwords.user') {
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ]);
        }

        return redirect()->route('login')->with('success', 'Password has been reset successfully. You can now log in with your new password.');
    }
}
