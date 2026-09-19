<!--
================================================================================
IQArchive v2 — Design System & UI/UX Specification
================================================================================
File: v2/docs/design-system.md
Purpose: Authoritative design system, visual token guidelines, and UI component
         standards for IQArchive v2.
Target Platform: Desktop-Only (>= 1024px) | Inertia.js + Vue 3 + Tailwind CSS v4
Associated Docs:
  - Project Rules: .agents/rules/general-rules.md
  - Architecture Essentials: v2/docs/ARCHITECTURE-ESSENTIALS.md
  - Master Architecture: v2/docs/ARCHITECTURE.md
  - Product PRD: v2/docs/PRD.md
  - System Modules: v2/docs/MODULES.md
  - RBAC Matrix: v2/docs/rbac/roles.md
================================================================================
-->

# IQArchive v2 — Design System & UI/UX Specification

This document defines the visual design system, UI component standards, layout patterns, and interaction guidelines for **IQArchive v2**.

---

## 1. Design Principles & Form Factor

### 1.1 Desktop-Only Mandate (>= 1024px)
Accreditation management involves dense 10-area evidence matrices, multi-level parameter trees, split-screen document viewers, and high-volume data tables.
- **Minimum Supported Viewport:** 1024px x 768px (Standard desktop or laptop).
- **Target Desktop Workspace:** 1440px x 900px and above.
- **Mobile and Tablet Viewports (< 1024px):** Blocked with a full-page `<MobileUnsupported />` view.

```
┌────────────────────────────────────────────────────────┐
│ <MobileUnsupported /> (Viewports < 1024px)             │
│                                                        │
│ [BU / IQArchive Logo]                                  │
│ Workstation Desktop Display Required                   │
│                                                        │
│ IQArchive accreditation tools, document verification,  │
│ and criteria matrices require a minimum screen width   │
│ of 1024px. Please access this portal from a desktop   │
│ or laptop computer.                                    │
│                                                        │
│ Current Viewport: [Width]px · Target: >= 1024px        │
└────────────────────────────────────────────────────────┘
```

### 1.2 Core Visual Values
1. **Academic Authority:** Clean, structured, and institutional. We avoid marketing clutter and flashy animations, focusing on clear typography and fast page loads for university staff.
2. **High Information Density with Clarity:** Faculty and reviewers process hundreds of accreditation parameters. Spacing, typography, and contrast must allow rapid scanning without eye strain.
3. **Deterministic Status Signaling:** Document statuses (Draft, Dean Endorsed, IQA Approved, Deficit) must be immediately obvious through consistent color coding and clear text badges.

---

## 2. Color System & Design Tokens

