# Database Schema: Document Management & Access Control

This reference document details the schema for document storage, OCR validations, multi-tiered review workflows, and access control.

---

## 1. Tables Overview

| Table | Model | Migration Source | Purpose |
| :--- | :--- | :--- | :--- |
| [`document_categories`](../../app/Models/DocumentCategory.php) | `App\Models\DocumentCategory` | `2026_07_19_000000_create_iqarchive_core_tables.php` | Document taxonomy and categorization. |
| [`documents`](../../app/Models/Document.php) | `App\Models\Document` | `2026_07_19_000000...`, `2026_08_18_141907...` | Core metadata record for uploaded PDFs. |
| [`document_ocr_validations`](../../app/Models/DocumentOCRValidation.php) | `App\Models\DocumentOCRValidation` | `2026_07_19_000000_create_iqarchive_core_tables.php` | Optical character recognition text extraction. |
| [`document_reviews`](../../app/Models/DocumentReview.php) | `App\Models\DocumentReview` | `2026_07_19_000000_create_iqarchive_core_tables.php` | Approval and rejection audit decisions. |
| [`document_access_requests`](../../app/Models/DocumentAccessRequest.php) | `App\Models\DocumentAccessRequest` | `2026_07_19_000000_create_iqarchive_core_tables.php` | Temporary access grants for restricted files. |

---

## 2. Table Specifications

### `documents`
Core metadata record storing physical file location, uploader ownership, and approval status.

```sql
CREATE TABLE documents (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uploaded_by BIGINT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    program_id BIGINT UNSIGNED NULL REFERENCES programs(id) ON DELETE SET NULL,
    office_id BIGINT UNSIGNED NULL REFERENCES offices(id) ON DELETE SET NULL,
    category_id BIGINT UNSIGNED NOT NULL REFERENCES document_categories(id) ON DELETE RESTRICT,
    confirmed_by BIGINT UNSIGNED NULL REFERENCES users(id) ON DELETE SET NULL,
    confirmed_at TIMESTAMP NULL,
    title VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    status VARCHAR(255) NOT NULL DEFAULT 'pending',       -- 'pending', 'approved', 'rejected'
    visibility VARCHAR(255) NOT NULL DEFAULT 'restricted', -- 'public', 'restricted'
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### `document_ocr_validations`
Stores automated OCR text extraction results and parsed keyword data.

```sql
CREATE TABLE document_ocr_validations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    document_id BIGINT UNSIGNED NOT NULL REFERENCES documents(id) ON DELETE CASCADE,
    validated_by BIGINT UNSIGNED NULL REFERENCES users(id) ON DELETE SET NULL,
    extracted_data LONGTEXT NULL,
    validated_at TIMESTAMP NULL,
    validation_status VARCHAR(255) NOT NULL DEFAULT 'pending', -- 'pending', 'validated', 'failed'
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### `document_reviews`
Immutable audit log of review decisions performed by IQA personnel.

```sql
CREATE TABLE document_reviews (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    document_id BIGINT UNSIGNED NOT NULL REFERENCES documents(id) ON DELETE CASCADE,
    reviewed_by BIGINT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    decision VARCHAR(255) NOT NULL,                           -- 'approved', 'rejected'
    remarks TEXT NULL,
    reviewed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### `document_access_requests`
Manages time-bounded access requests for restricted documents by external accreditors.

```sql
CREATE TABLE document_access_requests (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    document_id BIGINT UNSIGNED NOT NULL REFERENCES documents(id) ON DELETE CASCADE,
    requested_by BIGINT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    status VARCHAR(255) NOT NULL DEFAULT 'pending',           -- 'pending', 'approved', 'rejected'
    remarks TEXT NULL,
    approved_by BIGINT UNSIGNED NULL REFERENCES users(id) ON DELETE SET NULL,
    approved_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

---

## 3. Security & Storage Architecture

- **Storage Isolation:** Uploaded PDF files are stored on Laravel's configured disk under `public/documents/` with sanitized, non-predictable UUID/timestamp paths.
- **Audit Logging via Observers:** Document creation, update, approval, rejection, and deletion automatically trigger `AuditLog` records via Eloquent model listeners configured in `AppServiceProvider`.
- **Visibility Gates:** Documents marked `restricted` require active Task Force membership or an approved, non-expired `DocumentAccessRequest`.

---

## 4. Cross-Quadrant Links

- **Role Reference:** [RBAC: IQA Staff](./rbac-iqa-staff.md)
- **Role Reference:** [RBAC: Accreditor](./rbac-accreditor.md)
- **Architecture Reference:** [System Architecture Overview](./architecture-overview.md)
