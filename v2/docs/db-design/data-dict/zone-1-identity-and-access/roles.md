# Data Dictionary: `roles`

**Schema Zone:** Zone 1 — Multi-Tenancy, Identity & Access Control  
**Table Responsibility:** Catalog of the 7 institutional roles governing authorization levels across the university.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `name` | `VARCHAR(50)` | `required, unique` | Machine slug (`system_admin`, `iqa_staff`, `college_dean`, `task_force_member`, `internal_accreditor`, `bu_executive`, `external_accreditor`) |
| `display_name` | `VARCHAR(100)` | `required` | Human-readable role label (e.g., "College Dean") |
| `description` | `TEXT` | `none` | Detailed scope of responsibilities (nullable) |
| `created_at` | `TIMESTAMP` | `none` | Record creation timestamp (nullable) |
| `updated_at` | `TIMESTAMP` | `none` | Record last modification timestamp (nullable) |
