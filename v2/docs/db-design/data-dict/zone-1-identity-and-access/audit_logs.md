# Data Dictionary: `audit_logs`

**Schema Zone:** Zone 1 — Multi-Tenancy, Identity & Access Control  
**Table Responsibility:** Immutable, append-only compliance audit trail recording security events, authentication, role switches, and document interactions.

| Field Name | Data Type | Constraint | Description / Relationship |
|---|---|---|---|
| `id` | `BIGINT UNSIGNED` | `required, unique` | Primary Key (auto-incrementing identifier) |
| `college_id` | `BIGINT UNSIGNED` | `foreign key` | Foreign Key $\to$ `colleges(id)` ON DELETE SET NULL (nullable for central staff) |
| `user_id` | `BIGINT UNSIGNED` | `foreign key` | Foreign Key $\to$ `users(id)` ON DELETE SET NULL (nullable for system events) |
| `action` | `VARCHAR(100)` | `required` | Event slug (e.g., "auth.login", "document.upload", "stage.transition") |
| `target_type` | `VARCHAR(100)` | `required` | Target Eloquent model class name (e.g., "App\Models\Document") |
| `target_id` | `VARCHAR(50)` | `none` | ID of target entity (nullable) |
| `ip_address` | `VARCHAR(45)` | `none` | Client IPv4 or IPv6 network address (nullable) |
| `details` | `JSON` | `none` | Contextual event metadata and diff payload (nullable) |
| `created_at` | `TIMESTAMP` | `required` | Immutable event timestamp (defaults to current timestamp) |
