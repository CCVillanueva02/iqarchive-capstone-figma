
### 1. Color Token Mapping (`resources/css/app.css`)

Use these pre-defined utility classes for backgrounds, text colors, borders, rings, and hover states:

| Role / Intent | Tailwind Utility Class | CSS Variable Reference | Raw Hex Equivalent |
| :--- | :--- | :--- | :--- |
| **Primary Navy** | `bg-primary`, `text-primary`, `border-primary` | `var(--color-primary)` | `#1b355a` |
| **Primary Hover** | `bg-primary-hover`, `hover:bg-primary-hover` | `var(--color-primary-hover)` | `#004085` |
| **Primary Dark** (Header / Sidebar) | `bg-primary-dark`, `text-primary-dark` | `var(--color-primary-dark)` | `#002b61` |
| **Primary Dark Hover** | `hover:bg-primary-dark-hover` | `var(--color-primary-dark-hover)` | `#112239` |
| **Primary Light** | `bg-primary-light`, `text-primary-light` | `var(--color-primary-light)` | `#0056b3` |
| **Primary Muted Text** | `text-primary-muted` | `var(--color-primary-muted)` | `#586a85` |
| **Brand Accent Orange** | `bg-brand-orange`, `text-brand-orange`, `focus:ring-brand-orange` | `var(--color-brand-orange)` | `#f47920` |
| **Brand Orange Hover** | `hover:bg-brand-orange-hover` | `var(--color-brand-orange-hover)` | `#d65f1a` |
| **Subtle App Background** | `bg-surface-subtle` | `var(--color-surface-subtle)` | `#f4f6fa` |
| **Card / Select Background** | `bg-surface-card` | `var(--color-surface-card)` | `#f8fafc` |

*For custom scrollbars:*
| Role / Intent | CSS Variable Reference | Raw Hex Equivalent |
| :--- | :--- | :--- |
| **Scrollbar Thumb** | `var(--color-scrollbar-thumb)` | `#c4c9d4` |
| **Scrollbar Thumb Hover** | `var(--color-scrollbar-thumb-hover)` | `#9ca3af` |

*For standard status badges and informational callouts:*
- **Verified**: `bg-green-100 text-green-700 border-green-200`
- **Pending**: `bg-amber-100 text-amber-800 border-amber-200`
- **Rejected**: `bg-rose-100 text-rose-700 border-rose-200`

> **Rule — Status & Feedback UI Exemptions:**
> Status/feedback UI (badges, inline info or warning callouts) uses native Tailwind semantic colors directly and is exempt from brand-token mapping. Brand tokens are reserved for interactive/navigational UI.

---

### 2. Typography Token Scale (`resources/css/app.css`)

Use these utility classes for all font sizing across UI elements:

| Typography Role | Utility Class | Rem Value | Pixel Equivalent | Typical Usage |
| :--- | :--- | :--- | :--- | :--- |
| **Micro Label** | `text-label-xs` | `0.625rem` | `10px` | Active badges, tiny inline tags |
| **Small Label** | `text-label` | `0.75rem` | `12px` | Table headers, category uppercase tags |
| **Body Small** | `text-body-sm` | `0.875rem` | `14px` | Form inputs, secondary buttons, helper text |
| **Body Standard** | `text-body` | `1rem` | `16px` | Main body copy, navigation links, primary inputs |
| **Heading Small** | `text-heading-sm` | `1.125rem` | `18px` | Section headers, card titles |
| **Heading Standard**| `text-heading` | `1.5rem` | `24px` | Subheadings, modal titles, brand titles |
| **Heading Large** | `text-heading-lg` | `2rem` | `32px` | Page titles, main dashboard headers |
| **Hero Title** | `text-hero` | `3rem` | `48px` | Landing page main hero titles |

---