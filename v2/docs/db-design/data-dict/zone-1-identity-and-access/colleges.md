# Data Dictionary: `colleges`

**Schema Zone:** Zone 1 — Multi-Tenancy, Identity & Access Control  
**Table Responsibility:** Root multi-tenant boundary representing academic colleges and university units at Bicol University.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `name` | `VARCHAR(255)` | `required` | Official college name (e.g., "College of Science") |
| `code` | `VARCHAR(50)` | `required, unique` | Short institutional code (e.g., "CS", "CENG", "BUCL") |
| `created_at` | `TIMESTAMP` | `none` | Record creation timestamp (nullable) |
| `updated_at` | `TIMESTAMP` | `none` | Record last modification timestamp (nullable) |
