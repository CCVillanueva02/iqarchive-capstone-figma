# Data Dictionary: `instrument_parameters`

**Schema Zone:** Zone 2 — AACCUP Survey Instrument Master Hierarchy  
**Table Responsibility:** Sub-sections within an AACCUP accreditation area (e.g. Parameter A, Parameter B).

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `instrument_area_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `instrument_areas(id)` ON DELETE CASCADE |
| `parameter_letter` | `VARCHAR(10)` | `required` | Parameter designation letter (e.g., "Parameter A", "Parameter B") |
| `name` | `VARCHAR(255)` | `required` | Parameter descriptive title |
| `description` | `TEXT` | `none` | Evaluation objectives and scope notes (nullable) |
| `created_at` | `TIMESTAMP` | `required` | Record creation timestamp (defaults to current timestamp) |
