# Data Dictionary: `compliance_requirements`

**Schema Zone:** Zone 3 — Accreditation Pipeline & Task Force Management  
**Table Responsibility:** Compliance tracking checklist mapping each criterion in an active accreditation to its fulfillment status.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `accreditation_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `accreditations(id)` ON DELETE CASCADE |
| `instrument_criteria_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `instrument_criteria(id)` ON DELETE CASCADE |
| `status` | `ENUM('unassigned', 'in_progress', 'compliant')` | `required` | Evidence readiness status (defaults to 'unassigned') |
| `due_date` | `DATE` | `none` | Deadline for evidence upload and compliance (nullable) |
| `remarks` | `TEXT` | `none` | Evaluator or task force compliance notes (nullable) |
| `created_at` | `TIMESTAMP` | `required` | Record creation timestamp (defaults to current timestamp) |

- **Unique Constraint:** `UNIQUE(accreditation_id, instrument_criteria_id)` ensures each criterion appears once per accreditation survey.
