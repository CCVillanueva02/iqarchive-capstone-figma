# gStack-Antigravity Usage Guide & Workflow Reference

This guide catalogs all **34 specialized gStack workflows** available in IQArchive and defines the recommended end-to-end engineering lifecycle from ideation to release.

---

## 1. Complete Workflow Directory (34 Workflows)

### A. Ideation, Specification & Planning
| Slash Command | Persona / Role | When to Use |
| :--- | :--- | :--- |
| `/office-hours` | Founder / YC Partner | Early brainstorming; pressure-tests product wedges, users, and assumptions before planning. |
| `/spec` | Product Architect | Turns ambiguous intent into a structured 5-phase executable technical specification. |
| `/plan-ceo-review` | CEO / Strategic Lead | Reviews plan strategy, user value, and ambition (10-star product framework). |
| `/plan-design-review` | Design Lead | Evaluates planned UI/UX, interaction hierarchy, and design tokens (anti-slop audit). |
| `/plan-eng-review` | Engineering Manager | Locks architecture, failure modes, data flow, and test matrices before writing code. |
| `/autoplan` | Pipeline Orchestrator | Sequentially executes CEO, Design, and Eng plan reviews in one automated pass. |

---

### B. UI Design, Prototyping & Visual Modeling
| Slash Command | Persona / Role | When to Use |
| :--- | :--- | :--- |
| `/design-consultation` | Design System Lead | Creates complete design tokens and UI architecture from scratch. |
| `/design-shotgun` | Creative Director | Generates 3–4 distinct visual layout variations to compare before building. |
| `/design-html` | UI Engineer | Converts mockups, plans, or wireframes into production-grade HTML/CSS/Blade. |
| `/design-review` | Visual QA Lead | Designer's eye visual audit for spacing, contrast, micro-animations, and token alignment. |
| `/diagram` | Solution Architect | Generates clean Mermaid diagrams, SVG/PNG assets, and architecture flowcharts. |

---

### C. Safety, Guardrails & Access Isolation
| Slash Command | Persona / Role | When to Use |
| :--- | :--- | :--- |
| `/guard` | Safety Enforcement | Maximum safety mode combining directory edit locks (`/freeze`) + destructive warnings (`/careful`). |
| `/freeze` | Scope Restriction | Confines agent edits strictly to a specified folder (e.g. `/freeze docs/` or `/freeze app/Models/`). |
| `/unfreeze` | Scope Release | Clears directory edit restrictions. |
| `/careful` | Safe Terminal Guard | Intercepts and warns before destructive shell commands (`rm -rf`, `migrate:fresh`, `drop table`). |

---

### D. Code Quality, Investigation & Security Auditing
| Slash Command | Persona / Role | When to Use |
| :--- | :--- | :--- |
| `/investigate` | Root Cause Detective | Systematic 6-phase debugging with hypothesis testing and a 3-attempt circuit breaker. |
| `/health` | Quality Inspector | Runs test suites, type checks, linters, and dead-code audits to compute a health score. |
| `/codex` | Multi-AI Reviewer | Independent second opinion from OpenAI Codex CLI for diff review and consultation. |
| `/cso` | Chief Security Officer | Deep security audit (OWASP Top 10, STRIDE threat modeling, RBAC gate checks). |

---

### E. Browser Automation & QA Testing
| Slash Command | Persona / Role | When to Use |
| :--- | :--- | :--- |
| `/browse` | QA Browser Operator | Headless Chromium automation (~100ms commands, screenshots, DOM assertions, form filling). |
| `/setup-cookies` | Auth Bridge | Imports browser cookies from Chrome/Edge/Arc to test authenticated pages without manual login. |
| `/qa-only` | QA Auditor | Non-destructive, report-only QA test pass with health score (0–100) and zero code modifications. |
| `/qa` | QA Engineer | Active QA testing pass that detects bugs, applies minimal fixes, and verifies in-browser. |
| `/benchmark` | Performance Analyst | Benchmarks Core Web Vitals, page load times, and resource weights to detect regressions. |

---

### F. Shipping, Deployment & Post-Ship Lifecycle
| Slash Command | Persona / Role | When to Use |
| :--- | :--- | :--- |
| `/review` | Pre-Landing Reviewer | Analyzes PR diffs against base branch for SQL safety, race conditions, and side effects. |
| `/ship` | Release Engine | Runs tests, audits test coverage, bumps VERSION, updates CHANGELOG, and creates PR. |
| `/setup-deploy` | DevOps Engineer | Configures deployment settings for `/land-and-deploy` across hosting platforms. |
| `/land-and-deploy` | Deploy Coordinator | Merges PR, triggers deployment pipeline, and runs health verification. |
| `/canary` | Production Monitor | Monitors live production endpoints for console errors, performance drops, and 500s. |
| `/document-release` | Docs Strategist | Post-ship doc sync: cross-references git diff, catches doc drift, and updates coverage maps. |
| `/document-generate` | Tech Writer | Creates missing Diataxis documentation for features/modules flagged by `/document-release`. |
| `/make-pdf` | Publication Engine | Converts markdown documents into publication-quality PDFs with cover pages and clickable TOCs. |
| `/retro` | Team Facilitator | Retrospective analyzing commit trends, code churn, cycle velocity, and process lessons. |

---

## 2. Standard IQArchive Engineering Flow

To maximize code quality, security, and velocity, follow this 5-stage lifecycle for every feature:

```
[1. Ideation & Planning]   ──►   [2. UI & Architecture]   ──►   [3. Guarded Coding]
   • /office-hours                  • /autoplan                     • /guard (or /freeze)
   • /spec                          • /design-html                  • /investigate (for bugs)
                                    • /diagram                      • /codex (2nd opinion)
                                           │
                                           ▼
[5. Post-Ship & Ops]       ◄──   [4. Pre-Ship & QA Audit]
   • /document-release              • /qa-only (Report before demo)
   • /document-generate (Gaps)      • /qa (Iterative bug fixes)
   • /canary (Post-deploy monitor)  • /cso (Security audit)
   • /retro (Sprint reflection)     • /ship (PR & test verification)
```

---

## 3. Defense & Demo Best Practices

1. **Run `/qa-only` Right Before Demonstrations:** Always execute `/qa-only` before a capstone defense or panel review. It produces a comprehensive health report without modifying working code.
2. **Post-Ship Drift Catching:** Always run `/document-release` immediately after merging a feature branch. It automatically triggers `/document-generate` for newly added entities.
3. **Safety First:** When refactoring delicate modules (e.g. database schema or auth controllers), run `/freeze <target-folder>` to guarantee the AI agent touches only intended files.

---

## 4. Cross-Quadrant Links

- **Documentation Hub:** [IQArchive Documentation Hub](../index.md)
- **Tutorials:** [Developer Quickstart](../tutorials/developer-quickstart.md)
- **Technical Reference:** [System Architecture Overview](../reference/architecture-overview.md)
