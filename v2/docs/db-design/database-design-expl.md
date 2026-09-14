# IQArchive Database Schema Explained

## Overview
The database is organized into **5 logical groups** — each group handles a different part of the accreditation workflow.

---

## **Group 1: Users & Access Control** (Blue)
**Tables:** `roles`, `user_roles`, `users`, `notifications`, `audit_logs`

**What it does:**
- Stores **who can access the system** (7 roles: IQA Staff, Dean, Task Force Member, etc.)
- Tracks **which users have which roles**
- Records **who did what and when** (audit trail for compliance)
- Delivers **notifications** to users (task assignments, stage changes, etc.)

**Why it matters:** Ensures only authorized people see and modify accreditation data.

---

## **Group 2: Accreditation Pipeline & Task Forces** (Red/Orange)
**Tables:** `task_forces`, `task_force_members`, `accreditations`, `accreditation_stage_histories`

**What it does:**
- Defines **which users are on which task force** (auto-assigned by program)
- Tracks the **9-stage accreditation journey** for each program
- Records **every stage transition** (who moved it, when, why)
- Logs **stage approvals and rejections** with timestamps

**How it works:**
```
Program → Accreditation Record → 9 Stages → Stage History
                                    ↓
                            Task Force Members
                            (assigned per stage)
```

**Why it matters:** This is the backbone — it orchestrates the entire workflow.

---

## **Group 3: Documents & OCR Processing** (Purple)
**Tables:** `documents`, `ocr_results`, `document_reviews`, `document_categories`

**What it does:**
- Stores **uploaded evidence files** (PDFs, images, spreadsheets)
- Captures **OCR results** — extracted text, confidence scores, raw + edited text
- Tracks **human verification** of OCR (user confirms or corrects the extraction)
- Categorizes documents (e.g., "Curriculum", "Faculty Qualifications")

**The OCR flow:**
```
PDF Uploaded
    ↓
Tesseract extracts text → stored in ocr_results
    ↓
System shows confidence score
    ↓
User reviews & approves (or edits) → stored as verified
    ↓
Ready for accreditation review
```

**Why it matters:** Evidence is the foundation of accreditation — OCR speed + human verification builds confidence.

---

## **Group 4: Accreditation Instruments** (Green)
**Tables:** `instruments`, `instrument_criteria`, `instrument_areas`, `instrument_parameters`

**What it does:**
- Defines **what the accreditors will assess** (AACCUP criteria)
- Breaks criteria into **sub-questions** (e.g., "Does curriculum align with mission?")
- Links **compliance evidence** to each criterion
- Tracks **compliance comments** from reviewers

**Structure:**
```
Instrument (e.g., AACCUP 2024)
  ├─ Instrument Areas (e.g., "Faculty")
  │   ├─ Instrument Criteria (e.g., "Qualification")
  │   │   └─ Instrument Parameters (e.g., "PhD count")
```

**Why it matters:** This is the **"grading rubric"** — accreditors use this to evaluate programs fairly.

---

## **Group 5: Compliance & Linking** (Center/Mixed)
**Tables:** `compliance_requirements`, `compliance_comments`, `accreditation_document_links`

**What it does:**
- Maps **which documents satisfy which criteria**
- Records **accreditor feedback** ("This criterion is met / not met")
- Links **evidence to compliance statements**

**Example:**
```
Criterion: "Faculty have advanced degrees"
  ↓
Evidence (Document): Faculty roster PDF
  ↓
Compliance Comment: "All faculty have PhD or Master's ✓"
  ↓
Status: COMPLIANT
```

**Why it matters:** Closes the loop — connects documents to accreditor judgments.

---

## **The Complete Workflow**

```
User logs in
    ↓
Assigned to Task Force for Program
    ↓
Accreditation moves to Stage X (tracked in accreditation_stage_histories)
    ↓
User uploads evidence documents (stored in documents table)
    ↓
System extracts text via OCR (ocr_results)
    ↓
User reviews extraction, system asks "Is this compliant with criterion?"
    ↓
Compliance linked (accreditation_document_links → compliance_requirements)
    ↓
Accreditor reviews comments & evidence
    ↓
Stage transitions to next phase
    ↓
Audit log records every change
```

---

## **Key Design Decisions**

| Design Choice | Why It Matters |
|---|---|
| **OCR Results Separate** | Preserve original extraction + allow user edits without losing raw data |
| **Stage Histories** | Immutable audit trail — can't erase who approved what or when |
| **Task Force Members Pivot** | Flexible role assignment per program (same person could be lead on one, member on another) |
| **Compliance Links** | Decoupled documents from criteria — one document can satisfy multiple criteria |
| **Audit Logs** | Accreditors need proof that nothing was modified after submission |

---

## **Quick Summary for Panelists**

> The schema reflects the **accreditation lifecycle**: Users are assigned to Task Forces → Programs move through 9 Stages → Evidence is uploaded and OCR-extracted → Compliance links evidence to AACCUP criteria → Accreditors review and provide feedback → Everything is immutably logged. Each table group is isolated enough to scale independently, but connected through foreign keys to maintain data integrity.

---

## **Database Stats**
- **~25 tables** managing 126 programs across 7 colleges
- **JSON columns** for flexible metadata (OCR confidence metrics, stage remarks)
- **Audit trail** on every write operation (immutable compliance requirement)
- **Multi-tenant** — college-level isolation enforced at the application layer