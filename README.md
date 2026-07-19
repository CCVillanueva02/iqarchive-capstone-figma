# IQArchive — Internal Quality Assurance Office Portal

This repository contains the IQArchive portal for Bicol University's Internal Quality Assurance Office. Follow the instructions below to set up and run this project on a new local machine.

---

## 📋 Prerequisites

Ensure your system meets the following requirements:

*   **PHP:** Version `8.2` or higher (with required extensions: `pdo_sqlite`, `openssl`, `mbstring`, etc.)
*   **Composer:** For managing PHP dependencies
*   **Node.js & NPM:** For compiling frontend assets
*   **Database:** SQLite is used by default (simplest for local development)

---

## 🛠️ Step-by-Step Installation

### 1. Clone the Repository
Clone this repository to your local machine:
```bash
git clone <repository-url>
cd iqarchive
```

### 2. Configure Environment variables
Copy the template `.env.example` file to create your environment configuration:
```bash
cp .env.example .env
```
*(On Windows PowerShell, use: `copy .env.example .env`)*

### 3. Install Dependencies
Run Composer to install backend dependencies:
```bash
composer install
```

Run NPM to install frontend dependencies:
```bash
npm install
```

### 4. Generate Application Key
Generate a secure encryption key for the Laravel application:
```bash
php artisan key:generate
```

### 5. Setup the Database
By default, the project is configured to use a local **SQLite** database. 

Create the database file:
*   **Linux/macOS:**
    ```bash
    touch database/database.sqlite
    ```
*   **Windows (PowerShell):**
    ```powershell
    New-Item -ItemType File -Path database/database.sqlite
    ```

### 6. Run Migrations & Seeders
Create the database tables and populate them with standard testing accounts:
```bash
php artisan migrate:fresh --seed
```

### 7. Link Public Storage
Link the storage directory to allow local file uploads to be accessible via the web:
```bash
php artisan storage:link
```

---

## 🚀 Running the Application Locally

You will need to run two processes simultaneously (in separate terminal windows or in the background):

1.  **Start the Laravel Server:**
    ```bash
    php artisan serve
    ```
    This launches the app at [http://127.0.0.1:8000](http://127.0.0.1:8000) (or a custom port specified in your console).

2.  **Start the Vite Assets Compiler:**
    ```bash
    npm run dev
    ```
    This compiles and dynamically reloads CSS, Blade-compiled views, and JavaScript assets.

---

## 🔑 Default Seeded Accounts

For local testing, the database seeder creates several roles. **Password for all seeded accounts is: `password`**

| Role | Email |
| :--- | :--- |
| **System Administrator** | `sysadmin@example.com` |
| **IQA Admin** | `iqaadmin@example.com` |
| **IQA Staff Member** | `iqamember@example.com` |
| **AACCUP Accreditor** | `accreditor@example.com` |
| **BU Executive Admin** | `buadmin@example.com` |
| **QA Task Force Lead** | `taskforce@example.com` |
