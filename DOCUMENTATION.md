# IT 122: Information Assurance & Security — Final Project Documentation

---

## I. Project Details

| Field | Details |
|---|---|
| **Project Title** | **IQArchive** — Institutional Quality Assurance Document Archive System |
| **Language / Framework** | PHP 8.3 / Laravel 12 (Livewire, Fortify, Flux UI, Tailwind CSS 4) |
| **GitHub** | *(insert your GitHub repository link here)* |
| **Date Submitted** | July 2026 |

---

## II. Team Roles

| Member Name | Features Assigned / Specific Tasks | Rating (/5) |
|---|---|---|
| *(Member 1)* | *(e.g. Authentication, Password Hashing, Login/Logout flow)* | /5 |
| *(Member 2)* | *(e.g. RBAC, Account CRUD, Sidebar navigation)* | /5 |
| *(Member 3)* | *(e.g. Forgot/Reset Password, Two-Factor Auth, Session Mgmt)* | /5 |
| *(Member 4)* | *(e.g. Audit Logging, Input Validation, Database Design)* | /5 |

> **Note:** Fill in your actual team members and their contributions above.

---

## III. Feature Documentation

---

### 1. Authentication (Login / Logout)

**What it does:**
Users authenticate via email and password on a branded login page. Upon successful login, they are redirected to a role-specific dashboard. Logout invalidates the session and redirects to the login page. Deactivated accounts (`status = 'inactive'`) are blocked at login with a descriptive error message.

**How we implemented it:**
We use **Laravel Fortify** as the authentication backend. A custom `authenticateUsing` callback in `FortifyServiceProvider` handles sanitization, validation, credential verification, and account status checking.

**Key Code Snippet — Custom Authentication Logic:**

```php
// app/Providers/FortifyServiceProvider.php

Fortify::authenticateUsing(function (Request $request) {
    // 1. Sanitize the input
    $email = trim(filter_var($request->input('email'), FILTER_SANITIZE_EMAIL));
    $password = $request->input('password');

    // 2. Validate user input
    $request->validate([
        'email' => ['required', 'string', 'email', 'max:255'],
        'password' => ['required', 'string'],
    ]);

    // 3. Retrieve user
    $user = User::where('email', $email)->first();

    // 4. Authenticate and verify status
    if ($user && Hash::check($password, $user->password)) {
        if ($user->status !== 'active') {
            throw ValidationException::withMessages([
                'email' => ['Your account has been deactivated.'],
            ]);
        }
        return $user;
    }

    // 5. Reject with generic error (prevents user enumeration)
    throw ValidationException::withMessages([
        'email' => ['These credentials do not match our records.'],
    ]);
});
```

**Security decisions:**
- Input is **sanitized** with `filter_var(FILTER_SANITIZE_EMAIL)` and `trim()` before processing.
- A **generic error message** is returned for both "user not found" and "wrong password" to prevent **user enumeration attacks**.
- Deactivated accounts are explicitly blocked at the authentication layer.

---

### 2. Password Hashing

**What it does:**
All user passwords are securely hashed before storage. Plaintext passwords are never stored in the database.

**How we implemented it:**
Laravel's Eloquent model cast `'password' => 'hashed'` automatically applies `bcrypt` hashing whenever the `password` attribute is set. For manual operations (e.g., the IQA Admin creating accounts), we also call `bcrypt()` explicitly.

**Key Code Snippet — Automatic Hashing via Model Cast:**

```php
// app/Models/User.php

protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',   // <-- auto-hashes on set
    ];
}
```

**Key Code Snippet — Hashing During Account Creation:**

```php
// app/Livewire/IqaAdmin/Accounts.php

User::create([
    'first_name' => $this->first_name,
    'email'      => $this->email,
    'password'   => bcrypt($this->password),  // bcrypt hash
    'role_id'    => $this->role_id,
    'status'     => 'active',
]);
```

**Security decisions:**
- `bcrypt` is used as the default hashing algorithm (cost factor 12 by default in Laravel).
- The `password` field is in the model's `$hidden` array, preventing it from ever appearing in JSON responses or logs.
- Passwords are validated with Laravel's `Password::default()` rule, enforcing minimum length requirements.

---

### 3. Session Management

