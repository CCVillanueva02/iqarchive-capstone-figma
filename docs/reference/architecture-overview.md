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
│                  Laravel 13 MVC Core                   │
│     Routing, Fortify Auth, Socialite, Observers, ORM   │
├────────────────────────────────────────────────────────┤
│                   Relational Database                  │
│             MySQL 8 InnoDB (Strict 3NF)                │
└────────────────────────────────────────────────────────┘
```

> **Target Architectural Diagram Asset:** See [System Architecture Vector SVG](../diagrams/system-architecture.svg) and [Mermaid Source](../diagrams/system-architecture.mmd).

---

## 2. Accurate System Architecture Blueprint

```mermaid
flowchart TD
    User["<b>User / Workstation Browser</b><br/>IQA Staff · College Dean · Task Force · Accreditor · BU Executive · System Admin"]
    User -->|"HTTPS (Desktop Browser Session ≥ 1024px)"| Tier1

    Tier1["<b>Tier 1 — Presentation & Interaction Layer: Livewire 4 · Alpine.js · Blade UI · Tailwind CSS v4</b><br/>• Reactive UI components with real-time DOM<br/>• In-place criteria document uploads, matrix drawers & modal wizards<br/>• Institutional design tokens (BU Navy & Brand Orange) & desktop viewport guard"]

    Tier1 -->|"Livewire RPC (Morph Diffs) / Internal Fetch"| Tier2

    Tier2["<b>Tier 2 — Modular Monolith Application Core: Laravel 13.x MVC Core</b><br/>• <b>Security Gateway:</b> Contextual RBAC, multi-tenant college isolation & Gate middleware<br/>• <b>Module A (Documents):</b> Multi-office taxonomy & authorized streaming gates<br/>• <b>Module B (Accreditation):</b> 10-Area AACCUP instrument tree & criterion linking<br/>• <b>Module C (Task Force):</b> Faculty roster setup & 2-tier Dean verification QC<br/>• <b>Module D (Monitoring):</b> Real-time analytics & compliance progress aggregations<br/>• <b>Event Sinks:</b> Automated Eloquent Observers piping to immutable audit trail"]

    Tier2 -->|"Eloquent ORM / ACID Transactions"| Tier3
    Tier2 <-->|"Streaming Authorization Gate (File Bytes)"| Storage
    Tier2 <-->|"OAuth 2.0 Handshake (HTTPS Server-side)"| IdP

    Tier3["<b>Tier 3 — Relational Database (MySQL 8 InnoDB)</b><br/>• Strict 3NF normalized schema<br/>• ACID transactions & cascade integrity<br/>• Immutable audit logs & user sessions"]

    Storage["<b>Protected File Storage (Isolated Physical Storage Disk)</b><br/>• Private accreditation evidence PDFs<br/>• Syllabi, licenses, institutional memos<br/>• Files stored strictly outside public web root (storage/app/protected/)<br/>• Served ONLY via streaming authorization gates"]

    IdP["<b>External — Identity Provider (Google Workspace OAuth 2.0)</b><br/>• Centralized institutional authentication<br/>• Domain-gated to @bicol-u.edu.ph (server-verified)<br/>• Pre-registration required (pending_activation)<br/>• First-login credential binding"]


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

- **How-To Guide:** [User Onboarding Flow](../how-to/user-onboarding-flow.md)
- **Technical Reference:** [Google SSO Authentication Flow](./auth-google-sso.md)
- **Role Specifications:** [RBAC: System Administrator](./rbac-system-administrator.md) | [RBAC: IQA Staff](./rbac-iqa-staff.md)
- **Explanation:** [IQA Staff Role Consolidation](../explanation/iqa-staff-role-consolidation.md)
