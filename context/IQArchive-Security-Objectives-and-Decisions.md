# IQArchive — Security Objectives & Decisions Log

A living document tracking the security requirements for IQArchive and the concrete decisions made to satisfy each one. Update this as each feature is implemented — this doc *is* the deliverable for the "document and explain the security decisions behind every feature" objective.

---

## 1. Authentication & Authorization

**Objective:** Implement authentication and authorization.

- **Status:** Scaffolded via Laravel Breeze (Livewire stack) — login, registration, session-based auth working.
- **Decision:** _(pending)_ Authorization approach — role column on `users` + Gates/Policies (see Objectives §4 below for rationale).
- **Rationale:** _to fill in as implemented_

---

## 2. Password Hashing

**Objective:** Apply password hashing.

- **Status:** Breeze uses Laravel's default `Hash` facade, which uses **bcrypt** by default (configurable to Argon2id in `config/hashing.php`).
- **Decision:** _(confirm)_ Keep bcrypt default, or switch to Argon2id?
- **Rationale:** Bcrypt is battle-tested and Laravel's default; Argon2id is more modern and resistant to GPU cracking but requires PHP built with Argon2 support. Worth explicitly stating which was chosen and why, even if keeping the default.

---

## 3. Session Management

**Objective:** Implement session management.

- **Status:** Breeze uses Laravel's built-in session guard (`web` guard, database or file session driver depending on `.env`).
- **Decision:** _(pending)_ Session driver (`database` recommended over `file` for auditability and multi-server readiness), session lifetime, `expire_on_close`, secure cookie flags in production.
- **Rationale:** _to fill in — e.g. session fixation protection (Laravel regenerates session ID on login by default), idle timeout policy for a compliance-sensitive system._

---

## 4. Role-Based Access Control (RBAC)

**Objective:** Build role-based access control (RBAC).

- **Status:** Not yet implemented.
- **Decision:** Simple `role_id` FK on `users` table (matches finalized ERD) + Laravel **Policies/Gates**, rather than Spatie Laravel-Permission.
- **Roles (from CFD):** System Administrator, IQA Admin, IQA Member, Accreditor, University Administrator/Executive, Task Force, College/Department Head & Program Chair.
- **Rationale:** Access rules in this system are role-level ("is this role allowed to do X"), not per-user overrides — a simpler, auditable model that matches the already-approved ERD. Revisit only if per-user permission exceptions become a real requirement.

---

## 5. Input Validation & Sanitization

**Objective:** Validate and sanitize all user inputs.

- **Status:** Not yet implemented beyond Breeze's default form validation.
- **Decision:** _(pending)_ Use Laravel **Form Request classes** for every form/endpoint (not inline controller validation), explicit rules per field, and output escaping via Blade's default `{{ }}` (auto-escapes) — never `{!! !!}` on user input.
- **Rationale:** _to fill in per module as built — e.g. document upload validation (file type/size for OCR pipeline), compliance report fields, account creation fields._

---

## 6. Forgot-Password / Reset-Password Workflow

**Objective:** Implement a secure forgot-password/reset-password workflow.

- **Status:** Scaffolded via Breeze — uses Laravel's built-in `Password` broker, signed/expiring tokens stored (hashed) in `password_reset_tokens` table.
- **Decision:** _(confirm)_ Default token expiry (60 min) — keep or adjust? Rate limiting on reset requests (Breeze includes basic throttling)?
- **Rationale:** _to fill in — Laravel's default reset flow already follows OWASP guidance (single-use, expiring, hashed tokens sent via signed email link, no user enumeration on the "forgot password" form). Document explicitly rather than assuming defaults are sufficient without review._

---

## 7. Audit Logging

**Objective:** Implement audit logging for accountability and non-repudiation.

- **Status:** Not yet implemented. Present in ERD as an `AuditLog` entity; CFD shows Audit Log flowing to System Administrator.
- **Decision:** _(pending)_ Approach — Laravel model events/observers writing to `audit_logs` table (actor, action, target entity, timestamp, IP) vs. a package like `spatie/laravel-activitylog`.
- **Rationale:** _to fill in — needs to cover at minimum: login/logout, account create/revoke/edit, document submission, document review actions (approve/deny), and access to restricted documents, since these are the flows explicitly shown in the CFD._

---

## 8. Security Decisions Not Yet Categorized

_(Space for anything that comes up during implementation that doesn't map cleanly to one objective above — e.g. CSRF protection, rate limiting/throttling on login attempts, HTTPS enforcement, file upload security for the OCR pipeline.)_

---

## Revision Log

| Date | Change |
|---|---|
| 2026-07-16 | Initial document created; objectives outlined, defaults noted from Breeze scaffolding |
