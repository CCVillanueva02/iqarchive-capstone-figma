<!--
================================================================================
IQArchive v2 — Task Plan: Google Workspace OAuth (SEC-03)
================================================================================
File: v2/tasks/google-workspace-oauth.tasks
Purpose: Authoritative task plan and implementation log for creating and
         verifying Google Workspace OAuth 2.0 single sign-on via Socialite,
         domain gating (@bicol-u.edu.ph), JIT provisioning, dev switcher,
         and session lifecycle management.
Related Docs:
  - Relational Database Design: v2/docs/db-design/database-design.md
  - Architecture Essentials: v2/docs/ARCHITECTURE-ESSENTIALS.md
  - Engineering Backlog: v2/TODOS.md
================================================================================
-->

# Google Workspace OAuth (SEC-03) — Task Plan & Implementation Log

## Plan

### High-Level Goal
Implement secure, institutional Google Workspace OAuth 2.0 single sign-on using `laravel/socialite`, strictly enforcing `@bicol-u.edu.ph` domain validation, profile synchronization, JIT provisioning, local `/dev` role switching, and session lifecycle controls.

### Scope
- **In Scope:**
  1. Package Installation: Install and configure `laravel/socialite`.
  2. OAuth Configuration: Setup `config/services.php` and `.env.example` for Google credentials with `hd=bicol-u.edu.ph` hosted domain hint.
  3. Domain Security Gating: Enforce `@bicol-u.edu.ph` email check before session creation; reject all external domains with clear Inertia flash alerts.
  4. Account Linking & JIT Provisioning: Link `google_id` and `avatar_url` to existing users; auto-provision new institutional users if not pre-registered.
  5. Inactive Account Blocking: Block login for users with `status = 'inactive'`.
  6. Audit Logging: Record `auth.login` and `auth.logout` events in `audit_logs` with IP and client details.
  7. Local Developer Sandbox (`/dev`): Port the v1 instant role switcher for seamless local development across all 7 roles without Google credentials.
  8. Frontend Login View Polish: Connect `Login.vue` button to `/auth/google/redirect` and display domain error banners.
  9. Automated Feature Tests: Test OAuth redirect, callback validation, domain rejection, deactivated account block, and `/dev` switcher in `tests/Feature/GoogleAuthTest.php`.
- **Out of Scope:**
  - Traditional email/password registration (prohibited by university policy).
  - Multi-factor authentication beyond Google Workspace's institutional 2FA.

### Key Decisions & Architecture
- **Socialite Standard:** Use official `laravel/socialite` for OAuth flow.
- **Hosted Domain Hint (`hd`):** Add `with(['hd' => 'bicol-u.edu.ph'])` on Google redirect to prompt Google to select BU accounts by default, with server-side validation on callback.
- **Local Dev Sandbox:** Isolate `/dev` routes strictly behind `app()->environment('local')` to enable instant switching during development without API calls.
- **Stateless Fallback in Local:** Catch state mismatches gracefully in local testing.

### Edge Cases to Handle
- User attempts to log in with personal `@gmail.com` account -> Rejected with clear message.
- Pre-existing user with matching email but no `google_id` -> Linked on first Google login.
- Inactive user attempts login -> Denied with "Your account is deactivated" message.
- Session fixation: Regenerate session token on login and invalidate on logout.

### Testing Strategy
- Feature test mocking Socialite Google provider returning `@bicol-u.edu.ph` user.
- Feature test asserting that non-BU email (`@gmail.com`) is rejected and redirected to `/login` with error.
- Feature test asserting inactive user cannot authenticate.
- Feature test asserting that `/dev/login/{role}` works in `local` environment and is 404 in `production`.
- Feature test verifying `audit_logs` records login event.

---

## Implementation Progress

### Session 1 — Autoplan & Implementation
- [x] Subtask 1: Install `laravel/socialite` and configure Google OAuth service using v1 credentials
- [x] Subtask 2: Implement `AuthController` (redirect, callback, @bicol-u.edu.ph domain validation, JIT provisioning, logout)
- [x] Subtask 3: Implement local Developer Sandbox (`DevAuthController`, `/dev` and `/dev/login/{role}` console)
- [x] Subtask 4: Synthesize unified landing & auth portal (`Login.vue` + `DevLogin.vue` mixing `01-landing-page.png` and `02-login-page.png`)
- [x] Subtask 5: Create and verify comprehensive `GoogleAuthTest` (all 8 tests passing with 55 assertions)
- [x] Subtask 6: Update `v2/TODOS.md` backlog

## Final Status
- Completed: 2026-09-20
- Tests: ✓ 25 tests passing (149 assertions across test suite)
- Security review: ✓ Institutional email gate (@bicol-u.edu.ph only), JIT provisioning with default role, inactive account block, session fixation defense, immutable audit logging, and local dev routes strictly gated to local/testing environments.
- Commits: Ready for atomic commit.

## Lessons & Notes
- Bicol University Google Workspace Single Sign-On ensures no user passwords are stored or handled by the system.
- Synthesis of the landing page and authentication view into a single split hero provides immediate accreditation context for institutional users while streamlining single sign-on access.
- Local sandbox switcher (`/dev/login/{role}`) ensures offline development across all 7 institutional roles without needing live Google API callbacks.
