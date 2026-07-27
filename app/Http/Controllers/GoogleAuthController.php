<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google and authenticate.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Failed to authenticate with Google. Please try again.',
            ]);
        }

        $email = $googleUser->getEmail();
        $allowedDomain = env('ALLOWED_EMAIL_DOMAINS', 'bicol-u.edu.ph');

        // Validate Bicol University domain restriction
        if (!Str::endsWith($email, '@' . $allowedDomain)) {
            return redirect()->route('login')->withErrors([
                'email' => "Access is restricted to official @{$allowedDomain} email accounts.",
            ]);
        }

        // Retrieve existing user or create a new one
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $email)
            ->first();

        if ($user) {
            $updates = [];
            if (!$user->google_id) {
                $updates['google_id'] = $googleUser->getId();
            }
            if ($user->status === 'pending_activation') {
                $updates['status'] = 'active';
                $updates['name'] = $googleUser->getName();
                $updates['email_verified_at'] = now();
            }
            if (!empty($updates)) {
                $user->update($updates);
            }
        } else {
            // Auto-register a new user with a default role
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $email,
                'google_id' => $googleUser->getId(),
                'password' => null, // No password needed for OAuth-only users
                'role' => 'task-force', // Default role for newly registered users
                'status' => 'active',
            ]);
        }

        Auth::login($user);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
