# Data Dictionary: `instrument_areas`

**Schema Zone:** Zone 2 — AACCUP Survey Instrument Master Hierarchy  
**Table Responsibility:** The 10 standard evaluation areas defined by AACCUP (Areas I through X).

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `instrument_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `instruments(id)` ON DELETE CASCADE |
| `area_number` | `INT UNSIGNED` | `required` | Official area sequential index (1 to 10) |
| `name` | `VARCHAR(255)` | `required` | Full area title (e.g., "Area I: Vision, Mission, Goals, and Objectives") |
| `description` | `TEXT` | `none` | Scope and evaluation guidance for the area (nullable) |
| `created_at` | `TIMESTAMP` | `required` | Record creation timestamp (defaults to current timestamp) |
