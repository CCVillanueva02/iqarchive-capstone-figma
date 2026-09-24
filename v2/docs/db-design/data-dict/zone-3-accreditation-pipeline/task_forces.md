# Data Dictionary: `task_forces`

**Schema Zone:** Zone 3 — Accreditation Pipeline & Task Force Management  
**Table Responsibility:** Program accreditation committees established per academic cycle to prepare survey instruments.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `program_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `programs(id)` ON DELETE CASCADE |
| `dean_lead_user_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `users(id)` ON DELETE CASCADE (Dean automatically elevated to Task Force Lead) |
| `academic_year` | `VARCHAR(20)` | `required` | Target academic cycle year (e.g., "2025-2026") |
| `status` | `ENUM('active', 'archived')` | `required` | Operational status of the committee (defaults to 'active') |
| `created_at` | `TIMESTAMP` | `required` | Record creation timestamp (defaults to current timestamp) |
