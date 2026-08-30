# Database Schema: System Auditing & Notifications

This reference document details the schema for system activity tracking, security event trails, and user notifications.

---

## 1. Tables Overview

| Table | Model | Migration Source | Purpose |
| :--- | :--- | :--- | :--- |
| [`audit_logs`](../../app/Models/AuditLog.php) | `App\Models\AuditLog` | `2026_07_19_000000_create_iqarchive_core_tables.php` | Immutable system and security audit trail. |
| [`notifications`](../../app/Models/Notification.php) | `App\Models\Notification` | `2026_07_19_000000_create_iqarchive_core_tables.php` | User notifications, status alerts, and reminders. |

---

## 2. Table Specifications

### `audit_logs`
Stores immutable chronological records of user actions, authentication events, and document lifecycles.

```sql
CREATE TABLE audit_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL REFERENCES users(id) ON DELETE SET NULL,
    action VARCHAR(255) NOT NULL,
    target_type VARCHAR(255) NULL,
    target_id BIGINT UNSIGNED NULL,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
```

#### Monitored Event Types
- **Authentication:** `login`, `logout`, `GOOGLE_LOGIN`, `password_reset`.
- **User Administration:** `CREATE_USER`, `UPDATE_USER`, `DEACTIVATE_USER`.
- **Document Workflow:** `document_upload`, `document_update`, `document_approve`, `document_reject`, `document_delete`.

### `notifications`
Stores personalized in-app notifications and review alerts for authenticated users.

```sql
CREATE TABLE notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    related_document_id BIGINT UNSIGNED NULL REFERENCES documents(id) ON DELETE SET NULL,
    type VARCHAR(255) NOT NULL,        -- 'info', 'alert', 'document_status'
    message TEXT NOT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

---

## 3. Automated Observers & Security Architecture

- **Tamper Resistance:** The `audit_logs` table has no `updated_at` column and its Eloquent model enforces `public $timestamps = false;` to ensure log entries cannot be modified after insertion.
- **Automated Event Sinks:** Authentication events (`Login`, `Logout`, `PasswordReset`) and Document events (`created`, `updated`, `deleted`) are wired directly to `AuditLog::create` in `app/Providers/AppServiceProvider.php`.

---

## 4. Cross-Quadrant Links

- **Role Reference:** [RBAC: System Administrator](./rbac-system-administrator.md)
- **Role Reference:** [RBAC: IQA Staff](./rbac-iqa-staff.md)
- **Architecture Reference:** [System Architecture Overview](./architecture-overview.md)
