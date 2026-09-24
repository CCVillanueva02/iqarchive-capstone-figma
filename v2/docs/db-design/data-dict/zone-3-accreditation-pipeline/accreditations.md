# Data Dictionary: `accreditations`

**Schema Zone:** Zone 3 — Accreditation Pipeline & Task Force Management  
**Table Responsibility:** Formal AACCUP accreditation survey cycle instances for degree programs.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `program_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `programs(id)` ON DELETE CASCADE |
| `task_force_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `task_forces(id)` ON DELETE CASCADE |
| `applied_level` | `VARCHAR(50)` | `required` | Target AACCUP evaluation level (e.g., "Level II", "Level III Phase 1") |
| `current_stage` | `UNSIGNED INTEGER` | `required` | Active stage in the 9-stage pipeline (defaults to 1) |
| `stage_status` | `ENUM('in_progress', 'done', 'revision')` | `required` | Progress status within the active stage (defaults to 'in_progress') |
| `target_date` | `DATE` | `none` | Scheduled date of the formal accreditation visit (nullable) |
| `created_at` | `TIMESTAMP` | `required` | Record creation timestamp (defaults to current timestamp) |
