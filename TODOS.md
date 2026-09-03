# IQArchive Backlog & Action Items

## P0 — Critical UX & Navigation Restoration (Active /autoplan Scope)
- [ ] Remove duplicate in-page pill tabs from `resources/views/livewire/documents/partials/header.blade.php`.
- [ ] Sync `$activeTab` in `DocumentWorkspace.php` directly with sidebar URL query parameter `?tab=...`.
- [ ] Restore single-line page header with dynamic title and wayfinding breadcrumbs (`Documents > [Section] > [Sub-Level]`).
- [ ] Restore Institutional Accreditation 5 color-coded category cards (Self-Survey [amber], Compliance [emerald], Supporting Docs [navy], Narrative [violet], PPP [teal]) with drill-down state and `"← Back to Categories"`.
- [ ] Restore Program Accreditation 17-College card grid with search, college seals, and program count badges (bypassed for scoped College Heads and Task Force Members).
- [ ] Restore Common Documents Office Selection grid $\rightarrow$ Category Folder Cards with document count badges $\rightarrow$ Document table.

## P1 — Design Token Compliance & Styling Polish
- [ ] Eliminate raw unstyled native `<select>` dropdowns and replace with design system tokens and styled triggers.
- [ ] Remove `bg-black` utility from `resources/views/livewire/documents/partials/program/supporting-documents.blade.php` and replace with canonical token `bg-primary`.
- [ ] Ensure smooth hover lifts (`hover:-translate-y-1 hover:shadow-md transition-all duration-300`) on all restored card grids.

## P2 — Accessibility & Edge States
- [ ] Add empty search state illustrations for College and Category card searches.
- [ ] Verify ARIA labels and focus rings on all card action buttons.
- [ ] Run full feature test suite and browser validation across all 4 roles.
