# gstack-antigravity — Usage Guide (IQArchive-capstone)

A framework of AI "personas" (CEO, Eng Manager, Designer, QA, etc.) that guide
Antigravity's agent through structured workflows for planning, reviewing,
shipping, and debugging. This guide covers how it's wired up in this project
and how to actually use it day to day.

## Command reference

### Planning & review
| Command | What it does |
|---|---|
| `/office-hours` | YC-style brainstorming — Startup mode (six forcing questions: demand, status quo, specificity, wedge, surprise, future-fit) or Builder mode (design-thinking for side projects). Use before writing code on a new idea. |
| `/plan-ceo-review` | Strategy & ambition review of a plan before building it. |
| `/plan-eng-review` | Architecture & execution review of a plan. |
| `/plan-design-review` | Reviews a plan through a designer's eye. |
| `/design-consultation` | Design-system implementation guidance. |
| `/autoplan` | Auto-review engineering pipeline. |

### Building & shipping
| Command | What it does |
|---|---|
| `/review` | Pre-landing PR review. |
| `/ship` | Runs the ship workflow (final checks before merge/release). |
| `/land-and-deploy` | Merge, deploy, and verify in one pass. |
| `/setup-deploy` | Configure deployment settings. |
| `/document-release` | Updates documentation after shipping. |
| `/retro` | Engineering retrospective after a sprint or release. |

### QA & investigation
| Command | What it does |
|---|---|
| `/qa` | Full QA testing pass. |
| `/qa-only` | Report-only QA testing (no fixes applied). |
| `/investigate` | Systematic debugging with root-cause investigation. |
| `/design-review` | Visual QA & polish pass. |
| `/benchmark` | Performance regression detection using the browse daemon. |
| `/canary` | Post-deploy canary monitoring. |
| `/codex` | Multi-AI second opinion — code review, challenge, or consult. |

### Safety & access control
| Command | What it does |
|---|---|
| `/guard` | Full safety mode. |
| `/freeze` | Restrict edits to a specific directory. |
| `/unfreeze` | Remove edit restrictions. |
| `/careful` | Cautious execution mode. |
| `/cso` | Chief Security Officer–style audit. |

### Browsing
| Command | What it does |
|---|---|
| `/browse` | Fast headless browser for QA testing and dogfooding your own site — always use this instead of default browser tools once gstack is active. |
| `/setup-cookies` | Import browser cookies (for testing behind login). |
| `/gstack-upgrade` | Self-updater — syncs the framework to the latest version and shows what changed. |

---

## Advised Flow

- **Start new features with `/office-hours`**, then `/plan-eng-review` before
  writing code — this matches the RAD-methodology, panel-feedback-driven
  workflow already documented for IQArchive.
- **Use `/qa-only` before `/qa`** if you just want a report without gstack
  making changes — useful right before a defense/demo when you don't want
  surprise edits.
- **`/browse`** is what powers headless testing of the actual IQArchive web
  app; make sure `bunx playwright install-deps chromium` has been run in
  whatever environment (WSL) actually executes it, since that's what fixed
  the Chromium launch failure during setup.
- **Updating gstack:** run `/gstack-upgrade`, or manually re-clone into
  `~/.antigravity/skills/gstack` and re-copy into the project the same way
  it was first installed — remember to strip CRLF line endings again
  (`sed -i 's/\r$//' <script>`) if you re-clone from Windows/PowerShell.

---

