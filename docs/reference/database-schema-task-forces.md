# Database Schema: Accreditations & Task Forces

This reference document details the schema for accreditation survey cycles, organized task forces, and member leadership assignments.

---

## 1. Tables Overview

| Table | Model | Migration Source | Purpose |
| :--- | :--- | :--- | :--- |
| [`accreditations`](../../app/Models/Accreditation.php) | `App\Models\Accreditation` | `2026_08_23_141853...`, `2026_08_23_143657...` | Formal accreditation survey visits and cycles. |
| [`task_forces`](../../app/Models/TaskForce.php) | `App\Models\TaskForce` | `2026_07_28_000000...`, `2026_08_23_150550...` | College/program QA task force bodies. |
| [`task_force_members`](../../app/Models/TaskForceMember.php) | `App\Models\TaskForceMember` | `2026_07_28_000000_create_task_forces_tables.php` | Pivot linking users to task forces with team roles. |
| [`task_force_assignments`](../../app/Models/TaskForceAssignment.php) | `App\Models\TaskForceAssignment` | `2026_07_19_000000_create_iqarchive_core_tables.php` | Legacy direct user-to-program mapping. |

---

## 2. Table Specifications

### `accreditations`
Represents an official accreditation survey cycle for a degree program.

```sql
CREATE TABLE accreditations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    program_id BIGINT UNSIGNED NOT NULL REFERENCES programs(id) ON DELETE CASCADE,
    task_force_id BIGINT UNSIGNED NULL REFERENCES task_forces(id) ON DELETE SET NULL,
    status VARCHAR(255) NOT NULL DEFAULT 'scheduled', -- 'scheduled', 'in_progress', 'completed', 'deferred'
    proposed_members JSON NULL,
    target_date DATE NULL,
    created_by BIGINT UNSIGNED NULL REFERENCES users(id) ON DELETE SET NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### `task_forces`
Represents the collective team assigned to prepare compliance portfolios.

```sql
CREATE TABLE task_forces (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL UNIQUE,
    college_id BIGINT UNSIGNED NOT NULL REFERENCES colleges(id) ON DELETE CASCADE,
    program_id BIGINT UNSIGNED NULL REFERENCES programs(id) ON DELETE SET NULL,
    purpose TEXT NULL,
    status VARCHAR(255) NOT NULL DEFAULT 'active',    -- 'active', 'completed', 'disbanded'
    proposed_members JSON NULL,
    created_by BIGINT UNSIGNED NULL REFERENCES users(id) ON DELETE SET NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### `task_force_members` (Pivot)
Defines individual user participation and designated team roles (`lead`, `member`).

| Column | Type | Nullable | Default | Notes |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `BIGINT UNSIGNED` | No | Auto Inc | Primary Key. |
| `task_force_id` | `BIGINT UNSIGNED` | No | None | FK $\rightarrow$ `task_forces(id)` (`ON DELETE CASCADE`). |
| `user_id` | `BIGINT UNSIGNED` | No | None | FK $\rightarrow$ `users(id)` (`ON DELETE CASCADE`). |
| `role_in_team` | `VARCHAR(255)` | No | `'member'` | `'lead'`, `'member'`. |
| `assigned_at` | `TIMESTAMP` | No | Current | Timestamp of assignment. |
| `created_at` | `TIMESTAMP` | Yes | `NULL` | Timestamp. |
| `updated_at` | `TIMESTAMP` | Yes | `NULL` | Timestamp. |

*Unique Index:* `UNIQUE(task_force_id, user_id)`

---

## 3. Automated Observer Assignment

When a `TaskForce` is created with a non-null `college_id`, an Eloquent Observer in [`app/Providers/AppServiceProvider.php`](../../app/Providers/AppServiceProvider.php) automatically detects the College Head (Dean) and inserts a `task_force_members` record with `role_in_team = 'lead'`.

---

## 4. Cross-Quadrant Links

- **Role Reference:** [RBAC: Task Force Members Pivot](./rbac-task-force-members-pivot.md)
- **Role Reference:** [RBAC: Task Force Member](./rbac-task-force-member.md)
- **Explanation:** [College Head Contextual Elevation](../explanation/head-contextual-elevation.md)
