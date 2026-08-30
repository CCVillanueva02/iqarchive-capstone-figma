# Database Schema: Self-Survey Subsystem

This reference document details the schema for the standalone institutional self-survey evaluation subsystem.

---

## 1. Tables Overview

| Table | Migration Source | Purpose |
| :--- | :--- | :--- |
| `self_survey_areas` | `2026_08_07_090000_create_self_survey_tables.php` | Top-level self-survey areas (Area I – IX). |
| `self_survey_parameters` | `2026_08_07_090000_create_self_survey_tables.php` | Parameters under self-survey areas. |
| `self_survey_indicators` | `2026_08_07_090000_create_self_survey_tables.php` | Evaluative indicator items grouped by section. |
| `self_survey_ratings` | `2026_08_07_090000_create_self_survey_tables.php` | Evaluator numerical scores per indicator. |

---

## 2. Table Specifications

### `self_survey_areas` & `self_survey_parameters`
Defines the structure for institutional survey evaluations.

```sql
CREATE TABLE self_survey_areas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(255) NOT NULL,
    label VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL DEFAULT 'institutional',
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE self_survey_parameters (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    area_id BIGINT UNSIGNED NOT NULL REFERENCES self_survey_areas(id) ON DELETE CASCADE,
    code VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    best_practices TEXT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### `self_survey_indicators` & `self_survey_ratings`
```sql
CREATE TABLE self_survey_indicators (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    parameter_id BIGINT UNSIGNED NOT NULL REFERENCES self_survey_parameters(id) ON DELETE CASCADE,
    section VARCHAR(255) NOT NULL,    -- 'system', 'implementation', 'outcome'
    code VARCHAR(255) NOT NULL,
    statement TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE self_survey_ratings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    indicator_id BIGINT UNSIGNED NOT NULL REFERENCES self_survey_indicators(id) ON DELETE CASCADE,
    rated_by BIGINT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    rating TINYINT UNSIGNED NULL,     -- 0 to 5, NULL = Not Applicable
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE(indicator_id, rated_by)
);
```

---

## 3. Architecture Note

> [!NOTE]
> The `self_survey_*` subsystem represents an earlier dedicated institutional evaluation module. For modern program accreditation cycles, IQArchive utilizes the [Dynamic Instruments](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-dynamic-instruments.md) module (`instruments`, `instrument_areas`, etc.).

---

## 4. Cross-Quadrant Links

- **Dynamic Instruments Schema:** [Dynamic Instruments Reference](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-dynamic-instruments.md)
- **Role Reference:** [RBAC: Task Force Member](file:///c:/Users/janss/Herd/iqarchive/docs/reference/rbac-task-force-member.md)
