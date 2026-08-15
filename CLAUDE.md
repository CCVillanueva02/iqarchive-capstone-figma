# AI Instructions for IQArchive

- Always use the centralized design tokens defined in `resources/css/app.css` (`@theme` block).
- Never hardcode raw hex colors (e.g. `#1b355a`, `#002B61`, `#f27224`, `#F47920`, `#f4f6fa`, `#f8fafc`). Use `bg-primary`, `bg-primary-dark`, `bg-brand-orange`, `bg-surface-subtle`, `bg-surface-card`, etc.
- Never hardcode arbitrary font sizes (e.g. `text-[10px]`, `text-[11px]`, `text-[13px]`, `text-[20px]`). Use `text-label-xs`, `text-label`, `text-body-sm`, `text-body`, `text-heading-sm`, `text-heading`, `text-heading-lg`, `text-hero`.
- Run `cmd /c npm run build` to compile assets after updating CSS or Blade files.