*(These tokens map to Tailwind CSS v4 variables; see [v2/docs/MODULES.md](file:///c:/Users/janss/Herd/iqarchive/v2/docs/MODULES.md) for module alignment).*

### 2.1 Institutional Brand Palette
Derived from Bicol University's official visual identity:

| Token Name | Hex Code | HSL | Semantic Role |
| :--- | :--- | :--- | :--- |
| `bu-orange-500` | `#F26522` | `hsl(19, 89%, 54%)` | Primary brand color, primary action buttons, key highlights. |
| `bu-orange-600` | `#D95316` | `hsl(19, 89%, 47%)` | Primary button hover state, active tab indicators. |
| `bu-orange-50` | `#FFF7ED` | `hsl(33, 100%, 96%)` | Subtle primary surface highlights, selected sidebar item background. |
| `bu-blue-900` | `#002878` | `hsl(220, 100%, 24%)` | Deep header background, executive navigation accents. |
| `bu-blue-700` | `#0038A8` | `hsl(220, 100%, 33%)` | Secondary brand color, institutional links, secondary badges. |
| `bu-blue-50` | `#EFF6FF` | `hsl(214, 100%, 97%)` | Secondary subtle background tint. |

### 2.2 Neutral Surface & Text Palette (Slate Scale)
Provides high-contrast legibility for accreditation documents and reports:

| Token Name | Light Mode | Dark Mode | Intended Usage |
| :--- | :--- | :--- | :--- |
| `surface-canvas` | `#F8FAFC` (`slate-50`) | `#0F172A` (`slate-900`) | Main application background behind cards. |
| `surface-card` | `#FFFFFF` (`white`) | `#1E293B` (`slate-800`) | Elevated content panels, data tables, modals. |
| `surface-muted` | `#F1F5F9` (`slate-100`) | `#334155` (`slate-700`) | Table header rows, disabled inputs, code tags. |
| `border-default` | `#E2E8F0` (`slate-200`) | `#334155` (`slate-700`) | Card borders, table dividers, input borders. |
| `text-primary` | `#0F172A` (`slate-900`) | `#F8FAFC` (`slate-50`) | Primary headings, table text, form values. |
| `text-secondary`| `#475569` (`slate-600`) | `#94A3B8` (`slate-400`) | Metadata labels, breadcrumbs, descriptions. |
| `text-muted` | `#94A3B8` (`slate-400`) | `#64748B` (`slate-500`) | Helper text, disabled buttons, subtle hints. |

### 2.3 Accreditation Workflow & Status Tokens
Standardized semantic colors for the 9-stage accreditation and document verification lifecycle:

| Status State | Background Tint | Border / Text | Meaning in IQArchive | Why This Choice? |
| :--- | :--- | :--- | :--- | :--- |
| **Draft / Pending** | `#FEF3C7` (`amber-100`) | `#B45309` (`amber-700`) | Initial faculty upload; awaiting dean review. | Amber signals work in progress requiring attention. |
| **Dean Endorsed** | `#E0F2FE` (`sky-100`) | `#0369A1` (`sky-700`) | Endorsed at college gate; ready for IQA review. | Sky blue signals an intermediate approved stage. |
| **IQA Approved** | `#D1FAE5` (`emerald-100`) | `#047857` (`emerald-700`) | Consolidated into official AACCUP survey package. | Emerald green indicates verified completion. |
| **Rejected / Deficit** | `#FEE2E2` (`rose-100`) | `#B91C1C` (`rose-700`) | Missing evidence, wrong file, or dean returned file. | Red immediately flags an obstacle or missing requirement. |
| **Internal Advisory** | `#EDE9FE` (`violet-100`) | `#6D28D9` (`violet-700`) | Mock accreditor feedback or recommendation note. | Purple distinguishes advisory comments from formal gate approvals. |
| **Common Vault** | `#E0E7FF` (`indigo-100`) | `#4338CA` (`indigo-700`) | Shared university-wide reference policy. | Indigo marks university-level shared reference assets. |

---

## 3. Typography Standards

### 3.1 Font Families
- **Primary Interface Font:** `Inter`, `-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif`.
- **Monospace Font:** `JetBrains Mono`, `Consolas, monospace` (for file hashes, pre-signed tokens, criteria codes like `AREA-01-P-A.1`, and raw OCR text).

### 3.2 Type Hierarchy

| Hierarchy Level | Tailwind Classes | Size / Weight | Usage |
| :--- | :--- | :--- | :--- |
| **Page Title** | `text-2xl font-bold tracking-tight text-slate-900` | 24px / 700 | Main view headers (e.g., "BS Computer Science — Area 3"). |
| **Section Header** | `text-lg font-semibold text-slate-900` | 18px / 600 | Card headers, modal titles, table group names. |
| **Sub-section / Item** | `text-sm font-semibold text-slate-800` | 14px / 600 | Parameter names, form section titles. |
| **Body Regular** | `text-sm font-normal text-slate-700` | 14px / 400 | Standard table cells, descriptions, form labels. |
| **Body Small / Meta** | `text-xs font-normal text-slate-500` | 12px / 400 | Timestamps, file size indicators, helper text. |
| **Code / Identifier** | `font-mono text-xs font-medium text-slate-800` | 12px / 500 | AACCUP code tags, file hashes, criteria numbers. |

*Tabular Numerals:* Tables displaying criteria scores, counts, and dates must use the CSS utility `tabular-nums` so numbers align cleanly in columns.

---

## 4. Layout Architecture & Navigation Shell

Every authenticated page in IQArchive runs inside a persistent **AppShell**:

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│ Topbar (64px height)                                                            │
│ [BU Logo · IQArchive] | [College Context Switcher] | [Notifications] [User Profile] │
├──────────────┬──────────────────────────────────────────────────────────────────┤
│ Sidebar      │ Main Content Canvas (Scrollable, min-width: 764px)               │
│ (260px wide) │                                                                  │
│              │ Breadcrumbs: Home / College of Science / BSCS / Area 1 / File    │
│ • Dashboard  │ Page Title & Primary Actions [Upload Evidence] [Export SSR]      │
│ • Documents  │ ┌──────────────────────────────────────────────────────────────┐ │
│ • Accreditation   │ │ Content Card / Workspace Area                                │ │
│ • Monitoring │ │                                                              │ │
│ • Settings   │ └──────────────────────────────────────────────────────────────┘ │
└──────────────┴──────────────────────────────────────────────────────────────────┘
```

### 4.1 Shell Components
1. **Topbar (64px fixed height):**
   - Left: University seal, system wordmark, and active academic year badge (`AY 2025-2026`).
   - Center: Current college scope badge (e.g., `College of Science` locked for Deans; switchable dropdown for IQA Staff).
   - Right: Notification bell (stage transition & review alerts), user avatar, and active role pill. (See [v2/docs/rbac/roles.md](file:///c:/Users/janss/Herd/iqarchive/v2/docs/rbac/roles.md) for role definitions and permissions).
2. **Sidebar (260px width, collapsible to 72px):**
   - Role-scoped navigation links.
   - Active state marked with `bg-orange-50 text-orange-600 border-r-2 border-orange-500 font-medium`.
   - Subtle badge counts for pending approvals (for example, "4 pending dean reviews").
3. **Breadcrumbs:**
   - Always visible below the topbar for nested navigation: `College > Program > Accreditation Cycle > Area > Document`.

---

## 5. Iconography & UI Component Primitives

### 5.1 Icon Library
- **Lucide Icons (`lucide-vue-next`):**
  - Standard size: `w-4 h-4` (16px) for inline table buttons and status badges; `w-5 h-5` (20px) for sidebar navigation.
  - Stroke width: Uniform `1.75px` or `2px` across all icons.

### 5.2 Component Primitives (Vue 3 + Tailwind CSS v4)
These primitives are available for all features to build on. Feature-specific workflows may combine multiple primitives (for example, the OCR interface combines a split-pane layout, form inputs, and status badges).

- **Buttons:**
  - `BtnPrimary`: `bg-orange-600 hover:bg-orange-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-colors`
  - `BtnSecondary`: `bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 font-medium px-4 py-2 rounded-lg shadow-sm transition-colors`
  - `BtnDestructive`: `bg-rose-600 hover:bg-rose-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition-colors`
- **Status Pills:**
  - `Badge`: `inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium`
- **File Upload Dropzone:**
  - Dashed border (`border-2 border-dashed border-slate-300 hover:border-orange-500 rounded-xl p-8 text-center transition-colors cursor-pointer bg-slate-50/50`).
  - Clear file constraint notice: `PDF only · Max 25MB per file`.
- **Data Tables:**
  - Sticky header row (`sticky top-0 bg-slate-100 z-10`) so users always see column titles when scrolling long lists of evidence.
  - Zebra striping (`odd:bg-white even:bg-slate-50/50`) so wide rows with multiple columns are easy to read horizontally.

---

## 6. How Features Leverage This Design System

Features (such as OCR validation, document evidence upload, and criteria tree navigation) combine the tokens, typography, components, and layout patterns defined in this system. Feature-specific UI/UX is documented in dedicated feature specs (for example, `tasks/ocr-validation.tasks` or `tasks/document-evidence.tasks`).

See Section 7 below for the structure of feature specifications.

---

## 7. Feature-Specific UI/UX Specification Template

When designing UI for a new feature, create a dedicated `tasks/(feature-name)-ui.md` file that describes how the feature uses the design system.

### Template

```markdown
### Feature: [Name]
- **Goal:** Brief description of the feature and user flow.
- **Roles involved:** Which of the 7 roles interact with this feature?

### Key Screens & Workflows
1. **Screen Name:** Brief description
   - Uses components: [Button, Modal, Split Pane, Dropzone, etc.]
   - Uses tokens: [Color palette, typography, spacing]
   - Key interactions: [User actions and outcomes]
   - Special considerations: [Edge cases, validation, errors]

2. **Screen Name:** ...

### Deviations from Design System
(If this feature requires new components or tokens, justify and document them here)

### Wireframe / Design Reference
[Links to Figma, sketches, or ASCII mockups]
```

### Example
**Feature: OCR Document Validation**
- **Split-screen layout:** PDF viewer on the left pane, editable form fields on the right pane.
- **Status badges:** Confidence score pills (Green >= 90%, Yellow 70–89%, Red < 70%).
- **Action buttons:** `[Confirm & Save]`, `[Edit Fields]`, `[Reject Scan]`.
- **Form validation:** Required fields, format checks, and manual corrections highlighted in yellow.
