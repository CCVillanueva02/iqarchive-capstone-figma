# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

1. **Office of Internal Quality Assurance (IQA) Staff & Members:** University-level regulatory coordinators at Bicol University. They oversee accreditation survey cycles, audit submitted evidence against AACCUP criteria, endorse or reject documents, manage master survey instruments, and monitor compliance status across all colleges.
2. **College Deans & Academic Unit Heads:** Executive leadership of BU colleges (e.g., BUCS, CBEM, CENG). They track program readiness within their college, monitor compliance deficits, and conduct first-tier reviews of accreditation evidence.
3. **Accreditation Task Force Members (Faculty & Clerical Encorders):** Departmental faculty and program chairs assigned to specific AACCUP survey areas (Areas I–X: VMGO, Faculty, Curriculum, Support to Students, Research, Extension, Library, Physical Plant, Laboratories, Administration). They gather and upload PDF evidence and prepare self-survey matrices.
4. **Internal & External AACCUP Accreditors:** Peer reviewers evaluating academic degree programs during preliminary, formal, or revisit accreditation surveys. They require fast, read-only access to organized evidence matrices and compliance reports.
5. **University Administrators & BU Executives:** High-level leadership requiring executive compliance visibility, institutional accreditation standing, and readiness analytics across all 17 colleges and satellite campuses.

## Product Purpose

IQArchive transitions Bicol University from fragmented, unstandardized file storage (paper binders, disconnected Google Drives, untracked emails) to a unified, auditable **Document Management and Monitoring System tailored specifically for AACCUP Accreditation**. It provides a single source of truth for:
- Gathering, validating, and mapping evidence directly to AACCUP survey instruments.
- Centralizing institutional university policies in a shared common repository, eliminating duplicate uploads.
- Tracking accreditation deadlines, area deficits, and survey milestones with real-time dashboards and audit trails.
- Extracting and verifying physical accreditation results via assisted OCR with human-in-the-loop review.

## Positioning

Unlike generic cloud storage platforms (Google Drive, Dropbox) or general-purpose document management systems, IQArchive is engineered natively around the **AACCUP 10-Area Criteria Matrix** and Bicol University's decentralized collegiate structure. It enforces institutional multi-tenancy (`college_id` scoping), two-tier academic approval workflows (Dean review $\rightarrow$ IQA validation), and automated deficit detection aligned with Philippine state university accreditation mandates.

## Operating Context

- **Academic Calendar & Accreditation Cycles:** Periodic multi-year accreditation surveys (Candidate Status, Level I, Level II Re-accredited, Level III, Level IV) conducted by AACCUP survey teams.
- **Workflow Pipeline:**
  1. *Collection:* Task force gathers evidence across 10 distinct areas.
  2. *First-Tier Review:* Department chair or College Dean endorses submission.
  3. *Second-Tier Validation:* IQA Coordinator approves or returns with deficit notes.
  4. *Survey Visit:* Accreditors evaluate digital criteria binders and score benchmarks.
- **Evidence Scale:** Tens of thousands of institutional records, syllabi, board resolutions, MOUs, curriculum guides, and faculty credentials spanning 17 academic colleges and units.

## Capabilities and Constraints

- **Multi-Tenant College Isolation:** Every database record, evidence query, and storage path is strictly scoped by `college_id`. No cross-college data leaks are tolerated.
- **Role-Based Access Control (RBAC):** Strict server-side authorization gates backed by Laravel policies for 7 distinct institutional personas.
- **Authentication:** Exclusively Google Workspace OAuth restricted to the institutional `@bicol-u.edu.ph` domain. (Dev sandbox routes `/dev/login/{role}` available in local/testing environments).
- **Workstation Policy:** Strictly desktop-only ($\ge 1024\text{px}$). Handheld mobile access displays an informative `MobileUnsupported` overlay directing users to their desktop workstation.
- **Storage & Security:** S3-compatible cloud object storage delivering short-lived ($15\text{ min}$) pre-signed temporary URLs. Never expose direct public asset links.
- **UI Framework Standards:** Inertia.js + Vue 3 Composition API with Tailwind CSS v4 and DaisyUI component classes. Strict 150–200 line file size modularity.

## Brand Commitments

- **Institutional Identity:** Official Bicol University Colors:
  - BU Royal Blue (`#0038A8` / `--color-sidebar-blue`: `#1E293B` to `#0038A8` depth)
  - BU Orange (`#F26522` / `--color-bu-orange-500`)
- **Tone & Voice:** Authoritative, clean, administrative, transparent, and respectful of academic rigor.
- **Typography:** Inter for high-legibility interface typography; JetBrains Mono for code identifiers, criterion benchmark codes, and tabular data.

## Evidence on Hand

- **Existing Documentation:** Complete PRD (`v2/docs/PRD.md`), Architecture Guide (`v2/docs/architecture.md`), and Design Specification (`DESIGN.md`).
- **Real Organizational Structure:** 17 official Bicol University colleges, units, and satellite campuses seeded with accurate campus locations and degree programs.
- **Accreditation Instruments:** AACCUP survey instruments covering 10 areas with formal criteria and benchmark parameters.

## Product Principles

1. **100% Evidence Auditability:** Every uploaded document carries an immutable cryptographic fingerprint, uploader attribution, timestamp, and verification history.
2. **Zero Accreditation Blindspots:** Never let a program enter an AACCUP survey without automated warning of missing benchmarks, incomplete criteria, or unverified files.
3. **Single Source of Truth:** Institutional policies exist once in the Common Documents vault and link into any program requiring them, eliminating redundant storage.
4. **Desktop Precision:** High-density, clutter-free tabular layouts designed for multi-tab document auditing on standard desktop monitors.

## Accessibility & Inclusion

- Maintain WCAG 2.1 AA compliant contrast ($\ge 4.5:1$ for body and labels, $\ge 3:1$ for large headings and semantic indicators).
- Desktop keyboard accessibility with distinct `:focus-visible` rings on all interactive elements.
- Semantic HTML tags with descriptive `title` attributes on truncated institutional strings and document names.
