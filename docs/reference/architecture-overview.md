# System Architecture Overview

This reference document outlines the core architecture of IQArchive, including the TALL technology stack, architectural layers, and module boundaries.

---

## 1. Technology Stack (TALL)

IQArchive is architected on the **TALL stack**, combining server-driven reactivity with modern styling and robust relational data integrity:

```
┌────────────────────────────────────────────────────────┐
│                        Flux UI                         │
│         Tailwind CSS v4 & Alpine.js Design System      │
├────────────────────────────────────────────────────────┤
│                      Livewire 4                        │
│       Reactive Server-Side Components & State Sync     │
├────────────────────────────────────────────────────────┤
│                       Laravel                          │
│     Routing, Fortify Auth, Socialite, Observers, ORM   │
├────────────────────────────────────────────────────────┤
│                   Relational Database                  │
│       PostgreSQL / MySQL / SQLite (ACID Compliance)    │
└────────────────────────────────────────────────────────┘
```

- **Tailwind CSS v4 & Flux UI:** Centralized tokens declared via `@theme` in `resources/css/app.css`, providing consistent institutional navy, brand orange, and zinc color scales.
- **Alpine.js:** Embedded client-side micro-interactions and modal toggles managed seamlessly by Livewire and Flux.
- **Laravel Framework:** Core backend engine managing routing (`routes/web.php`), Eloquent ORM relationships, Gate/Policy authorization, and event observers.
- **Livewire:** Component-based reactive presentation layer (`app/Livewire/`) streaming real-time DOM diffs over AJAX without requiring a separate single-page application (SPA) frontend.

---

## 2. Core Module Boundaries

The application is structured into five distinct subsystem domains:

```
app/
├── Http/Controllers/     # Stateless OAuth, document downloads, export streams
├── Livewire/
│   ├── Actions/          # Atomic UI action forms
│   ├── CollegeHead/      # Dean verification and instrument customization
│   ├── Configuration/    # Master instrument templates and university settings
│   ├── Documents/        # Evidence upload, OCR status, repository browsing
│   ├── IqaAdmin/         # Program monitoring, task force rosters, audit logs
│   ├── Monitoring/       # University-wide accreditation analytics
│   ├── SystemAdministrator/ # User lifecycle, role assignments, system logs
│   └── TaskForce/        # Criterion compliance checklists, file linking
└── Models/               # 22 Eloquent domain entities with audit observers
```

---

## 3. Subsystem Interoperability

1. **Authentication & Identity:** Handles multi-guard authentication, Google SSO domain restrictions (`@bicol-u.edu.ph`), passkeys, and account states.
2. **Organizational Hierarchy:** Bicol University colleges, satellite campuses, degree programs, and administrative offices.
3. **Accreditation & Dynamic Instruments:** Hierarchical evaluation frameworks (Areas $\rightarrow$ Parameters $\rightarrow$ Criteria) cloned per accreditation cycle.
4. **Document Archival & OCR:** Multi-category file management with automated background OCR extraction and time-bounded access requests.
5. **Auditing & Event Sinks:** Automatic dispatch of `AuditLog` records for logins, updates, reviews, and deletions.

---

## 4. Security Architecture

- **Contextual Access Control:** Authorization is evaluated per request via Laravel Gates (`manageCollegesAndPrograms`, `viewTaskForceRoster`) and session-aware role helpers (`User::hasRole()`).
- **Encrypted Secrets:** Fortify 2FA tokens and sensitive parameters are encrypted using the application's AES-256 key (`APP_KEY`).
- **Audit Immutability:** Audit records are write-only without modification capabilities.

---

## 5. Cross-Quadrant Links

- **How-To Guide:** [User Onboarding Flow](file:///c:/Users/janss/Herd/iqarchive/docs/how-to/user-onboarding-flow.md)
- **Technical Reference:** [Google SSO Authentication Flow](file:///c:/Users/janss/Herd/iqarchive/docs/reference/auth-google-sso.md)
- **Role Specifications:** [RBAC: System Administrator](file:///c:/Users/janss/Herd/iqarchive/docs/reference/rbac-system-administrator.md) | [RBAC: IQA Staff](file:///c:/Users/janss/Herd/iqarchive/docs/reference/rbac-iqa-staff.md)
- **Explanation:** [IQA Staff Role Consolidation](file:///c:/Users/janss/Herd/iqarchive/docs/explanation/iqa-staff-role-consolidation.md)
