# IQArchive Design System & Token Specification

**Authority:** Source of truth for all UI design, tokens, typography, colors, and layout components across IQArchive.

---

## 1. Brand Identity & Aesthetic Direction

- **Product:** IQArchive (Bicol University AACCUP Accreditation & Evidence Repository)
- **Design Philosophy:** Executive, calm authority, institutional dignity, clean contrast.
- **Tone:** Academic precision, zero visual clutter, desktop-first productivity (≥1024px).
- **Core Principle:** Always use DaisyUI component primitives (`btn`, `card`, `modal`, `badge`, `table`, `input`) powered by semantic design tokens defined in `resources/css/app.css`.

---

## 2. Color Palette & Token Reference

### A. Sidebar Blue / Deep Navy Palette (Primary System UI Tone)
*Directly matched to the persistent navigation sidebar background (`#0B1B3D`).*

| Token Name | Hex Code | Primary Applications |
| :--- | :--- | :--- |
| `--color-sidebar-blue` | `#0B1B3D` | Navigation sidebar background, primary workstation action buttons ("Upload Document", "Save Office"), dark table header bars, and high-emphasis brand containers. |
| `--color-sidebar-blue-hover` | `#15264A` | Hover state for sidebar-blue buttons, active row selections, and interactive surface elevations. |
| `--color-sidebar-blue-surface` | `#0E214A` | Sub-panels within dark sidebar areas, floating flyout popovers, floating expand toggles, and card active states. |
| `--color-sidebar-blue-dark` | `#081530` | Deepest navy containers, university wordmark bar in sidebar header, and high-contrast terminal/footer strips. |

### B. Institutional Bicol University Blue Palette (`#0038A8`)
*Official university color signifying institutional credibility and academic governance.*

| Token Name | Hex Code | Primary Applications |
| :--- | :--- | :--- |
| `--color-bu-blue-50` | `#EFF6FF` | Subtle tinted card backgrounds, active sidebar item backgrounds, info callout banners, and soft table row highlights. |
| `--color-bu-blue-100` | `#DBEAFE` | Light borders for selected office cards, active tab indicator lines, and secondary badge backgrounds. |
| `--color-bu-blue-200` | `#BFDBFE` | Focused form input borders, active checkbox outlines, and modal separator dividers. |
| `--color-bu-blue-300` | `#93C5FD` | Interactive hover rings, secondary tag badges, and subtle progress bars. |
| `--color-bu-blue-500` | `#1D4ED8` | Hyperlinks in content bodies, secondary interactive links, and breadcrumb navigation steps. |
| `--color-bu-blue-600` | `#1E40AF` | Hover states for text links, icons within info cards, and mid-tier blue buttons. |
| `--color-bu-blue-700` | `#0038A8` | Official Bicol University Seal blue, institutional branding badges, secondary headers, and authoritative verification marks. |
| `--color-bu-blue-800` | `#002D8A` | Active text within blue-tinted items (e.g. selected office title), pressed link states, and prominent status pills. |
| `--color-bu-blue-900` | `#002878` | Dark contrast text on light blue backgrounds and high-authority heading accents. |

### C. Institutional Bicol University Orange Palette (`#F26522`)
*Official university accent color signifying energy, high-priority actions, and status emphasis.*

| Token Name | Hex Code | Primary Applications |
| :--- | :--- | :--- |
| `--color-bu-orange-50` | `#FFF7ED` | Warm alert banners, subtle warning backgrounds, soft active state cards, and pending notification highlights. |
| `--color-bu-orange-100` | `#FFEDD5` | Warning badge soft fills, draft document status pills, and attention-grabbing badge borders. |
| `--color-bu-orange-200` | `#FED7AA` | Subtle warm borders for pending submissions and attention callouts. |
| `--color-bu-orange-500` | `#F26522` | Official Bicol University Orange, vital call-to-action highlights, active navigation rail indicators, upload indicators, and key metric card accents. |
| `--color-bu-orange-600` | `#D95316` | Hover states on orange action buttons and primary alert icons. |
| `--color-bu-orange-700` | `#C2410C` | Dark orange text on warm light backgrounds, overdue alert copy, and emphasized warnings. |

### D. Neutral Slate Palette (Layout Grids, Content, and Hierarchy)

