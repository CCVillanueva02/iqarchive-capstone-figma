# Data Dictionary: `users`

**Schema Zone:** Zone 1 — Multi-Tenancy, Identity & Access Control  
**Table Responsibility:** Faculty, staff, and accreditor accounts strictly authenticated via Bicol University Google Workspace OAuth 2.0.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `college_id` | `BIGINT UNSIGNED` | `foreign key` | Foreign Key $\to$ `colleges(id)` ON DELETE SET NULL (nullable for central staff) |
| `name` | `VARCHAR(255)` | `required` | Full user name from Google profile |
| `email` | `VARCHAR(255)` | `required, unique` | Institutional email domain-gated to `@bicol-u.edu.ph` |
| `google_id` | `VARCHAR(255)` | `unique` | Google subject identifier (OpenID sub claim) |
| `avatar_url` | `VARCHAR(500)` | `none` | Profile picture URL from Google |
| `status` | `ENUM('active', 'inactive')` | `required` | Account status flag (defaults to 'inactive' until verified by IQA) |
| `remember_token` | `VARCHAR(100)` | `none` | Session persistence token (nullable) |
| `created_at` | `TIMESTAMP` | `none` | Record creation timestamp |
| `updated_at` | `TIMESTAMP` | `none` | Record last modification timestamp |
