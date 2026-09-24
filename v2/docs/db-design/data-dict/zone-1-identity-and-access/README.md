# Zone 1: Multi-Tenancy, Identity & Access Control

This zone defines the core institutional boundaries, user accounts, authentication, authorization, audit logging, and notifications for IQArchive.

### Tables
1. [`colleges`](./colleges.md) — Root multi-tenant boundary for academic units.
2. [`programs`](./programs.md) — Degree-granting academic programs.
3. [`users`](./users.md) — Faculty, staff, and accreditor accounts.
4. [`roles`](./roles.md) — The 7 institutional roles.
5. [`user_roles`](./user_roles.md) — Role junction (many-to-many).
6. [`audit_logs`](./audit_logs.md) — Immutable compliance audit trail.
7. [`notifications`](./notifications.md) — In-app operational alerts and task notices.
