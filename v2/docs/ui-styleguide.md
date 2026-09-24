# Institutional UI Styleguide & DaisyUI Standards

**Project:** IQArchive v2  
**Target Viewport:** Desktop-Only ($\ge 1024\text{px}$)  
**Author:** Cay02  

---

## 1. Institutional Color Palette

| Token Name | Hex Code | Purpose |
| :--- | :--- | :--- |
| **BU Orange** | `#F26522` | Institutional primary brand accent, primary CTA buttons |
| **BU Blue** | `#0038A8` | University header background, institutional badge accent |
| **Navy Dark** | `#0B192C` | Application sidebar background, high-contrast headings |
| **Slate Base**| `#F8FAFC` | Main content canvas background |
| **Card Surface**| `#FFFFFF` | Information cards and elevated panels |

---

## 2. DaisyUI Component Standard

All interactive elements must use standard DaisyUI component classes:

* **Buttons:** `btn btn-primary`, `btn-outline`, `btn-ghost`, `btn-sm`
* **Cards:** `card card-border bg-base-100 shadow-sm`
* **Badges:** `badge badge-soft`, `badge-success` (approved), `badge-warning` (pending)
* **Alerts:** `alert alert-info alert-soft text-xs shadow-2xs`
* **Tables:** `table table-zebra table-pin-rows`

---

## 3. Desktop-Only Viewport Guard

IQArchive is designed specifically for desktop workstations used by university quality assurance evaluators. Screens $< 1024\text{px}$ trigger the `<MobileUnsupported />` backdrop guard explaining that accreditation review requires a desktop viewport.
