# IQArchive Documentation Hub

Welcome to the **IQArchive** (Institutional Quality Assurance Archive System) documentation directory. This documentation is structured using the **Diataxis framework** across four distinct quadrants.

---

## Documentation Quadrants

```
docs/
├── tutorials/       # Learning-Oriented: Step-by-step guides for newcomers
├── how-to/          # Problem-Oriented: Task-focused practical recipes
├── reference/       # Information-Oriented: Architecture, schemas, APIs, RBAC
└── explanation/     # Understanding-Oriented: Architectural background & design decisions
```

---

## 1. Tutorials & Guides (Learning-Oriented)
Practical walkthroughs designed to get you productive immediately.

- [Developer Environment Quickstart](tutorials/developer-quickstart.md) — Set up PHP, Composer, SQLite/MySQL, migrations, seeders, and run the local development server in 5 minutes.
- [gStack-Antigravity Workflow Guide](gstack-guide/gstack-guide.md) — Directory of all 34 AI personas and the recommended 5-stage engineering lifecycle.

---

## 2. How-To Guides (Problem-Oriented)
Step-by-step recipes for solving concrete administrative and operational tasks.

- [User Onboarding & Activation Flow](how-to/user-onboarding-flow.md) — Step-by-step guide for pre-registering users, Google SSO activation, and dashboard routing.

---

## 3. Reference (Information-Oriented)
Technical descriptions, system architectures, role matrices, and relational schemas.

### System Architecture & Authentication
- [System Architecture Overview](reference/architecture-overview.md) — TALL stack composition, reactive Livewire architecture, and module boundaries.
- [Google SSO Authentication Flow](reference/auth-google-sso.md) — Laravel Socialite OAuth2 mechanics, domain restrictions, and name sanitization.

### Role-Based Access Control (RBAC)
- [RBAC: System Administrator](reference/rbac-system-administrator.md) — User lifecycle management, global logs, and platform maintenance.
- [RBAC: IQA Staff](reference/rbac-iqa-staff.md) — Consolidated QA operational workflows, instrument templates, and reviews.
- [RBAC: College Head](reference/rbac-college-head.md) — Dean-level oversight, portfolio verification, and contextual task force leadership.
- [RBAC: Program Chair](reference/rbac-program-chair.md) — Departmental program oversight, faculty coordination, and checklist monitoring.
- [RBAC: Task Force Member](reference/rbac-task-force-member.md) — Evidence uploading, criteria linking, and self-survey rating.
- [RBAC: Accreditor](reference/rbac-accreditor.md) — Read-only evidence inspection, access requests, and submission scoring.
- [RBAC: University Administrator](reference/rbac-university-administrator.md) — Executive oversight, institutional metrics, and summary reporting.
- [RBAC: Task Force Members Pivot](reference/rbac-task-force-members-pivot.md) — Dynamic multi-team assignment and team roles (`lead` vs `member`).

### Relational Database Schemas
- [Database ERD & Seeders](reference/database-schema-erd.md) — Global Entity Relationship Diagram and seeder execution sequence.
- [Authentication & Security Schema](reference/database-schema-auth-security.md) — Tables: `roles`, `users`, `role_user`, `passkeys`, `sessions`.
- [Organizational Hierarchy Schema](reference/database-schema-organizational-hierarchy.md) — Tables: `colleges`, `programs`, `offices`.
- [Document Management Schema](reference/database-schema-document-management.md) — Tables: `documents`, `document_categories`, `document_ocr_validations`, `document_reviews`, `document_access_requests`.
- [Accreditations & Task Forces Schema](reference/database-schema-task-forces.md) — Tables: `accreditations`, `task_forces`, `task_force_members`, `task_force_assignments`.
- [Dynamic Instruments Schema](reference/database-schema-dynamic-instruments.md) — Tables: `instruments`, `instrument_areas`, `instrument_parameters`, `instrument_criteria`, `compliance_requirements`, `accreditation_document_links`.
- [System Auditing Schema](reference/database-schema-system-audit.md) — Tables: `audit_logs`, `notifications`.
- [Framework & Queue Infrastructure Schema](reference/database-schema-infrastructure-queues.md) — Tables: `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs`.
- [Self-Survey Subsystem Schema](reference/database-schema-self-survey.md) — Tables: `self_survey_areas`, `self_survey_parameters`, `self_survey_indicators`, `self_survey_ratings`.

---

## 4. Explanation (Understanding-Oriented)
In-depth discussions of architecture trade-offs, design rationale, and history.

- [IQA Staff Role Consolidation](explanation/iqa-staff-role-consolidation.md) — Why `iqa-admin` and `iqa-member` were merged into a single operational role.
- [College & Department Head Contextual Elevation](explanation/head-contextual-elevation.md) — Why Deans automatically become Task Force Leads via Eloquent observers without mutating baseline user roles.
