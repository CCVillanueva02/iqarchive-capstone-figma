# IQArchive — Initial Development Context

**Project:** IQArchive — A Document Management and Monitoring System for the Internal Quality Assurance (IQA) Office of Bicol University
**Stage:** Development kickoff (post-analysis/design phase)
**Date:** July 2026

---

## 1. Purpose

This document establishes the technical foundation and working assumptions for IQArchive as development begins. It translates the systems analysis artifacts already produced (Context Flow Diagram, Level 1 DFD, Sequence Diagrams, ERD) into concrete build decisions.

---

## 2. Tech Stack — TALL

| Layer | Choice | Notes |
|---|---|---|
| **T**ailwind CSS | Latest | Utility-first styling for all views/components |
| **A**lpine.js | Bundled with Livewire | Lightweight client-side interactivity where Livewire round-trips aren't ideal |
| **L**aravel | Latest LTS-compatible version | Core framework, routing, Eloquent ORM, queues |
| **L**ivewire | Latest (v3) | Reactive components for dashboards, document workflows, approval actions |

**Starter kit:** Laravel Breeze (Livewire stack) — provides auth scaffolding (login, registration, password reset) already wired to Livewire/Blade/Tailwind, which is then extended for role-based routing.

**Local environment:** Laravel Herd, with **Antigravity** as the AI-assisted IDE for development.

**Database:** MySQL.

**OCR Engine:** Tesseract OCR (self-hosted, free) — invoked as a background job during document submission (per the "Document Submission with OCR" process in the Level 1 DFD). Recommend the `thiagoalessio/tesseract_ocr` PHP wrapper, run via a queued Job so uploads don't block the request cycle.

---

## 3. Decisions Still Open (with recommended defaults)

### Role & Permission Handling — *undecided, recommend: simple role column*
Your finalized ERD already models a **single `users` table with a `role` foreign key** (normalized `roles` table), rather than a granular permission system. Recommendation: **stick with this** — a `role_id` on `users` + a `roles` lookup table (System Administrator, IQA Admin, IQA Member, Accreditor, University Administrator/Executive, Task Force, College/Department Head & Program Chair, Faculty Member) checked via Laravel Gates/Policies.

- Use this if: access rules are mostly "is this role allowed to see/do X" (matches your CFD's flow structure).
- Switch to **Spatie Laravel-Permission** only if you later need per-user permission overrides beyond role-level rules (e.g., a specific IQA Member granted elevated access). Can be adopted later without breaking the schema.

### File Storage — *undecided, recommend: local disk now, S3-ready later*
Use Laravel's **filesystem abstraction** (`Storage::disk()`) from day one, defaulting to the `local` disk for development/demo. Because all file operations go through the abstraction (never raw file paths), switching to an S3-compatible disk later is a config change, not a code change. Store only the disk path + metadata in the `documents` table, not the file itself.

---

## 4. Domain Model → Laravel Mapping

Based on the finalized ERD (Crow's Foot, 10 entities):

| ERD Entity | Laravel Model | Notes |
|---|---|---|
| User | `User` | Includes `role_id` FK |
| Role | `Role` | Lookup table |
| College | `College` | Lookup table |
| Document | `Document` | Merges `DocumentRequest` fields per your ERD decision |
| Instrument | `Instrument` | Accreditation instruments |
| ComplianceReport | `ComplianceReport` | |
| Notification | `Notification` | Normalized notification entity |
| AuditLog | `AuditLog` | Powers "Audit Log" flow to System Administrator |
| TaskForce | `TaskForce` | |
| AccreditationSubmission | `AccreditationSubmission` | Push-model submission to Accreditor |

*(Exact field-level schema should be pulled directly from your ERD `.drawio`/export when writing migrations — happy to generate migration stubs once you confirm the ERD export is the source of truth.)*

---

## 5. Core Modules (from Level 1 DFD → 7 Processes)

1. **Authentication** — Breeze + Livewire login/session, role-aware redirect after login
2. **Account Management** — IQA Admin creates/revokes/edits accounts (System Administrator oversees via Audit Log)
3. **Document Submission with OCR** — Upload → Tesseract extraction (queued job) → stored with metadata
4. **Document Requests and Access** — Two-tier model: unrestricted "common documents" tab vs. restricted request-approval workflow
5. **Instrument Management** — Building/managing accreditation instruments
6. **Compliance Monitoring and Reports** — Status tracking, compliance reports, notifications
7. **Accreditation Submission** — Push-model submission of compliance docs to Accreditor (read-only access on their end)

Each of these maps naturally to a Livewire component (or component group) plus a corresponding set of routes/policies gated by role.

---

## 6. Environment Setup Checklist

- [ ] Laravel Herd installed, PHP version matching Laravel's requirement
- [ ] MySQL running locally (via Herd or standalone)
- [ ] `laravel new iqarchive` → install Breeze with `--stack=livewire`
- [ ] Install Tailwind (comes with Breeze) — confirm Tailwind config matches any brand colors from your diagrams (blue/orange scheme used in CFD)
- [ ] Install Tesseract binary on the dev machine (`brew install tesseract` / `apt install tesseract-ocr` depending on OS) + PHP wrapper package
- [ ] Set up `roles`, `colleges` seeders early so role-based routing can be tested from day one
- [ ] Configure `.env` for local disk storage; leave S3 credentials as placeholders for later

---

## 7. Open Questions for Next Session

- Do you want migrations/models scaffolded first, or role-based auth/routing first?
- Should notifications be real-time (Livewire polling / Laravel Echo) or simple DB-backed + page refresh for now?
- Any specific Bicol University branding (colors, logo) to bake into the Tailwind config early?
