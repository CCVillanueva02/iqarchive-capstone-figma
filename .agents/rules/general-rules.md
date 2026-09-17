---
trigger: always_on
---

# IQArchive v2 — General Project Rules & Core Engineering Standards

This persistent rule defines the foundational architecture, tech stack conventions, security policies, coding standards, and engineering workflows for the **IQArchive v2** codebase. It acts as the core entry point for the project and provides extension references to dedicated feature and domain specifications.

---

## 1. Project Overview & Architecture Foundation

IQArchive is a Document Management and Monitoring System supporting Bicol University's AACCUP accreditation process.

- **Architecture Pattern:** Modern monolithic 3-tier architecture (Inertia.js server-driven SPA).
- **Backend Application Core (Tier 2):** Laravel 11/13 MVC adhering to `Controller -> Service -> Eloquent Model / Policy` pipeline:
  - Controllers handle HTTP request/response orchestration only.
  - Services encapsulate complex business logic (e.g., `ProcessDocumentOcrService`).
  - Policies enforce server-side RBAC and authorization gates.
- **Frontend SPA (Tier 1):** Inertia.js + Vue 3 (Composition API with `<script setup>`) + Tailwind CSS v4 + UI primitives (Shadcn Vue, DaisyUI, Lucide Icons).
- **Database & Storage (Tier 3):** Laravel Cloud Managed MySQL 8 (strict 3NF schema, JSON columns for OCR confidence and page metrics) + Managed Cloud Object Storage (private S3 bucket at `evidence/{college_id}/{program_id}/{hash}.pdf`). All document streams require server-side policy authorization and use 15-minute temporary pre-signed URLs.
- **External & Supporting Services:**
  - **Google Workspace OAuth 2.0:** Single sign-on gated strictly to `@bicol-u.edu.ph` institutional accounts.
  - **Synchronous OCR Engine:** Inline OCR execution during document uploads targeted strictly at accreditation results (1–3 pages, 1.5–3s) with a split-screen human-in-the-loop validation UI (flagging words with confidence $< 0.65$). Dual-driver adapter supports Google Cloud Vision API in production with local Tesseract fallback for development.

### Domain Reference Specifications
When working on specific subsystems, consult and maintain consistency with the dedicated architectural documents:
- [System Architecture Specification](file:~/iqarchive/v2/docs/system-architecture/system-architecture.md)
- [Accreditation Stages & Pipeline](file:~/iqarchive/v2/docs/accre-pipeline/accreditation-stages.md)
- [RBAC & Role Definitions](file:~/iqarchive/v2/docs/rbac/roles.md)
- [Database Schema & ERD](file:~/iqarchive/v2/docs/db-design/IQArchive-ERD-CAPSTONE%202%20ERD.drawio.svg)

---

## 2. Accreditation Roles & Access Model (7 Roles)

Access and interface workflows are strictly organized around 7 institutional roles:

1. **System Administrator:** System configuration, user account management, and audit log oversight.
2. **IQA Staff / Member:** Central quality assurance coordinator; exclusively manages and authorizes all 9 stage transitions in the accreditation pipeline.
3. **College Dean:** Approves college-level evidence uploads; elevated to Task Force lead for their college.
4. **Task Force Member:** Program-level subject matter experts who upload evidence and map documents against AACCUP areas and criteria.
5. **Internal Accreditor:** Rehearsal/mock review panel; reads documents and provides advisory feedback/comments prior to formal submission (no veto or approval power).
6. **BU Executive:** University-wide leadership with read-only macro analytics and executive dashboards.
7. **External Accreditor:** Formal AACCUP evaluation team; read-only access granted strictly after formal submission.

---

## 3. Workstation Viewport Policy (Strict Desktop-Only)

- **Desktop Workstation Focus:** IQArchive is engineered strictly for desktop/laptop displays ($\ge 1024$px / `lg`+) due to complex accreditation matrices, split-screen OCR validation, and multi-document compliance inspections.
- **No Mobile Accommodation:** Developers and AI agents are **NOT** required to build or maintain responsive mobile layouts.
- **Global Mobile Guard:** On viewports $< 1024$px, the global `<MobileUnsupported />` overlay renders a full-screen guard advising the user to switch to a desktop browser.

---

## 4. Security & Multi-Tenant Scoping

- **College Multi-Tenancy:** All queries must be strictly scoped by `college_id` so that academic units cannot inspect other colleges' non-public evidence or metrics.
- **Server-Side Authorization:** Every controller method must explicitly authorize the request (e.g., `$this->authorize('view', $document)`) before executing business logic. Never rely on client-side UI visibility.
- **Security Reasoning Requirement:** Every newly introduced feature, route gate, policy rule, or cryptographic field must include a concise comment or docblock note articulating the underlying security rationale. This is a mandatory capstone requirement.