**What it does:**
User sessions are stored server-side in a database `sessions` table (not in cookies). Users can view their active browser sessions (showing device type, IP address, browser name) from the Security settings page and log out of other sessions remotely.

**How we implemented it:**
Session driver is set to `database`. The `sessions` table stores session ID, user ID, IP address, user agent, and last activity timestamp. The settings security page queries this table to display active sessions and provides a "Log Out Other Browser Sessions" action.

**Key Code Snippet — Sessions Table Schema:**

```php
// database/migrations/..._create_users_table.php

Schema::create('sessions', function (Blueprint $table) {
    $table->string('id')->primary();
    $table->foreignId('user_id')->nullable()->index();
    $table->string('ip_address', 45)->nullable();
    $table->text('user_agent')->nullable();
    $table->longText('payload');
    $table->integer('last_activity')->index();
});
```

**Key Code Snippet — Session Configuration:**

```php
// .env
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

**Security decisions:**
- **Database session driver** ensures sessions cannot be tampered with client-side (unlike cookie-based sessions).
- IP addresses and user agents are logged for each session, enabling users to identify suspicious logins.
- Session expiration is set to 120 minutes of inactivity.
- Users can forcibly terminate other sessions, which is critical if a device is lost or compromised.

---

### 4. Role-Based Access Control (RBAC)

**What it does:**
The system defines **9 distinct roles**, each with access to specific views and functionalities. Users can only access pages assigned to their role. Unauthorized access to other roles' pages returns a 403 Forbidden error.

| Role Slug | Description |
|---|---|
| `system-administrator` | Full system access, audit trail viewer |
| `iqa-admin` | IQA administrator, manages accounts and documents |
| `iqa-member` | IQA staff member |
| `accreditor` | AACCUP accreditor |
| `university-administrator` | BU executive admin |
| `task-force` | QA task force lead |
| `college-head` | College head (Dean) |
| `program-chair` | Program chair |
| `faculty-member` | Faculty member |

**How we implemented it:**
Roles are stored in a dedicated `roles` table. Each user has a `role_id` foreign key. Route-level authorization checks the authenticated user's role against the expected role for the route.

**Key Code Snippet — Route-Level Authorization:**

```php
// routes/web.php

foreach ($roles as $role) {
    Route::get("roles/{$role}/dashboard", function () use ($role) {
        if ($role !== auth()->user()->role) {
            abort(403, 'Unauthorized action.');
        }
        return view("pages.roles.{$role}.dashboard");
    })->name("dashboard.{$role}");
}
```

**Key Code Snippet — Component-Level Guard (Livewire):**

```php
// app/Livewire/IqaAdmin/Accounts.php

public function mount()
{
    if (auth()->user()->role !== 'iqa-admin') {
        abort(403, 'Unauthorized action.');
    }
}
```

**Key Code Snippet — Sidebar Conditional Rendering:**

```blade
{{-- resources/views/layouts/app/sidebar.blade.php --}}

@if ($role === 'iqa-admin')
    <a href="{{ route('accounts.iqa-admin') }}" ...>
        <span>Accounts</span>
    </a>
@endif
```

**Security decisions:**
- Authorization is enforced at **both the route level and the component level**, providing defense-in-depth.
- Roles are stored relationally (not as strings on the user), making them easy to extend and audit.
- Sidebar navigation only renders links that the user is authorized to access, preventing accidental exposure.
- The IQA Admin exclusively controls user account creation — there is no public registration endpoint.

---

### 5. Input Validation & Sanitization

**What it does:**
All user-submitted data is validated against strict rules before being processed. Inputs are sanitized to prevent injection attacks (XSS, SQL injection). Validation errors are displayed inline next to form fields.

**How we implemented it:**
- Login: email is sanitized with `FILTER_SANITIZE_EMAIL` and validated as a required, valid email format.
- Account CRUD: all fields are validated with Laravel's `validate()` method, enforcing required fields, string lengths, unique email constraints, and foreign key existence checks.
- Blade templates use `{{ }}` (double curly braces) which auto-escape output to prevent XSS.
- Laravel's Eloquent ORM uses **parameterized queries** for all database operations, preventing SQL injection.

**Key Code Snippet — Account Creation Validation:**

```php
// app/Livewire/IqaAdmin/Accounts.php

