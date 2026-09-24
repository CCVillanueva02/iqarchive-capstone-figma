# Data Dictionary: `instrument_criteria`

**Schema Zone:** Zone 2 — AACCUP Survey Instrument Master Hierarchy  
**Table Responsibility:** Individual evaluation benchmarks and criteria against which evidence documents are mapped.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `instrument_parameter_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `instrument_parameters(id)` ON DELETE CASCADE |
| `benchmark_code` | `VARCHAR(50)` | `required` | Criterion code (e.g., "S.1", "I.1", "O.1") |
| `title` | `TEXT` | `required` | Full benchmark requirement statement |
| `type` | `ENUM('system', 'impl', 'outcome')` | `required` | Benchmark classification: System (`system`), Implementation (`impl`), or Outcome (`outcome`) |
| `created_at` | `TIMESTAMP` | `required` | Record creation timestamp (defaults to current timestamp) |
