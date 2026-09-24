# Data Dictionary: `documents`

**Schema Zone:** Zone 4 — Evidence Document Storage, Review & OCR Engine  
**Table Responsibility:** Master evidence registry containing cloud storage object keys, SHA-256 integrity hashes, and multi-tenant college scoping.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `college_id` | `BIGINT UNSIGNED` | `foreign key, nullable` | Foreign Key $\to$ `colleges(id)` ON DELETE CASCADE (multi-tenant boundary; NULL for institutional/common files) |
| `program_id` | `BIGINT UNSIGNED` | `foreign key` | Foreign Key $\to$ `programs(id)` ON DELETE SET NULL (nullable for college/institutional files) |
| `category_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `document_categories(id)` ON DELETE CASCADE |
| `user_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `users(id)` ON DELETE CASCADE (uploading faculty/staff) |
| `title` | `VARCHAR(255)` | `required` | Human-readable document display title |
| `original_filename` | `VARCHAR(255)` | `required` | Uploaded client file name (e.g., "BSCS-Curriculum-2024.pdf") |
| `file_path` | `VARCHAR(500)` | `required` | Private cloud storage object key (`evidence/{college_id}/{program_id}/{file_hash}.pdf`) |
| `file_hash` | `VARCHAR(64)` | `required` | Cryptographic SHA-256 integrity hash for deduplication and audit |
| `file_size_bytes` | `BIGINT UNSIGNED` | `required` | Total binary file size in bytes |
| `mime_type` | `VARCHAR(100)` | `required` | Standard media type (e.g., "application/pdf") |
| `status` | `ENUM('draft', 'dean_appr', 'iqa_appr', 'rejected')` | `required` | Two-tier approval lifecycle status (defaults to 'draft') |
| `visibility` | `ENUM('private', 'college', 'univ', 'accreditor')` | `required` | Access tier: Private (`private`), College (`college`), University (`univ`), or Accreditor (`accreditor`) |
| `created_at` | `TIMESTAMP` | `required` | Upload timestamp (defaults to current timestamp) |
