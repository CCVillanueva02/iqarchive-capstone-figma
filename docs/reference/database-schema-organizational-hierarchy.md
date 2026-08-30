# Database Schema: Organizational Hierarchy

This reference document details the organizational structures within Bicol University, including academic colleges, degree programs, and administrative offices.

---

## 1. Tables Overview

| Table | Model | Migration Source | Purpose |
| :--- | :--- | :--- | :--- |
| [`colleges`](file:///c:/Users/janss/Herd/iqarchive/app/Models/College.php) | `App\Models\College` | `0001_01_01_000000_create_users_table.php`, `2026_08_19_000001...` | Academic colleges and satellite campuses. |
| [`programs`](file:///c:/Users/janss/Herd/iqarchive/app/Models/Program.php) | `App\Models\Program` | `0001_01_01_000000_create_users_table.php`, `2026_08_04_000000...` | Degree programs and accreditation levels. |
| [`offices`](file:///c:/Users/janss/Herd/iqarchive/app/Models/Office.php) | `App\Models\Office` | `2026_08_18_141902_create_offices_table.php` | Central administrative offices issuing records. |

---

## 2. Table Specifications

### `colleges`
Represents academic units across Bicol University (e.g. College of Science, BU Polangui).

```sql
CREATE TABLE colleges (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(255) NOT NULL UNIQUE,
    campus VARCHAR(255) NOT NULL DEFAULT 'Main Campus',
    logo_image VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL
);
```

### `programs`
Represents undergraduate and graduate degree programs within colleges.

| Column | Type | Nullable | Default | Notes |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | No | Auto Inc | Primary Key. |
| `college_id` | `BIGINT UNSIGNED` | No | None | FK $\rightarrow$ `colleges(id)` (`ON DELETE CASCADE`). |
| `name` | `VARCHAR(255)` | No | None | Full degree program name. |
| `code` | `VARCHAR(255)` | No | None | Unique program code (e.g. `BSCS`, `BSIT`). |
| `accreditation_level` | `VARCHAR(255)` | No | `'Candidate Status'` | `Candidate Status`, `Level I`, `Level II`, `Level III`, `Level IV`. |
| `created_at` | `TIMESTAMP` | Yes | `NULL` | Timestamp. |
| `updated_at` | `TIMESTAMP` | Yes | `NULL` | Timestamp. |
| `deleted_at` | `TIMESTAMP` | Yes | `NULL` | Soft delete support. |

### `offices`
Central university non-academic offices issuing institutional compliance records.

```sql
CREATE TABLE offices (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

---

## 3. Relationships & Eloquent Mapping

```
College (1) ──< Programs (N) ──< Documents (N)
College (1) ──< Users (N)
Office (1)  ──< Documents (N)
```

- **`College::programs()`**: `hasMany(Program::class)`
- **`Program::college()`**: `belongsTo(College::class)`
- **`Program::documents()`**: `hasMany(Document::class)`
- **`Office::documents()`**: `hasMany(Document::class)`

---

## 4. Security & Access Rules

- **Soft Deletes:** Both `colleges` and `programs` use Laravel Soft Deletes (`deleted_at`) to ensure historical accreditation data and audit logs are never orphaned.
- **Modification Gate:** Only users holding the `iqa-staff` or `system-administrator` role can create, update, or soft-delete colleges and programs via the `manageCollegesAndPrograms` gate.

---

## 5. Cross-Quadrant Links

- **Role Reference:** [RBAC: College Head](file:///c:/Users/janss/Herd/iqarchive/docs/reference/rbac-college-head.md)
- **Role Reference:** [RBAC: Program Chair](file:///c:/Users/janss/Herd/iqarchive/docs/reference/rbac-program-chair.md)
- **Explanation:** [College Head Contextual Elevation](file:///c:/Users/janss/Herd/iqarchive/docs/explanation/head-contextual-elevation.md)
