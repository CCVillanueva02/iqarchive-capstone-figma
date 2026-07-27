Yes, it is absolutely possible and very easy to integrate!

To achieve this in Laravel, we use the official first-party package Laravel Socialite. It provides a clean, secure, and fluent interface for OAuth authentication with Google.

Here is a breakdown of how the integration would work and how we can restrict access strictly to Bicol University (BU) emails:

How We Implement It
mermaid
sequenceDiagram
    actor User
    participant App as IQArchive App
    participant Google as Google Identity Provider
    participant DB as Database
    User->>App: Clicks "Sign in with Google"
    App->>Google: Redirect to Google OAuth Consent Page
    User->>Google: Grant permissions & login
    Google->>App: Callback with User Details (Token, Email, Name)
    App->>App: Validate email ends with '@bicol-u.edu.ph'
    alt Email is Invalid
        App-->>User: Redirect to Login with error: "BU email required"
    else Email is Valid
        App->>DB: Find or Create User by email/google_id
        App->>User: Set auth session & redirect to Dashboard
    end
High-Level Step-by-Step Plan
1. Install Laravel Socialite
We install the package using Composer:

bash
composer require laravel/socialite
2. Set Up Google Developer Console
We would create a project in the Google Cloud Console to:

Enable the Google People API.
Configure the OAuth Consent Screen.
Generate OAuth 2.0 Client credentials (Client ID and Secret).
Register the Authorized Redirect URI (e.g., http://localhost:8000/auth/google/callback for local testing, and the production domain equivalent).
3. Configure the Credentials
We store the credentials in the .env file and mapping them in 

config/services.php
:

env
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
ALLOWED_EMAIL_DOMAINS=bicol-u.edu.ph
4. Update the User Database Migration
Since users logging in with Google don't require password input, we would update the users schema:

Make the password field nullable().
Add a nullable google_id field (to link the Google account to the user record).
5. Implement the Authentication Logic
We would create a controller (e.g., GoogleAuthController) to handle the redirection and the callback:

php
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Models\User;
public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}
public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->user();
    } catch (\Exception $e) {
        return redirect()->route('login')->withErrors('Google authentication failed.');
    }
    // 🔒 RESTRICTION: Check if email belongs to the BU domain
    $allowedDomain = env('ALLOWED_EMAIL_DOMAINS', 'bicol-u.edu.ph');
    if (!Str::endsWith($googleUser->getEmail(), '@' . $allowedDomain)) {
        return redirect()->route('login')->withErrors("Access is restricted to official @{$allowedDomain} accounts.");
    }
    // Find or create the user in the database
    $user = User::firstOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
            'password' => null, // No password needed for OAuth-only users
            'role' => 'task-force', // Default role for auto-registered users, if allowed
        ]
    );
    // If the user already existed but didn't have google_id linked yet, link it
    if (!$user->google_id) {
        $user->update(['google_id' => $googleUser->getId()]);
    }
    auth()->login($user);
    return redirect()->route('dashboard');
}
6. Add the Button to the UI
We would update the login and registration Blade pages to add a styled Sign in with Google button.

💡 Key Design Decision to Consider
Auto-registration vs. Invited-only:
Option A (Auto-registration): Anyone with a @bicol-u.edu.ph email can sign in and gets a default role (e.g., task-force or accreditor). System administrators can then upgrade their roles later.
Option B (Invited-only): A user's account must first be pre-created by an administrator (with their role configured). The Google sign-in flow will only let them log in if their email already exists in the database.
Would you like to proceed with implementing this Google Auth integration? If so, let me know which configuration option (Option A or B) you prefer for user roles, and I'll prepare an implementation plan!