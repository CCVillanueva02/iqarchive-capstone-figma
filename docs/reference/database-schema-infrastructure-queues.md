# Database Schema: Framework & Queue Infrastructure

This reference document details the schema for Laravel cache, atomic locks, queued asynchronous jobs, and failure diagnostics.

---

## 1. Tables Overview

| Table | Driver Subsystem | Migration Source | Purpose |
| :--- | :--- | :--- | :--- |
| `cache` | Laravel Cache | `0001_01_01_000001_create_cache_table.php` | Key-value application cache storage. |
| `cache_locks` | Laravel Cache Locks | `0001_01_01_000001_create_cache_table.php` | Distributed atomic locks. |
| `jobs` | Laravel Queue | `0001_01_01_000002_create_jobs_table.php` | Asynchronous queued worker jobs. |
| `job_batches` | Laravel Bus Batching | `0001_01_01_000002_create_jobs_table.php` | Batched job tracking and progress. |
| `failed_jobs` | Laravel Queue | `0001_01_01_000002_create_jobs_table.php` | Dead-letter queue for job exceptions. |

---

## 2. Table Specifications

### `cache` & `cache_locks`
Stores transient cached data and prevents concurrent race conditions across parallel requests.

```sql
CREATE TABLE cache (
    `key` VARCHAR(255) PRIMARY KEY,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` BIGINT NOT NULL,
    INDEX(`expiration`)
);

CREATE TABLE cache_locks (
    `key` VARCHAR(255) PRIMARY KEY,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` BIGINT NOT NULL,
    INDEX(`expiration`)
);
```

### `jobs` & `failed_jobs`
Drives background processing for OCR text extraction, PDF generation, and notification delivery.

```sql
CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts SMALLINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    INDEX(queue)
);

CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
```

---

## 3. Reliability & Operational Best Practices

- **OCR Isolation:** Optical Character Recognition runs asynchronously on the queue to prevent HTTP worker timeouts.
- **Dead-Letter Diagnostics:** Unhandled worker exceptions are recorded in `failed_jobs` and can be inspected or retried via `php artisan queue:retry all`.

---

## 4. Cross-Quadrant Links

- **Architecture Reference:** [System Architecture Overview](./architecture-overview.md)
- **Document Management Schema:** [Document Management Reference](./database-schema-document-management.md)
