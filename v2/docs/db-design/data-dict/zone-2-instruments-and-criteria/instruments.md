# Data Dictionary: `instruments`

**Schema Zone:** Zone 2 — AACCUP Survey Instrument Master Hierarchy  
**Table Responsibility:** Master evaluation instruments released by AACCUP (e.g. Undergraduate, Graduate, Institutional).

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `name` | `VARCHAR(255)` | `required` | Instrument title (e.g., "AACCUP Revised Survey Instrument") |
| `code` | `VARCHAR(50)` | `required, unique` | Official instrument code (e.g., "AACCUP-2024-UG") |
| `type` | `ENUM('ug', 'grad', 'inst')` | `required` | Survey level: Undergraduate (`ug`), Graduate (`grad`), or Institutional (`inst`) |
| `version` | `VARCHAR(20)` | `required` | Revision version tag (e.g., "2024.1") |
| `is_active` | `BOOLEAN` | `required` | Active availability status (defaults to true) |
| `created_at` | `TIMESTAMP` | `required` | Record creation timestamp (defaults to current timestamp) |
