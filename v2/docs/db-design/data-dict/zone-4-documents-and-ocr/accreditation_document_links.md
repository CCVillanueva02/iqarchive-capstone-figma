# Data Dictionary: `accreditation_document_links`

**Schema Zone:** Zone 4 — Evidence Document Storage, Review & OCR Engine  
**Table Responsibility:** Many-to-many junction linking uploaded evidence documents to specific accreditation compliance criteria.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `compliance_requirement_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `compliance_requirements(id)` ON DELETE CASCADE |
| `document_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `documents(id)` ON DELETE CASCADE |
| `relevance_notes` | `TEXT` | `none` | Justification explaining how document satisfies criterion (nullable) |
| `created_at` | `TIMESTAMP` | `required` | Link mapping timestamp (defaults to current timestamp) |

- **Unique Constraint:** `UNIQUE(compliance_requirement_id, document_id)` prevents redundant evidence bindings to the same criterion.
