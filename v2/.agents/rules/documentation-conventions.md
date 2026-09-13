---
trigger: always_on
---

# Documentation Conventions & Architecture

This persistent project rule governs all documentation generation, maintenance, restructuring, and release updates across the IQArchive repository. It applies passively across all documentation tasks and gStack personas (such as `/document-generate` and `/document-release`).

---

## 1. Directory & Quadrant Structure (Diataxis Framework)

Documentation is strictly organized into four Diataxis quadrants under `docs/`, with `docs/index.md` acting as the central documentation hub:

```
docs/
├── index.md                 # Central hub linking to all four quadrants and overview
├── tutorials/               # Learning-oriented: step-by-step guides for newcomers
├── how-to/                  # Problem-oriented: task-focused practical recipes
├── reference/               # Information-oriented: technical descriptions, schemas, APIs
└── explanation/             # Understanding-oriented: architectural decisions, background, design rationale
```

- [`docs/index.md`](../../docs/index.md) serves as the primary entry point and documentation map, indexing all four quadrants.

---

## 2. File-Scope & Size Rules

- **Entity / Feature / Concept Granularity:** Maintain **one file per feature, entity, or concept**. Never create a single monolithic document covering an entire quadrant.
- **Line Count Cap (~150 Lines):** If any documentation file (especially in `docs/reference/` or `docs/explanation/`) exceeds approximately **150 lines**, proactively refactor and split it into smaller, entity-scoped files.
- **Modular Partial / Topic Organization:** Break down large concepts into distinct sub-documents rather than bloating existing files.

---

## 3. Cross-Linking & Navigation (Max 2-Click Reachability)

- **Cross-Quadrant Linking:** Every new documentation file **must link to at least one related file in a different quadrant** (e.g., a reference doc in `docs/reference/` links to its corresponding explanation doc in `docs/explanation/` if one exists, or to a relevant how-to guide).
- **2-Click Reachability:** Every documentation file must be discoverable and reachable within **maximum 2 clicks from `docs/index.md`**:
  - `docs/index.md` $\rightarrow$ Quadrant / Category Index $\rightarrow$ Topic Document, or
  - `docs/index.md` $\rightarrow$ Topic Document directly.

---

## 4. Workflow Triggers & Tooling Lifecycle

- **Post-Ship Drift Catching (`/document-release`):** After implementing and shipping any feature or pull request, always run `/document-release` (not `/document-generate`) to catch documentation drift and update the coverage map.
- **Automated Gaps Handling:** `/document-release` will chain into `/document-generate` automatically for genuinely new entities, modules, or features that the coverage map flags as gaps.
- **Voice & History Preservation:** Polish CHANGELOG voice and documentation accuracy without overwriting historical release notes or changelogs.

---

## 5. File Naming Conventions

- **Kebab-Case Naming:** All documentation filenames must strictly use lowercase `kebab-case` matching the entity or feature name.
  - **Correct:** `task-force-members.md`, `audit-logging.md`, `storage-drivers.md`
  - **Incorrect:** `TaskForceMembers.md`, `task_force_members.md`, `doc1.md`, `misc.md`
- **Descriptive & Explicit:** Avoid generic or ambiguous file names. Name the exact concept or entity directly.

---

## 6. Security & Architectural Documentation Requirement

Every documented feature must articulate security reasoning and constraints where applicable (e.g., encryption of sensitive fields, authorization/RBAC gate enforcement, audit logging trails, and input sanitization boundaries).