$validated = $this->validate([
    'first_name'  => 'required|string|max:255',
    'middle_name' => 'nullable|string|max:255',
    'last_name'   => 'required|string|max:255',
    'email'       => 'required|email|max:255|unique:users,email',
    'password'    => 'required|string|min:8',
    'role_id'     => 'required|exists:roles,id',
    'college_id'  => 'nullable|exists:colleges,id',
    'program_id'  => 'nullable|exists:programs,id',
]);
```

**Key Code Snippet — Login Input Sanitization:**

```php
// app/Providers/FortifyServiceProvider.php

$email = trim(filter_var($request->input('email'), FILTER_SANITIZE_EMAIL));
```

**Security decisions:**
- All inputs are validated server-side (client-side validation alone is insufficient).
- Email uniqueness is enforced at both the validation and database constraint level.
- Blade's `{{ }}` escaping prevents reflected XSS attacks.
- Eloquent's query builder uses PDO prepared statements, eliminating SQL injection vectors.

---

### 6. Forgot Password / Reset Password Workflow

**What it does:**
Users can request a password reset link via email. Clicking the link takes them to a form to set a new password. The token is time-limited and single-use.

**How we implemented it:**
Laravel Fortify handles the full reset password flow:
1. User submits email on the "Forgot Password" page.
2. A time-limited, hashed token is stored in the `password_reset_tokens` table.
3. An email with a reset link (containing the token) is sent.
4. User clicks the link, enters a new password, and submits.
5. The `ResetUserPassword` action validates and hashes the new password.

**Key Code Snippet — Password Reset Tokens Schema:**

```php
// database/migrations/..._create_users_table.php

Schema::create('password_reset_tokens', function (Blueprint $table) {
    $table->string('email')->primary();
    $table->string('token');
    $table->timestamp('created_at')->nullable();
});
```

**Key Code Snippet — Reset User Password Action:**

```php
// app/Actions/Fortify/ResetUserPassword.php

public function reset(User $user, array $input): void
{
    Validator::make($input, [
        'password' => $this->passwordRules(),
    ])->validate();

    $user->forceFill([
        'password' => $input['password'],  // auto-hashed via model cast
    ])->save();
}
```

**Key Code Snippet — Password Validation Rules:**

```php
// app/Concerns/PasswordValidationRules.php

protected function passwordRules(): array
{
    return ['required', 'string', Password::default(), 'confirmed'];
}
```

**Security decisions:**
- Reset tokens are **hashed** before storage (Laravel hashes them by default).
- Tokens expire after 60 minutes (configurable via `config/auth.php`).
- The new password must be **confirmed** (entered twice) to prevent typos.
- `Password::default()` enforces a minimum length of 8 characters.

---

### 7. Two-Factor Authentication (2FA) & Passkeys

**What it does:**
Users can enable TOTP-based two-factor authentication from the Security settings page. When enabled, after entering their password, they must also provide a 6-digit code from their authenticator app. Recovery codes are generated for backup. Additionally, the system supports **passkeys** (WebAuthn) for passwordless sign-in.

**How we implemented it:**
- 2FA is provided by Laravel Fortify's `TwoFactorAuthenticatable` trait on the User model.
- The 2FA secret and recovery codes are stored encrypted in the `users` table.
- Passkeys use the WebAuthn standard via `PasskeyAuthenticatable` trait, with credentials stored in the `passkeys` table.

**Key Code Snippet — User Model Traits:**

```php
// app/Models/User.php

class User extends Authenticatable implements PasskeyUser
{
    use HasFactory, Notifiable, PasskeyAuthenticatable, TwoFactorAuthenticatable;
}
```

**Key Code Snippet — 2FA Columns Migration:**

```php
// database/migrations/..._add_two_factor_columns_to_users_table.php

Schema::table('users', function (Blueprint $table) {
    $table->text('two_factor_secret')->after('password')->nullable();
    $table->text('two_factor_recovery_codes')->after('two_factor_secret')->nullable();
    $table->timestamp('two_factor_confirmed_at')->after('two_factor_recovery_codes')->nullable();
});
```

**Key Code Snippet — Rate Limiting for 2FA:**

```php
// app/Providers/FortifyServiceProvider.php

