# Database Schema: Entity Relationship Diagram & Seeders

This reference document summarizes the global Entity Relationship Diagram (ERD) and seeder execution sequence for IQArchive.

---

## 1. Global Entity Relationship Diagram (ERD)

```mermaid
erDiagram
    COLLEGES ||--o{ PROGRAMS : "offers"
    COLLEGES ||--o{ USERS : "has"
    COLLEGES ||--o{ TASK_FORCES : "organizes"
    
    PROGRAMS ||--o{ USERS : "assigns"
    PROGRAMS ||--o{ DOCUMENTS : "owns"
    PROGRAMS ||--o{ COMPLIANCE_REQUIREMENTS : "tracks"
    PROGRAMS ||--o{ ACCREDITATIONS : "undergoes"

    ROLES ||--o{ USERS : "primary_role"
    ROLES ||--o{ ROLE_USER : "pivot"
    USERS ||--o{ ROLE_USER : "pivot"
    
    USERS ||--o{ PASSKEYS : "authenticates"
    USERS ||--o{ DOCUMENTS : "uploads"
    USERS ||--o{ DOCUMENT_REVIEWS : "performs"
    USERS ||--o{ DOCUMENT_OCR_VALIDATIONS : "validates"
    USERS ||--o{ DOCUMENT_ACCESS_REQUESTS : "requests"
    USERS ||--o{ NOTIFICATIONS : "receives"
    USERS ||--o{ AUDIT_LOGS : "triggers"
    USERS ||--o{ TASK_FORCE_MEMBERS : "participates"

    OFFICES ||--o{ DOCUMENTS : "issues"
    DOCUMENT_CATEGORIES ||--o{ DOCUMENTS : "categorizes"
    
    DOCUMENTS ||--o{ DOCUMENT_OCR_VALIDATIONS : "has"
    DOCUMENTS ||--o{ DOCUMENT_REVIEWS : "has"
    DOCUMENTS ||--o{ DOCUMENT_ACCESS_REQUESTS : "has"
    DOCUMENTS ||--o{ ACCREDITATION_DOCUMENT_LINKS : "supplies"

    ACCREDITATIONS ||--o| TASK_FORCES : "assigned_to"
    ACCREDITATIONS ||--o| INSTRUMENTS : "evaluates_with"
    ACCREDITATIONS ||--o{ COMPLIANCE_REQUIREMENTS : "requires"

    TASK_FORCES ||--o{ TASK_FORCE_MEMBERS : "composed_of"

    INSTRUMENTS ||--o{ INSTRUMENT_AREAS : "contains"
    INSTRUMENT_AREAS ||--o{ INSTRUMENT_PARAMETERS : "groups"
    INSTRUMENT_PARAMETERS ||--o{ INSTRUMENT_CRITERIA : "contains"
    
    INSTRUMENT_CRITERIA ||--o{ COMPLIANCE_REQUIREMENTS : "evaluated_by"
    COMPLIANCE_REQUIREMENTS ||--o{ ACCREDITATION_DOCUMENT_LINKS : "supported_by"
```

---

## 2. Seeder Execution Sequence

The default database state is populated by running `php artisan db:seed`:

```
DatabaseSeeder
 ├── RoleSeeder                  (System Administrator, IQA Staff, Accreditor, etc.)
 ├── OfficeSeeder                (General Admin, Research Office, HR, etc.)
 ├── CollegeSeeder               (17 BU Colleges & Satellite Campuses)
 ├── ProgramSeeder               (BU Degree Programs)
 ├── DocumentCategorySeeder      (Policies, Memoranda, Syllabi, etc.)
 ├── UserSeeder                  (Default institutional users & syncs role_user)
 ├── AaccupMasterInstrumentSeeder (10-Area AACCUP Instrument Templates)
 ├── DocumentSeeder              (Sample simulated documents & reviews)
 ├── AuditLogSeeder              (Paired logins, document event history)
 └── TestPdfSeeder               (Creates physical PDF files in storage)
```

---

## 3. Subsystem Schema References

- [Authentication & Security Schema](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-auth-security.md)
- [Organizational Hierarchy Schema](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-organizational-hierarchy.md)
- [Document Management Schema](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-document-management.md)
- [Accreditations & Task Forces Schema](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-task-forces.md)
- [Dynamic Instruments Schema](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-dynamic-instruments.md)
- [System Auditing Schema](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-system-audit.md)
- [Framework & Queue Infrastructure Schema](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-infrastructure-queues.md)
- [Self-Survey Subsystem Schema](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-self-survey.md)
