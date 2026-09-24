# Data Dictionary: `document_reviews`

**Schema Zone:** Zone 4 — Evidence Document Storage, Review & OCR Engine  
**Table Responsibility:** Two-tier approval decisions and commentary (Dean endorsement gate, IQA verification gate, and Internal Accreditor notes).

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `document_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `documents(id)` ON DELETE CASCADE |
| `user_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `users(id)` ON DELETE CASCADE (reviewer) |
| `review_stage` | `ENUM('dean', 'iqa', 'internal_accreditor')` | `required` | Review tier: Dean endorsement (`dean`), IQA approval (`iqa`), or Internal Accreditor audit (`internal_accreditor`) |
| `decision` | `ENUM('approved', 'rejected', 'advisory')` | `required` | Evaluation decision: Approved (`approved`), Rejected (`rejected`), or Advisory Notice (`advisory`) |
| `remarks` | `TEXT` | `none` | Evaluator feedback and reason for decision (nullable) |
| `reviewed_at` | `TIMESTAMP` | `required` | Decision timestamp (defaults to current timestamp) |
