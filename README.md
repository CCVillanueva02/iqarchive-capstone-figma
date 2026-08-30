# IQArchive — Quality Assurance & Accreditation Management Portal

IQArchive is a centralized web portal designed for Institutional Quality Assurance Offices and Accreditation Task Forces. It streamlines document archival, AACCUP accreditation instruments, area-based criteria workflows, and compliance tracking.

---

## 📋 Prerequisites

Ensure your development environment meets the following requirements before getting started:

*   **PHP:** Version `^8.3` (with extensions: `pdo_sqlite`, `pdo_mysql`, `openssl`, `mbstring`, `curl`, `fileinfo`, `xml`)
*   **Composer:** Version `2.x`
*   **Node.js & NPM:** Node.js `^18.x` or `^20.x` & NPM `^9.x` or higher
*   **Database:** SQLite (default for local development) or MySQL / MariaDB (version `8.0+` / `10.4+`)

---

## 🛠️ Step-by-Step Environment Setup

### 1. Clone the Repository
Clone the repository to your local machine and enter the project directory:
```bash
git clone <repository-url>
cd iqarchive
```

### 2. Configure Environment Variables
Copy the template `.env.example` file to create your local `.env` configuration:

*   **Linux / macOS / Git Bash:**
    ```bash
    cp .env.example .env
    ```
*   **Windows (PowerShell):**
    ```powershell
    Copy-Item .env.example .env
    ```

#### Key Environment Variables:
Open `.env` and verify/adjust the following settings according to your environment:

*   **Application Settings:**
    ```dotenv
    APP_NAME="IQArchive"
    APP_ENV=local
    APP_KEY=
    APP_DEBUG=true
    APP_URL=http://localhost:8000
    ```
*   **Database Settings (SQLite - Default):**
    ```dotenv
    DB_CONNECTION=sqlite
    # DB_DATABASE=/absolute/path/to/database.sqlite (or leave blank if using default database/database.sqlite)
    ```
*   **Database Settings (MySQL - Alternative):**
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=iqarchive
    DB_USERNAME=root
    DB_PASSWORD=
    ```
*   **Authentication & Domain Restrictions (Optional):**
    ```dotenv
    GOOGLE_CLIENT_ID="your-google-client-id.apps.googleusercontent.com"
    GOOGLE_CLIENT_SECRET="your-google-client-secret"
    GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
    ALLOWED_EMAIL_DOMAINS="example.edu"
    ```

### 3. Install Dependencies
Install PHP dependencies via Composer and frontend packages via NPM:

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 4. Generate Application Encryption Key
Generate a unique application encryption key:
```bash
php artisan key:generate
```

### 5. Initialize the Database

#### If using SQLite (Default):
Create the SQLite database file:
*   **Linux / macOS:**
    ```bash
    touch database/database.sqlite
    ```
*   **Windows (PowerShell):**
    ```powershell
    New-Item -ItemType File -Path database/database.sqlite -Force
    ```

#### If using MySQL / MariaDB:
Create a new database matching your `.env` configuration (e.g., `CREATE DATABASE iqarchive;`).

### 6. Run Migrations & Seeders
Execute database migrations and populate the database with default roles, categories, master instruments, and test accounts:

```bash
php artisan migrate:fresh --seed
```

### 7. Create Public Storage Symlink
Link the public storage directory to enable uploaded document access and previews:

```bash
php artisan storage:link
```

---

## 🚀 Running the Application Locally

### Option A: All-in-One Development Command (Recommended)
Run the web server, background queue worker, and Vite asset bundler concurrently in a single terminal:

```bash
composer run dev
```

### Option B: Separate Terminal Processes
If you prefer running individual processes in dedicated terminal windows:

1.  **Laravel HTTP Server:**
    ```bash
    php artisan serve
    ```
    Access the application at [http://127.0.0.1:8000](http://127.0.0.1:8000).

2.  **Vite Asset Compiler (HMR):**
    ```bash
    npm run dev
    ```

3.  **Background Queue Worker:**
    ```bash
    php artisan queue:listen --tries=1
    ```

---

## 🧪 Testing & Code Quality

Run tests and code quality tooling with the following commands:

*   **Run Test Suite:**
    ```bash
    php artisan test
    # or via Composer script:
    composer run test
    ```
*   **Format Code (Laravel Pint):**
    ```bash
    composer run lint
    ```
*   **Static Type Analysis (PHPStan / Larastan):**
    ```bash
    composer run types:check
    ```
*   **Build Assets for Production:**
    ```bash
    npm run build
    ```

---

## 🔑 Default Seeded Testing Accounts

When the database is seeded (`php artisan migrate:fresh --seed`), the following test accounts are available.

> **Default Password:** `password` (for all seeded test accounts)

| Role | Email | Description |
| :--- | :--- | :--- |
| **System Administrator** | `sysadmin@example.com` | Full system configuration, audit logs, user management |
| **IQA Staff / Member** | `iqastaff@example.com` | IQA office administration, document reviews, area management |
| **AACCUP Accreditor** | `accreditor@example.com` | External accreditation evaluation and instrument scoring |
| **University Administrator** | `buadmin@example.com` | Executive oversight and institution-wide compliance monitoring |
| **College Head / Dean** | `dean@example.com` | College-level document submissions and accreditation progress |
| **Task Force Member** | `taskforcemember@example.com` | Program-level evidence collection and document uploads |

---

## 🔒 Security & Best Practices

*   Ensure `.env` is never committed to version control.
*   In production, set `APP_ENV=production` and `APP_DEBUG=false`.
*   Keep `APP_KEY` secure and ensure files uploaded to private disks are accessed exclusively through authorization gates.