---

## 5. Mandatory Code Commenting & Modularity Standards

### Top-of-File Architecture Summary
Every file created or modified must begin with a comprehensive docblock / comment header detailing:
1. The file's core responsibility and purpose.
2. Its architectural role within the IQArchive system.
3. Relevant authorization, RBAC, or security context.
- Use native comment syntax (e.g., `/** ... */` for PHP/JS, `<!-- ... -->` or `//` for Vue, `/* ... */` for CSS).

### Comment Per Logical Block
Add an explanatory comment before every distinct logical unit (controller actions, service methods, reactive hooks, query scopes, complex algorithms, or major template sections) describing *what* the block does, *why* it is structured that way, and any non-obvious business or security logic.

### Preferred Modularity & Component Reuse
- Keep components, composables, and controllers modular, cohesive, and maintainable.
- While strict arbitrary line caps are not enforced, prefer proactively extracting complex views or reusable UI blocks into dedicated partials or sub-components.
- Check for existing patterns or components before creating duplicate UI widgets.

---

## 6. Granular & Incremental Commits Policy

1. **No Bulky Commits:** Never accumulate large batches of unrelated changes into a single massive commit at the end of a session.
2. **Commit Every Meaningful Milestone:** Commit each distinct logical unit as soon as it is functional and verified (e.g., migration + model, service logic, Vue component, or fix).
3. **Atomic and Bisectable:** Ensure the codebase remains buildable and testable at every commit.
4. **Conventional Commit Messages:** Use the standard convention: `type(scope): concise description` (e.g., `feat(auth): ...`, `fix(ocr): ...`, `refactor(views): ...`, `test(documents): ...`).

---

## 7. Mandatory Automated Testing & Verification Policy

1. **Mandatory Test Creation for Every Feature & View:**
   - **Backend Features & APIs:** Whenever a new controller, service method, Eloquent policy, model relation, or route is created or modified, the agent **MUST** author a corresponding automated test (Pest / PHPUnit under `tests/Feature/` or `tests/Unit/`) covering the happy path, RBAC authorization gates, request validation, and relevant error pathways.
   - **Frontend Features & Views:** Whenever a new Vue page, Inertia view, persistent layout, or interactive component is created or modified, the agent **MUST** write corresponding test coverage (e.g., Inertia feature response tests asserting correct component rendering and shared props, or component tests validating UI state and interactions).
2. **Mandatory Test Execution & Verification:**
   - Writing tests is not enough—the agent **MUST run the test suite immediately** to verify the implementation before concluding the task or committing:
     - Run backend tests: `cmd /c php artisan test` (or targeted: `cmd /c php artisan test --filter=<TestName>`)
     - Run client build & frontend verification: `cmd /c npm run build` (and `cmd /c npm test` when frontend test runner is configured)
   - **Zero Tolerated Regressions:** Never leave tests in a failing state or commit unverified changes. If a test fails, diagnose the root cause and fix it immediately.

---

## 8. Local Dev Login & Testing Access Policy

When accessing or testing the running application locally (via manual testing, Playwright, or browser subagents):
- **Never use standard login credentials:** Dev login bypasses standard forms for rapid testing.
- **Sandbox Dashboard:** Access `/dev` to view the role sandbox and test switcher.
- **Instant Role Authentication:** Navigate directly to `/dev/login/{role}` for instantaneous role authentication:
  - System Administrator: `/dev/login/system-administrator`
  - IQA Staff / Member: `/dev/login/iqa-staff`
  - College Dean: `/dev/login/dean`
  - Task Force Member: `/dev/login/task-force-member`
  - Internal Accreditor: `/dev/login/internal-accreditor`
  - BU Executive: `/dev/login/bu-executive`
  - External Accreditor: `/dev/login/external-accreditor`
- **Security Isolation:** Dev login routes are strictly gated to `local` and `testing` environments (`app()->environment(['local', 'testing'])`) to guarantee zero risk in production.

---

## 9. gStack Core Engineering Principles

### Completeness Principle — Boil the Lake
- When implementing solutions, always complete the full scope: handle all relevant edge cases, error pathways, and complete implementations rather than deferring known work.
- Never choose a shortcut that leaves the task half-done when complete implementation costs minimal additional effort.

### AskUserQuestion Protocol
When asking the user a question to clarify requirements or solicit architectural decisions, follow this structured format:
1. **Re-ground:** State the project, current branch, and current plan/task in 1–2 sentences.
2. **Simplify:** Explain the problem in plain English with concrete examples, avoiding dense jargon.
3. **Recommend:** State `RECOMMENDATION: Choose [X] because [reason]` and provide a `Completeness: X/10` rating for each option.
4. **Options:** Present lettered options (`A) ... B) ...`) displaying effort scales comparing human team effort vs AI-assisted effort.