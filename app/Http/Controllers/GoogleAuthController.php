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
        $allowedDomain = env('ALLOWED_EMAIL_DOMAINS', 'bicol-u.edu.ph');
        $driver = $this->getGoogleDriver();

        if ($allowedDomain && $allowedDomain !== '*') {
            $firstDomain = trim(explode(',', $allowedDomain)[0]);
            $driver->with(['hd' => $firstDomain]);
        }

        return $driver->redirect();
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
                'email' => 'Your account has been deactivated.',
            ]);
        }

        $updates = [];
        if (!$user->google_id) {
            $updates['google_id'] = $googleUser->getId();
        }

        $rawGiven = $googleUser->user['given_name'] ?? null;
        $rawFamily = $googleUser->user['family_name'] ?? null;

        if (!$rawGiven || !$rawFamily) {
            $fullName = trim($googleUser->getName() ?? '');
            $parts = explode(' ', $fullName, 2);
            $rawGiven = $rawGiven ?: ($parts[0] ?? '');
            $rawFamily = $rawFamily ?: ($parts[1] ?? '');
        }

        // Clean name helper: remove student/employee ID tokens containing digits (e.g. Jcmm2023, 4700, 61428)
        $cleanNameToken = function (string $nameStr): string {
            $tokens = preg_split('/\s+/', trim($nameStr));
            $filtered = array_filter($tokens, fn($t) => !preg_match('/\d/', $t));
            return !empty($filtered) ? implode(' ', $filtered) : $nameStr;
        };

        $googleFirstName = $cleanNameToken($rawGiven ?: '');
        $googleLastName = $cleanNameToken($rawFamily ?: '');

        if ($user->status === 'pending_activation') {
            $updates['status'] = 'active';
            $updates['email_verified_at'] = now();
        }

        // Always update first_name and last_name if they contain digits or default placeholder values ('Pending', 'User')
        if ($googleFirstName && ($user->first_name === 'Pending' || empty($user->first_name) || preg_match('/\d/', $user->first_name))) {
            $updates['first_name'] = $googleFirstName;
        }
        if ($googleLastName && ($user->last_name === 'User' || empty($user->last_name) || preg_match('/\d/', $user->last_name))) {
            $updates['last_name'] = $googleLastName;
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
