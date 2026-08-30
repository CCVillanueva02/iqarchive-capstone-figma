# Database Schema: Dynamic Instruments & Compliance

This reference document details the schema for dynamic AACCUP accreditation instruments, hierarchical criteria checklists, compliance tasks, and evidence document links.

---

## 1. Tables Overview

| Table | Model | Migration Source | Purpose |
| :--- | :--- | :--- | :--- |
| [`instruments`](../../app/Models/Instrument.php) | `App\Models\Instrument` | `2026_08_24_000001_create_dynamic_instrument_tables.php` | Master templates and cloned survey instruments. |
| [`instrument_areas`](../../app/Models/InstrumentArea.php) | `App\Models\InstrumentArea` | `2026_08_24_000001_create_dynamic_instrument_tables.php` | Top-level accreditation evaluation areas (Areas I–X). |
| [`instrument_parameters`](../../app/Models/InstrumentParameter.php) | `App\Models\InstrumentParameter` | `2026_08_24_000001_create_dynamic_instrument_tables.php` | Area sub-parameters (Parameter A, B, etc.). |
| [`instrument_criteria`](../../app/Models/InstrumentCriterion.php) | `App\Models\InstrumentCriterion` | `2026_08_24_000001_create_dynamic_instrument_tables.php` | Discrete checklist items across AACCUP 4 sections. |
| [`compliance_requirements`](../../app/Models/ComplianceRequirement.php) | `App\Models\ComplianceRequirement` | `2026_08_24_000001_create_dynamic_instrument_tables.php` | Program-specific compliance tasks. |
| [`accreditation_document_links`](../../app/Models/AccreditationDocumentLink.php) | `App\Models\AccreditationDocumentLink` | `2026_07_19_000000_create_iqarchive_core_tables.php` | Pivot linking uploaded evidence to requirements. |

---

## 2. Table Specifications & Hierarchy

```
Instrument (1)
 └── InstrumentArea (1..N)
      └── InstrumentParameter (1..N)
           └── InstrumentCriterion (1..N)
                └── ComplianceRequirement (1..N)
                     └── AccreditationDocumentLink (N..M) ── Document
```

### `instruments`
```sql
CREATE TABLE instruments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    document_id BIGINT UNSIGNED NULL REFERENCES documents(id) ON DELETE SET NULL,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(255) NOT NULL UNIQUE,
    accreditation_type VARCHAR(255) NOT NULL DEFAULT 'program', -- 'program', 'institutional'
    program_id BIGINT UNSIGNED NULL REFERENCES programs(id) ON DELETE SET NULL,
    accreditation_id BIGINT UNSIGNED NULL REFERENCES accreditations(id) ON DELETE SET NULL,
    is_template TINYINT(1) NOT NULL DEFAULT 1,
    level VARCHAR(255) NULL,
    version VARCHAR(255) NOT NULL DEFAULT '2026.1',
    status VARCHAR(255) NOT NULL DEFAULT 'active',
    created_by BIGINT UNSIGNED NULL REFERENCES users(id) ON DELETE SET NULL,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### `instrument_areas`, `instrument_parameters`, `instrument_criteria`
- **`instrument_areas`**: Stores Area name (e.g. *Vision, Mission, Goals, Objectives*), order (1..10), weight.
- **`instrument_parameters`**: Stores Parameter code (e.g. *Parameter A*), title, description, weight.
- **`instrument_criteria`**: Stores criterion code (e.g. `S.1`, `I.1`, `O.1`), section (`systems`, `implementation`, `outcomes`, `best_practices`), requirement statement, and `required_tags` JSON array.

### `compliance_requirements`
```sql
CREATE TABLE compliance_requirements (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    instrument_id BIGINT UNSIGNED NOT NULL REFERENCES instruments(id) ON DELETE CASCADE,
    instrument_criterion_id BIGINT UNSIGNED NULL REFERENCES instrument_criteria(id) ON DELETE SET NULL,
    program_id BIGINT UNSIGNED NOT NULL REFERENCES programs(id) ON DELETE CASCADE,
    accreditation_id BIGINT UNSIGNED NULL REFERENCES accreditations(id) ON DELETE CASCADE,
    description TEXT NULL,
    due_date DATETIME NULL,
    status VARCHAR(255) NOT NULL DEFAULT 'pending', -- 'pending', 'in_progress', 'complied', 'overdue'
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### `accreditation_document_links`
```sql
CREATE TABLE accreditation_document_links (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    document_id BIGINT UNSIGNED NOT NULL REFERENCES documents(id) ON DELETE CASCADE,
    compliance_requirement_id BIGINT UNSIGNED NOT NULL REFERENCES compliance_requirements(id) ON DELETE CASCADE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

---

## 3. Cloning & Lifecycle Mechanics

The `Instrument::cloneForProgram()` method performs a deep clone of master instrument templates when scheduling an accreditation cycle:
1. Clones all `InstrumentArea`, `InstrumentParameter`, and `InstrumentCriterion` records with `is_template = 0`.
2. Automatically generates corresponding `compliance_requirements` rows linked to the program and cycle.

---

## 4. Cross-Quadrant Links

- **Document Management Schema:** [Document Management Reference](./database-schema-document-management.md)
- **Role Reference:** [RBAC: Task Force Member](./rbac-task-force-member.md)
- **Role Reference:** [RBAC: IQA Staff](./rbac-iqa-staff.md)
