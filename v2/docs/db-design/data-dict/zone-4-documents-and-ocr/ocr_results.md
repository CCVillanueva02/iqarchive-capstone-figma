# Data Dictionary: `ocr_results`

**Schema Zone:** Zone 4 — Evidence Document Storage, Review & OCR Engine  
**Table Responsibility:** Synchronous Tesseract OCR extraction output (1:1 with `documents`), targeted at accreditation certificates and rating sheets.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `document_id` | `BIGINT UNSIGNED` | `required, foreign key, unique` | Foreign Key $\to$ `documents(id)` ON DELETE CASCADE (1:1 relationship) |
| `validated_by_user_id` | `BIGINT UNSIGNED` | `foreign key` | Foreign Key $\to$ `users(id)` ON DELETE SET NULL (user who validated OCR text) |
| `raw_text` | `LONGTEXT` | `required` | Unmodified OCR output text extracted by Tesseract engine |
| `edited_text` | `LONGTEXT` | `none` | Human-in-the-loop corrected text (nullable) |
| `confidence_metrics` | `JSON` | `required` | Per-word bounding boxes and confidence scores $(< 0.65$ flagged) |
| `pages_data` | `JSON` | `required` | Per-page dimensions, resolution, and layout metrics |
| `average_confidence` | `DECIMAL(5,4)` | `required` | Overall document optical recognition confidence (e.g., 0.9412) |
| `status` | `ENUM('processing', 'completed', 'validated')` | `required` | OCR lifecycle state (defaults to 'processing') |
| `duration_ms` | `UNSIGNED INTEGER` | `required` | Processing execution time in milliseconds |
| `validated_at` | `TIMESTAMP` | `none` | Timestamp of human reviewer validation stamp (nullable) |
| `created_at` | `TIMESTAMP` | `required` | OCR extraction initiation timestamp (defaults to current timestamp) |
