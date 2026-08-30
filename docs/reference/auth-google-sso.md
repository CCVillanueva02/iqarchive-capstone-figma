# Authentication Flow: Google SSO & Socialite

This reference document details the Google OAuth2 / Single Sign-On (SSO) integration powered by Laravel Socialite in IQArchive.

---

## 1. Flow Overview

IQArchive enforces strict institutional identity verification through Google OAuth2, ensuring only authorized Bicol University faculty and staff can access internal accreditation workspaces.

```
User -> [Click "Sign in with Google"]
         │
         ▼
    GET /auth/google ──(Socialite redirect with hd=bicol-u.edu.ph)──► Google Accounts
                                                                            │
                                                                       User Consents
                                                                            │
                                                                            ▼
    GET /auth/google/callback ◄─────────────────────────────────────────────┘
         │
         ├─► 1. Domain Validation (Check @bicol-u.edu.ph)
         ├─► 2. User Lookup (Match pre-registered email or google_id)
         ├─► 3. Status Verification (Reject inactive/revoked accounts)
         ├─► 4. Account Activation (Transition 'pending_activation' -> 'active')
         ├─► 5. Name Token Sanitization (Strip employee/student ID digits)
         ├─► 6. Avatar Synchronization
         ├─► 7. Audit Log Entry ('GOOGLE_LOGIN')
         │
         ▼
    Redirect -> /dashboard (Dynamic Role Gateway)
```

---

## 2. Technical Implementation Details

- **Controller:** [`App\Http\Controllers\GoogleAuthController`](../../app/Http/Controllers/GoogleAuthController.php)
- **Routes:**
  - `GET /auth/google` (`name('auth.google')`) — Initiates Socialite redirect.
  - `GET /auth/google/callback` (`name('auth.google.callback')`) — Handles OAuth token exchange.

### Domain Restriction Enforcement
Configured via `ALLOWED_EMAIL_DOMAINS` in `.env`:
```php
$allowedDomainsSetting = env('ALLOWED_EMAIL_DOMAINS', 'bicol-u.edu.ph');
if ($allowedDomainsSetting && $allowedDomainsSetting !== '*') {
    $allowedDomains = array_filter(array_map('trim', explode(',', $allowedDomainsSetting)));
    $userDomain = Str::after($email, '@');
    if (!in_array($userDomain, $allowedDomains, true)) {
        return redirect()->route('login')->withErrors([
            'email' => "Access is restricted to official @" . implode(' or @', $allowedDomains) . " accounts.",
        ]);
    }
}
```

### Pre-Registration Requirement
Self-registration is disabled for institutional security. Unregistered Google accounts are blocked:
```php
$user = User::where('google_id', $googleUser->getId())
    ->orWhere('email', $email)
    ->first();

if (!$user) {
    return redirect()->route('login')->withErrors([
        'email' => 'Your account has not been pre-registered. Please contact the Internal Quality Assurance Office (bu-iqao@bicol-u.edu.ph) for access.',
    ]);
}
```

### Name Token Sanitization
When Google returns account names containing institutional ID numbers (e.g. `Jcmm2023 Santos`), a cleaning closure strips tokens with numbers before saving:
```php
$cleanNameToken = function (string $nameStr): string {
    $tokens = preg_split('/\s+/', trim($nameStr));
    $filtered = array_filter($tokens, fn($t) => !preg_match('/\d/', $t));
    return !empty($filtered) ? implode(' ', $filtered) : $nameStr;
};
```

---

## 3. Security Properties

1. **Anti-Tamper State:** Socialite handles CSRF OAuth state parameter validation.
2. **Account Linking:** Existing accounts are safely bound to `google_id` on first successful login.
3. **Audit Immutability:** Successful authentications log an immediate `GOOGLE_LOGIN` audit record.

---

## 4. Cross-Quadrant Links

- **How-To Guide:** [User Onboarding Flow](../how-to/user-onboarding-flow.md)
- **Database Schema:** [Authentication & Security Schema](./database-schema-auth-security.md)
- **Role Specifications:** [RBAC: System Administrator](./rbac-system-administrator.md)
