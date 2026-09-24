# Data Dictionary: `notifications`

**Schema Zone:** Zone 1 — Multi-Tenancy, Identity & Access Control  
**Table Responsibility:** In-app operational alerts, task assignments, and stage transition notifications for users.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `user_id` | `BIGINT UNSIGNED` | `required, foreign key` | Foreign Key $\to$ `users(id)` ON DELETE CASCADE |
| `type` | `VARCHAR(100)` | `required` | Notification category (e.g., "stage.assigned", "review.required") |
| `title` | `VARCHAR(255)` | `required` | Brief notification subject heading |
| `message` | `TEXT` | `required` | Full notification message body |
| `link` | `VARCHAR(500)` | `none` | In-app target action URI (nullable) |
| `is_read` | `BOOLEAN` | `required` | Read status indicator (defaults to false) |
| `read_at` | `TIMESTAMP` | `none` | Timestamp when user opened notification (nullable) |
| `created_at` | `TIMESTAMP` | `required` | Notification generation timestamp (defaults to current timestamp) |
