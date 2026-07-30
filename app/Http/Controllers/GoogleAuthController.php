<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Get configured Socialite Google driver.
     */
    protected function getGoogleDriver()
    {
        $driver = Socialite::driver('google');

        if (app()->environment('local')) {
            $driver->setHttpClient(new \GuzzleHttp\Client([
                'verify' => false,
                'timeout' => 15,
            ]));
        }

        return $driver;
    }

    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return $this->getGoogleDriver()->redirect();
    }

    /**
     * Obtain the user information from Google and authenticate.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = $this->getGoogleDriver()->user();
        } catch (\Exception $e) {
            try {
                $googleUser = $this->getGoogleDriver()->stateless()->user();
            } catch (\Exception $ex) {
                \Illuminate\Support\Facades\Log::error('Google Auth Exception', [
                    'message' => $ex->getMessage(),
                    'trace' => $ex->getTraceAsString(),
                ]);

                $errorMessage = config('app.debug')
                    ? 'Failed to authenticate with Google: ' . $ex->getMessage()
                    : 'Failed to authenticate with Google. Please try again.';

                return redirect()->route('login')->withErrors([
                    'email' => $errorMessage,
                ]);
            }
        }

        $email = strtolower(trim($googleUser->getEmail()));
        $allowedDomainsSetting = env('ALLOWED_EMAIL_DOMAINS', 'bicol-u.edu.ph');

        // Validate domain restriction if specified
        if ($allowedDomainsSetting && $allowedDomainsSetting !== '*') {
            $allowedDomains = array_filter(array_map('trim', explode(',', $allowedDomainsSetting)));
            $userDomain = Str::after($email, '@');

            if (!in_array($userDomain, $allowedDomains, true)) {
                $domainMessage = count($allowedDomains) > 1
                    ? 'official @' . implode(' or @', $allowedDomains)
                    : "@{$allowedDomainsSetting}";
                return redirect()->route('login')->withErrors([
                    'email' => "Access is restricted to {$domainMessage} email accounts.",
                ]);
            }
        }

        // Retrieve pre-registered user
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $email)
            ->first();

        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Your account has not been pre-registered. Please contact the Internal Quality Assurance Office (bu-iqao@bicol-u.edu.ph) for access.',
            ]);
        }

        // Block deactivated accounts
        if ($user->status === 'inactive' || $user->status === 'revoked') {
            return redirect()->route('login')->withErrors([
                'email' => 'Your account has been deactivated. Please contact an IQA Administrator.',
            ]);
        }

        $updates = [];
        if (!$user->google_id) {
            $updates['google_id'] = $googleUser->getId();
        }

        $parts = explode(' ', trim($googleUser->getName() ?? ''), 2);
        $googleFirstName = $parts[0] ?? '';
        $googleLastName = $parts[1] ?? '';

        if ($user->status === 'pending_activation') {
            $updates['status'] = 'active';
            $updates['email_verified_at'] = now();
            if ($googleFirstName && ($user->first_name === 'Pending' || empty($user->first_name))) {
                $updates['first_name'] = $googleFirstName;
            }
            if ($googleLastName && ($user->last_name === 'User' || empty($user->last_name))) {
                $updates['last_name'] = $googleLastName;
            }
        }

        if (!empty($updates)) {
            $user->update($updates);
        }

        Auth::login($user);

        // Record audit log entry
        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'GOOGLE_LOGIN',
            'target_type' => User::class,
            'target_id' => $user->id,
            'timestamp' => now(),
        ]);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