RateLimiter::for('two-factor', function (Request $request) {
    return Limit::perMinute(5)->by($request->session()->get('login.id'));
});
```

**Security decisions:**
- 2FA secrets are stored **encrypted** in the database (not plaintext).
- Recovery codes provide a backup mechanism if the user loses their authenticator device.
- Rate limiting on 2FA attempts (5 per minute) prevents brute-force attacks on TOTP codes.
- Passkeys implement the FIDO2/WebAuthn standard, providing phishing-resistant authentication.

---

### 8. Audit Logging

**What it does:**
The system records all significant user actions in an `audit_logs` table, including logins, logouts, document uploads, approvals, rejections, and deletions. The System Administrator can view, search, and filter the complete audit trail through a dedicated dashboard page.

**How we implemented it:**
Audit logs are recorded as database entries with `user_id`, `action`, `target_type`, `target_id`, and a `timestamp`. The Audit Trail view is a Livewire component with tab-based filtering (General, Authentication, Documents), search, and user/action filters.

**Key Code Snippet — Audit Logs Schema:**

```php
// database/migrations/..._create_iqarchive_core_tables.php

Schema::create('audit_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
    $table->string('action');
    $table->string('target_type')->nullable();
    $table->unsignedBigInteger('target_id')->nullable();
    $table->timestamp('timestamp')->useCurrent();
});
```

**Key Code Snippet — Audit Trail Query with Filtering:**

```php
// app/Livewire/SystemAdministrator/AuditTrail.php

$logs = AuditLog::with('user')
    ->when($this->tab === 'authentication', function ($query) {
        $query->whereIn('action', ['login', 'logout']);
    })
    ->when($this->tab === 'documents', function ($query) {
        $query->where('action', 'like', 'document_%');
    })
    ->when($this->search, function ($query) {
        $query->where(function ($q) {
            $q->where('action', 'like', '%' . $this->search . '%')
              ->orWhere('target_type', 'like', '%' . $this->search . '%');
        });
    })
    ->orderBy('timestamp', 'desc')
    ->paginate(10);
```

**Security decisions:**
- Audit logs use `onDelete('set null')` on `user_id`, so logs persist even if the user is deleted — ensuring **non-repudiation**.
- Timestamps use `useCurrent()` to ensure server-authoritative times (not client-submitted).
- Only the **System Administrator** role has access to the Audit Trail page.
- Logs record both the acting user and the target resource, enabling full reconstruction of events.

---

### 9. Rate Limiting

**What it does:**
Login and 2FA endpoints are rate-limited to prevent brute-force and credential-stuffing attacks.

**How we implemented it:**
Laravel's `RateLimiter` is used to define per-minute limits. Login attempts are throttled by email + IP, 2FA by session ID, and passkeys by credential ID + IP.

**Key Code Snippet — Login Rate Limiting:**

```php
// app/Providers/FortifyServiceProvider.php

RateLimiter::for('login', function (Request $request) {
    $throttleKey = Str::transliterate(
        Str::lower($request->input(Fortify::username())) . '|' . $request->ip()
    );
    return Limit::perMinute(5)->by($throttleKey);
});
```

**Security decisions:**
- **5 login attempts per minute** per email+IP combination.
- The throttle key combines both email and IP to prevent distributed attacks while avoiding locking out legitimate users behind shared IPs.
- After exceeding the limit, the user sees a "Too Many Requests" error with a retry-after timer.

---

### 10. Account Management (IQA Admin CRUD)

**What it does:**
The IQA Administrator can create, view, edit, and deactivate/reactivate user accounts. There is no public self-registration — all accounts are provisioned by the admin. Deactivation is a soft status toggle (not hard deletion), preserving data integrity.

**How we implemented it:**
A Livewire component (`App\Livewire\IqaAdmin\Accounts`) handles all CRUD operations with modal dialogs, search, role/status filtering, and SweetAlert2 success notifications.

**Key Code Snippet — Account Deactivation (Soft Toggle):**

```php
// app/Livewire/IqaAdmin/Accounts.php

