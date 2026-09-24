# Data Dictionary: `user_roles`

**Schema Zone:** Zone 1 — Multi-Tenancy, Identity & Access Control  
**Table Responsibility:** Many-to-many role assignments resolving faculty roles (supports dual roles, e.g. Dean + Task Force Lead).

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `user_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `users(id)` ON DELETE CASCADE |
| `role_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `roles(id)` ON DELETE CASCADE |
| `created_at` | `TIMESTAMP` | `none` | Record creation timestamp (nullable) |
| `updated_at` | `TIMESTAMP` | `none` | Record last modification timestamp (nullable) |

- **Unique Constraint:** `UNIQUE(user_id, role_id)` prevents assigning duplicate roles to the same user.
