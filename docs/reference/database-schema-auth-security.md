# Database Schema: Authentication & Security

This reference document details the relational tables governing identity, user accounts, authentication credentials, and multi-role assignments in IQArchive.

---

## 1. Tables Overview

| Table | Model | Migration Source | Purpose |
| :--- | :--- | :--- | :--- |
| [`roles`](../../app/Models/Role.php) | `App\Models\Role` | `0001_01_01_000000_create_users_table.php` | System access roles and capabilities. |
| [`users`](../../app/Models/User.php) | `App\Models\User` | `0001_01_01_000000_create_users_table.php` | Central user accounts and identity records. |
| `role_user` | Pivot (`User::roles()`) | `2026_07_30_000001_create_role_user_table...` | Many-to-many role assignments. |
| `passkeys` | Fortify Authenticatable | `2024_01_01_000000_create_passkeys_table.php` | WebAuthn biometric/hardware credentials. |
| `password_reset_tokens` | Framework managed | `0001_01_01_000000_create_users_table.php` | Secure tokens for password resets. |
| `sessions` | Framework managed | `0001_01_01_000000_create_users_table.php` | HTTP session state storage. |

---

## 2. Table Specifications

### `roles`
Stores predefined machine slugs and descriptive titles for RBAC enforcement.

```sql
CREATE TABLE roles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### `users`
Central user account table storing credentials, status, Google OAuth bindings, and organizational affiliations.

| Column | Type | Nullable | Default | Notes |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | No | Auto Inc | Primary Key. |
| `google_id` | `VARCHAR(255)` | Yes | `NULL` | Unique Google OAuth subject ID. |
| `google_avatar`| `VARCHAR(255)` | Yes | `NULL` | Profile photo URL from Google SSO. |
| `role_id` | `BIGINT UNSIGNED` | No | None | FK $\rightarrow$ `roles(id)` (`ON DELETE RESTRICT`). |
| `program_id` | `BIGINT UNSIGNED` | Yes | `NULL` | FK $\rightarrow$ `programs(id)` (`ON DELETE SET NULL`). |
| `college_id` | `BIGINT UNSIGNED` | Yes | `NULL` | FK $\rightarrow$ `colleges(id)` (`ON DELETE SET NULL`). |
| `first_name` | `VARCHAR(255)` | No | None | User first name. |
| `middle_name`| `VARCHAR(255)` | Yes | `NULL` | User middle name. |
| `last_name` | `VARCHAR(255)` | No | None | User last name. |
| `email` | `VARCHAR(255)` | No | None | Unique login email. |
| `avatar` | `VARCHAR(255)` | Yes | `NULL` | Storage path or external avatar URL. |
| `status` | `VARCHAR(255)` | No | `'active'` | `'active'`, `'pending_activation'`, `'inactive'`. |
| `password` | `VARCHAR(255)` | Yes | `NULL` | Hashed password (nullable for SSO). |
| `two_factor_secret` | `TEXT` | Yes | `NULL` | Encrypted 2FA TOTP secret. |

### `role_user` (Pivot)
Enables multi-role capability for faculty and administrators.

```sql
CREATE TABLE role_user (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    role_id BIGINT UNSIGNED NOT NULL REFERENCES roles(id) ON DELETE CASCADE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE(user_id, role_id)
);
```

### `passkeys`
Stores WebAuthn public keys for biometric/hardware security tokens.

```sql
CREATE TABLE passkeys (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    name VARCHAR(255) NOT NULL,
    credential_id VARCHAR(255) NOT NULL UNIQUE,
    credential JSON NOT NULL,
    last_used_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX(user_id)
);
```

---

## 3. Security Considerations

- **Password Hashes & 2FA Secrets:** All passwords use Bcrypt/Argon2 hashes. Two-factor secrets and recovery codes are encrypted at rest using Laravel's application key (`APP_KEY`).
- **Referential Integrity:** `users.role_id` uses `ON DELETE RESTRICT` to prevent accidental deletion of roles with active users.
- **Account State Verification:** The `status` field gates login access. Inactive and revoked accounts are rejected during Google SSO and Fortify authentication.

---

## 4. Cross-Quadrant Links

- **How-To Guide:** [User Onboarding Flow](../how-to/user-onboarding-flow.md)
- **Technical Reference:** [Google SSO Authentication Flow](./auth-google-sso.md)
- **Architecture Reference:** [System Architecture Overview](./architecture-overview.md)