public function toggleAccountStatus()
{
    $user = User::findOrFail($this->userId);
    $newStatus = $user->status === 'active' ? 'inactive' : 'active';
    $user->update(['status' => $newStatus]);

    $this->dispatch('swal', [
        'icon'  => 'success',
        'title' => $newStatus === 'active' ? 'Activated!' : 'Deactivated!',
        'text'  => "User account has been {$newStatus} successfully.",
    ]);
}
```

**Security decisions:**
- **No public registration** — accounts are admin-created only, preventing unauthorized account creation.
- Soft deactivation (`status = 'inactive'`) preserves audit trails and document history.
- The `mount()` guard aborts with 403 if a non-IQA-admin user tries to access the page.
- Email uniqueness is enforced at both validation and database levels during creation/editing.

---

## IV. Database Design

### Entity-Relationship Overview

```
roles ──────────< users >──────────── colleges
                   │  │                   │
                   │  └──── programs ─────┘
                   │
        ┌──────────┼──────────────────┐
        │          │                  │
   audit_logs   sessions   password_reset_tokens
        │
   documents ──────────< document_categories
     │  │  │
     │  │  └── document_reviews
     │  └── document_ocr_validations
     │
     ├── accreditation_document_links ──< compliance_requirements ──< instruments
     ├── document_access_requests                                      │
     └── notifications                                          instrument_areas
                                  
   task_force_assignments (users ←→ programs)
   passkeys (users)
```

### All Tables

| # | Table Name | Purpose |
|---|---|---|
| 1 | `roles` | Stores role definitions (e.g., `iqa-admin`, `faculty-member`) |
| 2 | `colleges` | University colleges (e.g., College of Science) |
| 3 | `programs` | Academic programs under colleges (e.g., BS Computer Science) |
| 4 | `users` | User accounts with role, program, college affiliations, status |
| 5 | `password_reset_tokens` | Hashed tokens for the forgot-password workflow |
| 6 | `sessions` | Server-side session storage with IP/user-agent tracking |
| 7 | `passkeys` | WebAuthn/FIDO2 passkey credentials for passwordless login |
| 8 | `document_categories` | Classification categories for uploaded documents |
| 9 | `documents` | Uploaded accreditation documents with status and visibility |
| 10 | `document_ocr_validations` | OCR extraction results and validation status |
| 11 | `document_reviews` | Review decisions (approve/reject) with remarks |
| 12 | `instruments` | AACCUP accreditation instruments |
| 13 | `instrument_areas` | Areas within each accreditation instrument |
| 14 | `compliance_requirements` | Program compliance requirements per instrument |
| 15 | `accreditation_document_links` | Links documents to compliance requirements |
| 16 | `task_force_assignments` | Assigns task force members to programs |
| 17 | `notifications` | In-app notifications for users |
| 18 | `audit_logs` | Immutable record of all user actions for accountability |
| 19 | `document_access_requests` | Requests and approvals for restricted document access |

### Key Table Schemas

**`users` table:**

| Column | Type | Constraint |
|---|---|---|
| `id` | bigint (PK) | auto-increment |
| `role_id` | FK → `roles.id` | `onDelete('restrict')` |
| `program_id` | FK → `programs.id` | nullable, `onDelete('set null')` |
| `college_id` | FK → `colleges.id` | nullable, `onDelete('set null')` |
| `first_name` | string | required |
| `middle_name` | string | nullable |
| `last_name` | string | required |
| `email` | string | unique |
| `email_verified_at` | timestamp | nullable |
| `password` | string | bcrypt-hashed |
| `two_factor_secret` | text | nullable, encrypted |
| `two_factor_recovery_codes` | text | nullable, encrypted |
| `two_factor_confirmed_at` | timestamp | nullable |
| `status` | string | default `'active'` |
| `remember_token` | string | nullable |
| `created_at` / `updated_at` | timestamps | — |

**`audit_logs` table:**

| Column | Type | Constraint |
|---|---|---|
| `id` | bigint (PK) | auto-increment |
| `user_id` | FK → `users.id` | nullable, `onDelete('set null')` |
| `action` | string | e.g. `login`, `document_upload` |
| `target_type` | string | nullable (model class) |
| `target_id` | bigint | nullable |
| `timestamp` | timestamp | `useCurrent()` |

**`sessions` table:**

| Column | Type | Constraint |
|---|---|---|
| `id` | string (PK) | session identifier |
| `user_id` | FK → `users.id` | nullable, indexed |
| `ip_address` | string(45) | nullable (IPv4/IPv6) |
| `user_agent` | text | nullable |
| `payload` | longText | encrypted session data |
| `last_activity` | integer | unix timestamp, indexed |

---

> **All members must present. Grading is both GROUP and INDIVIDUAL.**
