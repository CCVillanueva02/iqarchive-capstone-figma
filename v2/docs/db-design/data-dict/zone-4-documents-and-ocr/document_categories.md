# Data Dictionary: `document_categories`

**Schema Zone:** Zone 4 — Evidence Document Storage, Review & OCR Engine  
**Table Responsibility:** Taxonomy classifications and governance scopes for uploaded accreditation evidence files.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `name` | `VARCHAR(100)` | `required` | Category label (e.g., "Curriculum & Syllabi", "Board Resolutions", or administrative offices like "HRDO", "University Registrar") |
| `scope` | `ENUM('institutional', 'college', 'program')` | `required` | Document hierarchy level: Institutional (`institutional` — university offices & common docs), College (`college`), or Program (`program`) |
| `description` | `TEXT` | `none` | Category scope and upload guidelines (nullable) |
| `created_at` | `TIMESTAMP` | `required` | Record creation timestamp (defaults to current timestamp) |
