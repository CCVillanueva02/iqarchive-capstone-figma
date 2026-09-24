# Data Dictionary: `accreditation_stage_histories`

**Schema Zone:** Zone 3 — Accreditation Pipeline & Task Force Management  
**Table Responsibility:** Immutable state machine transition audit log for all 9 accreditation stages.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `accreditation_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `accreditations(id)` ON DELETE CASCADE |
| `from_stage` | `UNSIGNED INTEGER` | `none` | Preceding stage number (nullable for initial creation) |
| `to_stage` | `UNSIGNED INTEGER` | `required` | Destination stage number (1 to 9) |
| `initiated_by` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `users(id)` ON DELETE CASCADE (IQA Staff only) |
| `approved_by` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `users(id)` ON DELETE CASCADE (IQA Staff only) |
| `remarks` | `TEXT` | `none` | Justification or transitional review notes (nullable) |
| `transitioned_at` | `TIMESTAMP` | `required` | Stage transition timestamp (defaults to current timestamp) |
