---
trigger: always_on
description: UI Component Standard — Use DaisyUI component classes across all views instead of building custom one-off components.
---

# UI Component Standard: Always Use DaisyUI

## Core Rule
**Always use DaisyUI component classes instead of building custom one-off UI components or reinventing CSS utility combinations.**

To ensure complete visual and behavioral consistency across all pages, workspaces, and role interfaces, all UI elements must adhere to DaisyUI component standards.

---

## 1. DaisyUI Component Class Guidelines

### Buttons (`btn`)
- Use `btn` with semantic color modifiers: `btn-primary`, `btn-secondary`, `btn-accent`, `btn-neutral`, `btn-ghost`, `btn-outline`.
- Use size modifiers: `btn-xs`, `btn-sm`, `btn-md`, `btn-lg`.
- For loading states: use `loading loading-spinner loading-xs` inside the button or `btn-disabled`.
- **Do NOT** handcraft custom button padding, borders, and rounded corners with ad-hoc Tailwind classes (`px-4 py-2 bg-blue-600 rounded-lg hover:bg-blue-700...`). Use DaisyUI `btn`.

### Cards (`card`)
- Use `card`, `card-body`, `card-title`, and `card-actions` for all panels, containers, and information cards.
- Add elevation or borders with `card-border`, `bg-base-100`, or `shadow-sm` / `shadow-md`.
- **Do NOT** build custom wrapper divs with manual padding and border hierarchies when a `card` represents the content.

### Badges & Status Indicators (`badge`)
- Use `badge` with semantic variants: `badge-primary`, `badge-secondary`, `badge-success`, `badge-warning`, `badge-error`, `badge-info`.
- Use `badge-outline` or `badge-soft` for lighter status pills (e.g. document statuses: Draft, Endorsed, Approved, Deficit).

### Modals & Dialogs (`modal`)
- Use DaisyUI `modal`, `modal-box`, and `modal-action`.
- For backdrop clicks and close buttons, follow standard DaisyUI modal structure or `modal-open`.

### Form Controls
- Text inputs: `input input-bordered w-full`.
- Selects: `select select-bordered w-full`.
- Checkboxes & Toggles: `checkbox checkbox-primary`, `toggle toggle-primary`.
- Textareas: `textarea textarea-bordered w-full`.
- Fieldsets and labels: Use `fieldset`, `fieldset-legend`, and `label`.

### Alerts & Notifications (`alert`)
- Use `alert`, `alert-info`, `alert-success`, `alert-warning`, `alert-error` for banner notifications, flash messages, and validation feedback.

### Tables (`table`)
- Use `table`, `table-zebra`, and `table-pin-rows` for criteria matrices, document logs, and user management tables.

### Navigation, Tabs, & Breadcrumbs
- Tabs: `tabs tabs-lift`, `tabs tabs-border`, with `tab tab-active`.
- Breadcrumbs: `breadcrumbs` list items.
- Dropdowns: `dropdown`, `dropdown-content`, `menu`.

---

## 2. When Custom Code is Permitted
- **Layout Grids & Alignment:** Standard Tailwind flex/grid layout utilities (`flex`, `grid`, `gap-4`, `items-center`) are expected for page scaffolding.
- **Specific University Branding:** If a specific institutional color (e.g. BU Orange `#F26522` or BU Blue `#0038A8`) is required on an element, apply it on top of the DaisyUI component (e.g., `btn bg-bu-orange-500 hover:bg-bu-orange-600 text-white`).
