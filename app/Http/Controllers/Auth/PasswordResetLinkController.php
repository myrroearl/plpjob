<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email', 'exists:users'],
            ], [
                'email.exists' => 'We could not find a user with that email address.'
            ]);

            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                Log::info('Password reset link sent to: ' . $request->email);
                return back()->with('status', 'We have emailed your password reset link!');
            }

            Log::error('Failed to send password reset link: ' . $status);
            return back()->withErrors(['email' => __($status)]);

        } catch (\Exception $e) {
            Log::error('Password reset error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'An error occurred while processing your request.']);
        }
    }
} 