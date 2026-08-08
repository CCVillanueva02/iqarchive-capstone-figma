<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureActions();
        $this->configureViews();
        $this->configureRateLimiting();
        $this->configureAuthentication();
    }

    /**
     * Configure authentication callbacks, validation and sanitization.
     */
    private function configureAuthentication(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            // 1. Sanitize the input
            $email = trim(filter_var($request->input('email'), FILTER_SANITIZE_EMAIL));
            $password = $request->input('password');

            // 2. Validate user input
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string'],
            ], [
                'email.required' => 'Please enter your email address to continue.',
                'email.email' => 'The email format you provided is invalid.',
                'password.required' => 'A password is required to authenticate.',
            ]);

            // 3. Retrieve user
            $user = \App\Models\User::where('email', $email)->first();

            // 4. Authenticate and verify status
            if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {
                if ($user->status !== 'active') {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'email' => ['Your account has been deactivated.'],
                    ]);
                }
                return $user;
            }

            // 5. Enhanced error response
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => ['These credentials do not match our records. Please double-check your email and password.'],
            ]);
        });
    }

    /**
     * Configure Actions.
     */
    private function configureActions(): void
    {
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::createUsersUsing(CreateNewUser::class);
    }

    /**
     * Configure Fortify views.
     */
    private function configureViews(): void
    {
        Fortify::loginView(fn () => view('pages::auth.login'));
        Fortify::verifyEmailView(fn () => view('pages::auth.verify-email'));
        Fortify::twoFactorChallengeView(fn () => view('pages::auth.two-factor-challenge'));
        Fortify::confirmPasswordView(fn () => view('pages::auth.confirm-password'));
        Fortify::registerView(fn () => view('pages::auth.register'));
        Fortify::resetPasswordView(fn () => view('pages::auth.reset-password'));
        Fortify::requestPasswordResetLinkView(fn () => view('pages::auth.forgot-password'));
    }

    /**
     * Configure rate limiting.
     */
    private function configureRateLimiting(): void
    {
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('passkeys', function (Request $request) {
            $credentialId = $request->input('credential.id');

            return Limit::perMinute(10)->by(
                ($credentialId ?: $request->session()->getId()).'|'.$request->ip(),
            );
        });
    }
}
