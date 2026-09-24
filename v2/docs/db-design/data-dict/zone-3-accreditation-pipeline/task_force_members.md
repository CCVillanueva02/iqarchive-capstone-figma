# Data Dictionary: `task_force_members`

**Schema Zone:** Zone 3 — Accreditation Pipeline & Task Force Management  
**Table Responsibility:** Faculty assignments mapping task force members to designated AACCUP survey areas.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `task_force_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `task_forces(id)` ON DELETE CASCADE |
| `user_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `users(id)` ON DELETE CASCADE |
| `instrument_area_id` | `BIGINT UNSIGNED` | `foreign key` | Foreign Key $\to$ `instrument_areas(id)` ON DELETE SET NULL (nullable for general leads) |
| `role_in_team` | `ENUM('lead', 'area_chair', 'member')` | `required` | Member committee tier: Lead (`lead`), Area Chair (`area_chair`), or Member (`member`) |
| `assigned_at` | `TIMESTAMP` | `required` | Assignment timestamp (defaults to current timestamp) |
