# IQArchive System Architecture

## Overview
IQArchive is built on a **3-tier architecture** — think of it as three layers working together:

---

## **Tier 1: What Users See (Frontend)**
**Technology:** Inertia.js + Vue 3 + Tailwind CSS

The interface your users interact with. It's designed to:
- Adapt to **each user's role** (IQA Staff, Dean, Accreditor, etc.)
- Show a **live AACCUP accreditation tree** and linked documents
- Preview **scanned PDFs side-by-side** with extracted text
- Handle **OCR previews** so users see exactly what text was extracted

**Key feature:** The layout automatically changes based on who's logged in — a Dean sees different tools than an Internal Accreditor.

---

## **Tier 2: The Brain (Backend)**
**Technology:** Laravel 13 MVC + PHP

The engine that powers everything:
- **Security:** Enforces strict college isolation (each college's data is locked down)
- **Accreditation Pipeline:** Manages all 9 stages of the AACCUP preparation workflow
- **Document Processing:** Runs OCR extraction instantly when documents are uploaded
- **Access Control:** Acts as a gatekeeper — users only see what their role allows

**Key feature:** When a document is uploaded, OCR happens automatically and instantly.

---

## **Tier 3: Data Storage + External Services**
**Technology:** MySQL 8 + Local Disk + Cloud APIs

Where data lives and external tools connect:

### Database & Storage
- **MySQL 8** stores all workflow data (stages, task assignments, audit history)
- **Protected Local Disk** keeps all student documents and evidence files secure on-premises
- **JSON fields** track OCR confidence metrics and extracted text

### External Integrations
- **Google Workspace SSO:** Users log in with their @bicol-u.edu.ph email
- **Tesseract OCR:** Free, self-hosted text extraction engine
- **Confidence Preview:** Shows users how confident the OCR was before they finalize

---

## **Data Flow (How It Works)**

```
User logs in via Google
        ↓
Tier 1 (Frontend) shows their role-specific dashboard
        ↓
User uploads a document
        ↓
Tier 2 (Backend) instantly runs OCR
        ↓
Tier 3 (Database) stores the extracted text + confidence scores
        ↓
Tier 1 (Frontend) displays the extracted text with warnings if confidence is low
        ↓
User verifies or corrects the text
```

---

## **Why This Architecture?**

| Benefit | Why It Matters |
|---------|---|
| **Separation of Concerns** | Easy to fix bugs or add features without breaking everything |
| **Security** | Multi-tenant college isolation + role-based access control |
| **Self-Hosted** | All data stays on-premises (no vendor lock-in) |
| **Real-Time OCR** | Documents are processed instantly, not in batch jobs |
| **Scalability** | Each tier can be optimized independently |

---

## **Quick Summary for Panelists**

> IQArchive follows a **proven 3-tier design**: users interact with a smart, role-aware frontend → a Laravel backend that enforces security and runs workflows → and a local database + OCR engines that process documents in real-time. Everything is on-premises and SSO-protected.