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
- **Document Processing:** Dispatches OCR jobs asynchronously to managed queue workers, keeping uploads responsive ($< 400$ms)
- **Access Control:** Acts as a gatekeeper — authorizes document streams and issues temporary pre-signed URLs

**Key feature:** When a document is uploaded, it is immediately stored in secure cloud storage while background workers extract text without freezing the browser or timing out.

---

## **Tier 3: Data Storage + External Services**
**Technology:** Laravel Cloud Managed MySQL 8 + Managed Object Storage (S3) + Cloud APIs

Where data lives and external tools connect:

### Database & Storage
- **Managed MySQL 8** stores all workflow data (stages, task assignments, audit history, OCR tokens)
- **Managed Object Storage (S3-Compatible)** stores all institutional documents and evidence files in private encrypted buckets
- **Pre-Signed URLs (15-Minute Expiration)** stream authorized documents directly to the client browser without overloading server memory
- **JSON fields** track per-word OCR confidence scores and page metrics

### External Integrations
- **Google Workspace SSO:** Users log in strictly with their institutional @bicol-u.edu.ph email
- **Cloud OCR Engine (Google Cloud Vision API):** High-accuracy text recognition natively aligned with Bicol University's Google ecosystem (with local Tesseract fallback for offline development)
- **Confidence Preview:** Flags low-confidence words ($< 0.65$) in a split-screen canvas before human approval

---

## **Data Flow (How It Works)**

```
User logs in via Google SSO (@bicol-u.edu.ph)
        ↓
Tier 1 (Frontend) shows their role-scoped dashboard
        ↓
User uploads an accreditation evidence PDF
        ↓
Tier 2 (Backend) saves PDF to private S3 bucket (< 400ms) & queues ProcessDocumentOcrJob
        ↓
Background Worker extracts text & token confidence scores via Cloud OCR
        ↓
Tier 3 (Database) stores extracted text + per-word confidence metrics in MySQL
        ↓
Tier 1 (Frontend) alerts user; opens Split-Screen Canvas (PDF via Pre-Signed URL + OCR Text)
        ↓
User verifies, corrects flagged low-confidence words (< 0.65), and submits for Dean review
```

---

## **Why This Architecture?**

| Benefit | Why It Matters |
|---------|---|
| **Separation of Concerns** | Easy to maintain or upgrade OCR engines without altering the database schema |
| **Data Privacy & Security** | Multi-tenant college isolation, AES-256 encrypted storage, and expiring signed URLs (RA 10173 compliant) |
| **High Reliability** | Background workers eliminate 504 gateway timeouts on multi-page accreditation packets |
| **Institutional Synergy** | Google Cloud Vision API and Google SSO seamlessly leverage BU's enterprise Google Workspace |
| **Zero-Downtime PaaS** | Laravel Cloud provides automated point-in-time backups, health checks, and instant rollbacks |

---

## **Quick Summary for Panelists**

> IQArchive follows a **modern cloud 3-tier architecture**: users interact with a role-aware Inertia/Vue frontend → an authorized Laravel backend that enforces multi-tenant college isolation and dispatches asynchronous background workflows → and colocated managed MySQL + private S3 storage with Google Cloud Vision OCR. Document access is secured through short-lived pre-signed URLs, and institutional identity is strictly bound to Google Workspace SSO.