| Token Name | Hex Code | Primary Applications |
| :--- | :--- | :--- |
| `--color-slate-50` | `#F8FAFC` | Workspace background canvas (`bg-base-200`), table header fills, and zebra striping. |
| `--color-slate-100` | `#F1F5F9` | Inner section dividers, card borders, and subtle field backdrops. |
| `--color-slate-200` | `#E2E8F0` | Standard card borders (`card-border`), table cell divider borders, and modal footers. |
| `--color-slate-300` | `#CBD5E1` | Inactive borders, placeholder icons, empty-state illustrations, and disabled element outlines. |
| `--color-slate-400` | `#94A3B8` | Input placeholder text, decorative icons, file metadata subtitles, and pagination controls. |
| `--color-slate-500` | `#64748B` | Secondary body text, table column headers (`th`), date stamps, and helper hints. |
| `--color-slate-600` | `#475569` | Uploader names, table cell content, secondary modal labels, and breadcrumb links. |
| `--color-slate-700` | `#334155` | Fieldset legends, form input labels, dropdown menu options, and active tab labels. |
| `--color-slate-800` | `#1E293B` | Section titles, card titles (`card-title`), modal dialog headings, and directory panel headers. |
| `--color-slate-900` | `#0F172A` | Primary page title (`h1`), high-contrast body text, and dark theme neutral base. |

### E. Semantic Status Color Tokens

| Status Name | Token | Hex | Applications |
| :--- | :--- | :--- | :--- |
| **Success** | `--color-status-success` | `#16A34A` | "IQA Approved" badges, upload success confirmations, and valid OCR validation marks. |
| **Warning** | `--color-status-warning` | `#D97706` | "Draft" document pills, pending review states, and impending deadline reminders. |
| **Error** | `--color-status-error` | `#DC2626` | "Rejected" document badges, form validation errors, deficit indicators, and destructive actions. |
| **Info** | `--color-status-info` | `#0284C7` | "Dean Approved" badges, informative system banners, and instructional tooltips. |

---

## 3. Typography Scale & Application Guide

Font Stack:
- **Primary Interface:** `'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif`
- **Technical & Tabular:** `'JetBrains Mono', ui-monospace, Menlo, Monaco, Consolas, monospace`

| Scale Token | Size | Line Height | Applications |
| :--- | :--- | :--- | :--- |
| `--text-display` | `2rem` (32px) | `2.25rem` | Major portal titles, hero accreditation statistics, and major scorecard numerals. |
| `--text-heading-xl` | `1.5rem` (24px) | `1.875rem` | Top-level page titles (`h1`, e.g. "Common Documents", "IQA Staff Dashboard"). |
| `--text-heading-lg` | `1.25rem` (20px) | `1.625rem` | Modal dialog titles, primary section headers, and major dashboard widget headers. |
| `--text-heading-md` | `1rem` (16px) | `1.375rem` | Office titles in document table header, card titles, and criteria section headings. |
| `--text-heading-sm` | `0.875rem` (14px) | `1.25rem` | Panel titles (e.g. "OFFICES"), sub-card headings, and form section group legends. |
| `--text-body-md` | `0.875rem` (14px) | `1.375rem` | Default body copy, modal descriptions, standard table text, and form inputs. |
| `--text-body-sm` | `0.8125rem` (13px) | `1.25rem` | Secondary directory listing items, compact table rows, and dropdown menus. |
| `--text-caption` | `0.75rem` (12px) | `1rem` | Office mandate descriptions, input field helper hints, table column headers (`th`), and status badges. |
| `--text-micro` | `0.6875rem` (11px) | `0.875rem` | File size/extension tags, tabular numeric timestamps, and small status pill text. |

---

## 4. Radii & Surface Elevation Standards

| Radius Token | Value | Applications |
| :--- | :--- | :--- |
| `--radius-selector` | `0.375rem` (6px) | Badges (`badge`), status pills, tags, checkboxes (`checkbox`), and toggles (`toggle`). |
| `--radius-field` | `0.5rem` (8px) | Buttons (`btn`), text inputs (`input`), select menus (`select`), and search fields. |
| `--radius-box` | `0.75rem` (12px) | Cards (`card`), modal boxes (`modal-box`), alerts (`alert`), and floating panels. |

---

## 5. Component Usage Standards

1. **Buttons:**
   - **Primary Action:** Use `btn btn-sm bg-sidebar-blue hover:bg-sidebar-blue-hover text-white border-none gap-1.5` or `btn btn-sm btn-primary`.
   - **Secondary / Outline Action:** Use `btn btn-sm btn-outline border-sidebar-blue text-sidebar-blue hover:bg-sidebar-blue hover:border-sidebar-blue hover:text-white gap-1.5`.
   - **Cancel / Close:** Use `btn btn-sm btn-ghost text-slate-600`.
2. **Page Headers:**
   - Place primary page action buttons on the far right of the top page header (`flex items-center justify-between`).
   - Keep subordinate card toolbars focused purely on search and filters.
3. **Office Directory & Documents Table:**
   - Left column: 2/12 or 3/12 width, displaying the office list with active item styled in `bg-bu-blue-50 border-bu-blue-200 text-bu-blue-800`.
   - Right column: 10/12 or 9/12 width, displaying the office name heading with subtitle description, toolbar filters, and tabular document records.
