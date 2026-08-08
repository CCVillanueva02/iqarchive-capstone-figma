# IQArchive - Project & Laravel File Structure Documentation

This document provides a detailed breakdown of the file structure for the **IQArchive** project (Institutional Quality Assurance Document Archive System), split into **Backend** and **Frontend** components.

---

## 1. Backend File Structure & Architecture

The backend handles business logic, database ORM models, user authentication (via Laravel Fortify), role-based access control (RBAC), and server-side state for Livewire components.

```
iqarchive/
├── app/
│   ├── Actions/              # Single-action backend logic (e.g. Fortify auth actions, user updates)
│   ├── Concerns/             # Shared PHP traits and reusable backend logic
│   ├── Console/              # Custom Artisan CLI commands & scheduled background jobs
│   ├── Http/                 # HTTP layer (Controllers, Middleware, Requests)
│   ├── Livewire/             # Server-side component classes handling dynamic UI logic & state
│   │   ├── Actions/          # Livewire-specific business actions
│   │   ├── Documents/        # Document management logic, upload handling & filters
│   │   ├── IqaAdmin/         # IQA Administrator dashboard & module logic
│   │   ├── SystemAdministrator/ # System Admin user management & RBAC logic
│   │   └── TaskForce/        # Taskforce-specific views & submission logic
│   ├── Models/               # Eloquent ORM classes representing database tables (User, Document, etc.)
│   └── Providers/            # Service Providers booting application services (AppServiceProvider, FortifyServiceProvider)
├── bootstrap/
│   ├── app.php               # Application initialization, middleware configuration, and routing
│   └── providers.php         # List of loaded service providers
├── config/                   # Configuration files (database.php, auth.php, fortify.php, flux.php, app.php)
├── database/
│   ├── factories/            # Model factories for generating test data
│   ├── migrations/           # Database schema migrations (tables, columns, indexes)
│   ├── seeders/              # Database seeders to populate initial/dummy data
│   └── database.sqlite       # Local SQLite database file (if using SQLite)
├── routes/
│   ├── web.php               # Main web & Livewire application routes
│   ├── settings.php          # User profile & settings routes
│   └── console.php           # CLI & scheduled Artisan commands
├── storage/                  # Generated files, logs, uploaded document archives, and cached views
└── tests/                    # Automated Pest & PHPUnit test suites
```

### Key Backend Highlights
- **`app/Livewire/`**: Acts as the reactive controller layer. Livewire component classes manage state directly and stream updates to Blade templates without full page reloads.
- **`app/Actions/`**: Contains discrete action classes responsible for authentication flows, user creation, and password resets via Laravel Fortify.
- **`app/Models/`**: Eloquent models mapping directly to relational database tables with security scopes and audit hooks.

---

## 2. Frontend File Structure & Architecture

The frontend is built using **Livewire 4 + Flux UI + Blade Templates + Tailwind CSS v4**, bundled via **Vite**.

```
iqarchive/
├── resources/
│   ├── css/
│   │   └── app.css           # Tailwind CSS v4 styles & custom UI design tokens
│   ├── js/
│   │   ├── app.js            # JavaScript entry point (loads Alpine.js / Livewire assets)
│   │   └── bootstrap.js      # Global JS configuration (Axios, plugins)
│   └── views/
│       ├── components/       # Reusable Blade UI components (app-logo, inputs, alerts)
│       ├── flux/             # Flux UI library components & customizable design system views
│       ├── layouts/          # Root layout templates (app.blade.php for auth app, guest.blade.php)
│       ├── livewire/         # Blade view templates linked 1:1 to App\Livewire PHP components
│       │   ├── actions/      # Views for action forms
│       │   ├── documents/    # View templates for document archives & upload forms
│       │   ├── iqa-admin/    # Views for IQA Admin management dashboards
│       │   ├── system-administrator/ # User management & audit log templates
│       │   └── task-force/   # Taskforce submission & review templates
│       ├── pages/            # Standard static or standalone Blade page views
│       ├── partials/         # Header, sidebar, navigation, and footer partial HTML snippets
│       ├── dev-login.blade.php # Developer environment login view
│       └── welcome.blade.php # Landing / splash page template
├── public/                   # Publicly accessible web root directory
│   ├── index.php             # Front controller (entry point for web server requests)
│   ├── favicon.ico           # Site favicon
│   └── storage/              # Symlink pointing to storage/app/public (accessible file uploads)
├── package.json              # Node.js dependencies (@tailwindcss/vite, sweetalert2, vite)
└── vite.config.js            # Vite build setup for compiling CSS/JS assets
```

### Key Frontend Highlights
- **`resources/views/livewire/`**: The reactive templates that dynamically re-render in response to backend state changes.
- **`resources/views/flux/`**: Pre-styled UI primitives (modals, buttons, dropdowns, form fields) from the Flux UI design system.
- **`resources/css/app.css`**: Tailwind v4 styling engine configuration.
- **`vite.config.js`**: Asset bundler configuration driving fast hot-module replacement (HMR) during development.
