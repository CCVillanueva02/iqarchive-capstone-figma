# Data Dictionary: `compliance_comments`

**Schema Zone:** Zone 3 — Accreditation Pipeline & Task Force Management  
**Table Responsibility:** Advisory commentary, deficit flags, and clarification remarks recorded by Internal Accreditors on specific criteria.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `compliance_requirement_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `compliance_requirements(id)` ON DELETE CASCADE |
| `user_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `users(id)` ON DELETE CASCADE (comment author) |
| `comment_type` | `ENUM('advisory', 'gap', 'clarification')` | `required` | Finding classification: Advisory (`advisory`), Evidence Gap (`gap`), or Clarification (`clarification`) |
| `comment_text` | `TEXT` | `required` | Full remark or recommendation narrative |
| `is_resolved` | `BOOLEAN` | `required` | Deficit resolution status (defaults to false) |
| `created_at` | `TIMESTAMP` | `required` | Comment post timestamp (defaults to current timestamp) |
