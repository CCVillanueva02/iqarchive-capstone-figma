# Data Dictionary: `programs`

**Schema Zone:** Zone 1 — Multi-Tenancy, Identity & Access Control  
**Table Responsibility:** Degree-granting academic programs undergoing AACCUP accreditation under each college.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `college_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `colleges(id)` ON DELETE CASCADE |
| `name` | `VARCHAR(255)` | `required` | Degree program name (e.g., "BS in Computer Science") |
| `code` | `VARCHAR(50)` | `required, unique` | Unique program code (e.g., "BSCS") |
| `current_level` | `VARCHAR(50)` | `required` | Accreditation status (e.g., "Candidate", "Level III Phase 2") |
| `created_at` | `TIMESTAMP` | `none` | Record creation timestamp (nullable) |
| `updated_at` | `TIMESTAMP` | `none` | Record last modification timestamp (nullable) |
