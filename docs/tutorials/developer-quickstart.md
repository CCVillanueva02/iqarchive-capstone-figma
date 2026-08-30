# Tutorial: Developer Environment Quickstart

This tutorial walks a new engineer through setting up a complete local development environment for IQArchive in under 5 minutes.

---

## 1. Prerequisites

Ensure you have the following installed on your machine:
- **PHP 8.2+** with `pdo`, `mbstring`, `openssl`, `curl` extensions.
- **Composer** (PHP dependency manager).
- **Node.js 18+** & **npm**.
- **Laravel Herd** (recommended on macOS/Windows) or standard PHP CLI.

---

## 2. Step-by-Step Setup

### Step 1: Clone Repository & Install Dependencies
```bash
# Clone the repository
git clone <repository-url> iqarchive
cd iqarchive

# Install backend dependencies
composer install

# Install frontend dependencies
npm install
```

### Step 2: Configure Environment
```bash
# Copy example environment file
cp .env.example .env

# Generate application encryption key
php artisan key:generate
```

### Step 3: Run Migrations & Seeders
Populate the database with all 35 tables, 17 BU colleges, degree programs, AACCUP instruments, and default test accounts:

```bash
php artisan migrate:fresh --seed
```

### Step 4: Build Frontend Assets
Compile Tailwind CSS v4 design tokens and Flux UI component assets:

```bash
npm run build
```

### Step 5: Start the Development Server
If using standard CLI:
```bash
php artisan serve
```
Or open your browser to `http://iqarchive.test` if using Laravel Herd.

---

## 3. Verifying Your Setup (First Login)

IQArchive includes standard seeded test accounts (password is `password` for all seeded accounts):

| Role | Email | Password | Target Dashboard |
| :--- | :--- | :--- | :--- |
| **System Admin** | `sysadmin@example.com` | `password` | `/dashboard/system-administrator` |
| **IQA Staff** | `iqastaff@example.com` | `password` | `/dashboard/iqa-staff` |
| **College Dean** | `dean@example.com` | `password` | `/dashboard/college-head` |
| **Task Force** | `taskforcemember@example.com`| `password` | `/dashboard/task-force` |
| **Accreditor** | `accreditor@example.com` | `password` | `/submissions/accreditor` |

---

## 4. Cross-Quadrant Links

- **Architecture Overview:** [System Architecture Reference](file:///c:/Users/janss/Herd/iqarchive/docs/reference/architecture-overview.md)
- **Database Schema & ERD:** [Database ERD Reference](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-erd.md)
- **Onboarding Guide:** [User Onboarding How-To](file:///c:/Users/janss/Herd/iqarchive/docs/how-to/user-onboarding-flow.md)
