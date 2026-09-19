<!--
================================================================================
IQArchive v2 — Developer Setup & Onboarding Guide
================================================================================
File: v2/README.md
Purpose: Comprehensive onboarding, local environment setup, and architectural
         orientation for developers working on IQArchive v2.
Target Platform: Desktop-Only (>= 1024px) | Laravel 13 + Inertia.js + Vue 3
Security: Multi-tenant college_id isolation, 7-role RBAC, private S3 storage.
Associated Docs:
  - Architecture Essentials: v2/docs/ARCHITECTURE-ESSENTIALS.md
  - Design System: v2/docs/design-system.md
  - Project Rules: .agents/rules/general-rules.md
  - Engineering Backlog: v2/TODOS.md
================================================================================
-->

# IQArchive v2 — Developer Guide

**IQArchive** is a document management and compliance monitoring system built for Bicol University to streamline accreditation surveys conducted by the Accrediting Agency of Chartered Colleges and Universities in the Philippines (AACCUP).

---

## 1. Technology Stack

- **Backend:** Laravel 13 (PHP 8.4+)
- **Frontend:** Inertia.js + Vue 3 (Composition API `<script setup>`)
- **Styling:** Tailwind CSS v4 (`@tailwindcss/vite`)
- **Icons & Typography:** Lucide Icons (`lucide-vue-next`) & Inter font
- **Database:** MySQL 8 in strict 3rd Normal Form (3NF)
- **Object Storage:** Private S3-compatible cloud bucket with 15-minute temporary signed URLs
- **Authentication:** Google Workspace OAuth 2.0 (restricted to `@bicol-u.edu.ph` accounts)
- **OCR Engine:** Tesseract OCR with human-in-the-loop verification

---

## 2. Workstation Prerequisites

Before running the project locally, ensure you have the following installed on your machine:

| Requirement | Minimum Version | Verified Local Version |
| :--- | :--- | :--- |
| **PHP** | `^8.3` (PHP 8.4 recommended) | `8.4.5` (CLI) |
| **Composer** | `^2.7` | `2.9.7` |
| **Node.js** | `^20.0` (LTS or current) | `v24.15.0` |
| **NPM** | `^10.0` | `11.12.1` |
| **MySQL Server** | `^8.0` | `8.0.46` |
| **Laravel Herd** | Recommended for Windows/macOS | Installed |

PHP extensions required: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `gd`, `curl`.

---

## 3. Local Environment Setup

Follow these steps to set up the development environment from scratch:

### Step 1: Clone and Navigate
Ensure you are on the `v2-main` branch, then move into the application directory:
```bash
git checkout v2-main
cd v2/src
```

### Step 2: Install PHP Dependencies
```bash
composer install
```

### Step 3: Configure Environment Variables
Copy the example environment file:
```bash
copy .env.example .env
```
Generate the application key:
```bash
php artisan key:generate
```

### Step 4: Configure the Database
1. Open your MySQL client and create the database:
   ```sql
   CREATE DATABASE iqarchive_v2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. Update your `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=iqarchive_v2
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

### Step 5: Install and Build Frontend Dependencies
```bash
npm install
npm run build
```

---

## 4. Running the Development Servers

You need both the backend PHP server and Vite hot module reloading running concurrently:

### Option A: Using PHP Artisan Serve
1. Start the backend server:
   ```bash
   php artisan serve
   ```
2. In a second terminal window, start Vite:
   ```bash
   npm run dev
   ```
3. Access the site at `http://localhost:8000`.

---

## 5. Repository Structure

```
iqarchive/
├── .agents/                 # Project guidelines, persona rules, and workflow engines
├── v2/
│   ├── docs/                # Specifications & architecture docs
│   │   ├── ARCHITECTURE.md           # Master architecture spec
│   │   ├── ARCHITECTURE-ESSENTIALS.md# Plain-language developer architecture guide
│   │   ├── design-system.md          # Visual tokens, layout standards, UI components
│   │   ├── PRD.md                    # Product requirements document
│   │   ├── MODULES.md                # Subsystem specifications (MOD-01 to MOD-07)
│   │   └── db-design/                # 22-table relational schema & ERD diagrams
│   ├── tasks/               # Task plans and progress tracking
│   │   ├── project-todo.tasks        # Master project task checklist
│   │   └── project-initialization.tasks# Initialization implementation log
│   ├── TODOS.md             # Prioritized engineering backlog (P0 / P1 / P2)
│   ├── README.md            # This developer onboarding file
│   └── src/                 # Application codebase (Laravel 13 + Inertia.js + Vue 3)
│       ├── app/             # Controllers, Models, Services, Policies
│       ├── config/          # Framework and package configurations
│       ├── database/        # Migrations, seeders, factories
│       ├── resources/       # Vue 3 pages, components, layouts, CSS
│       ├── routes/          # Web and auth route definitions
│       └── tests/           # Pest and PHPUnit automated test suites
```
