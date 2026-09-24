# IQArchive Document Lifecycle & Review State Specification

## 1. Overview
In AACCUP accreditation preparation, every uploaded document (benchmark evidence, syllabi, board resolutions, annual reports) progresses through a multi-stage verification pipeline before inclusion in the final survey exhibit.

```text
[Draft] ---> [Submitted] ---> [Under Review] ---> [Approved]
                   |                 |
                   v                 v
           [Needs Revision]       [Deficit]
```

---

## 2. Document Status Definitions

| Status Code | Display Label | Semantic Role | Access Permissions |
| :--- | :--- | :--- | :--- |
| `draft` | **Draft** | Document uploaded by Task Force member; still undergoing local editing and metadata tagging. | Task Force Lead, Author |
| `submitted` | **Submitted** | Formal submission to Area Lead for initial compliance and completeness verification. | Task Force Lead, Area Chair |
| `under_review` | **Under Review** | Actively being examined against AACCUP benchmark criteria by Area Chair or IQA Staff. | Area Chair, IQA Staff, Dean |
| `needs_revision` | **Needs Revision** | Evidence returned to author due to illegibility, missing pages, or incomplete metadata. | Author, Area Chair |
| `approved` | **Approved** | Certified as valid accreditation evidence and locked against further modification. | Read-only to all roles; Lead Accreditor |
| `deficit` | **Deficit** | Document flagged by Accreditors as failing to satisfy benchmark requirements. | IQA Director, Dean, Task Force |

---

## 3. Transition Rules & Security Checks

1. **Immutability upon Approval:**
   - Once a document enters `approved` status, file replacements and deletions are strictly rejected by `DocumentPolicy`.
2. **Mandatory Comment on Revision Request:**
   - Moving a document from `under_review` to `needs_revision` requires a non-empty audit feedback entry.
3. **Tenancy Scope Enforcement:**
   - State transitions must verify that the requesting user's `college_id` matches the document's `college_id`.
