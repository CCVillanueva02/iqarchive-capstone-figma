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
- **Synchronous OCR Engine:** Inline text extraction dedicated to accreditation results (certificates and rating sheets of 1–3 pages) in 1.5–3 seconds
- **Access Control:** Acts as a gatekeeper — authorizes document streams and issues temporary 15-minute pre-signed URLs

**Key feature:** When an accreditation result is uploaded, it is stored in secure cloud storage while inline OCR extracts text and confidence metrics synchronously without queue worker overhead.

---

## **Tier 3: Data Storage + External Services**
**Technology:** Laravel Cloud Managed MySQL 8 + Managed Object Storage (S3) + Cloud Services

Where data lives and external tools connect:

### Database & Storage (The 4 Pillars)
- **Normalized Schema (Strict 3NF):** Stores all workflow data (stages, task assignments, AACCUP instruments)
- **JSON Columns:** Tracks per-word OCR confidence scores and page metrics on `ocr_results`
- **Audit Trail:** Immutable activity history recording all uploads, reviews, and stage transitions
- **Protected Storage (Private S3 Bucket):** 15-minute pre-signed URLs stream authorized documents directly to the desktop browser without overloading application memory

### External Services
- **Google Workspace SSO:** Users log in strictly with their institutional @bicol-u.edu.ph email
- **Cloud OCR Provider (Google Cloud Vision API):** High-accuracy text recognition natively aligned with Bicol University's Google ecosystem (with local Tesseract fallback for offline development)

---

## **Data Flow (How It Works)**

```
User logs in via Google SSO (@bicol-u.edu.ph)
        ↓
Tier 1 (Frontend) shows their role-scoped dashboard
        ↓
Task Force Member uploads an accreditation result PDF (1–3 pages)
        ↓
Tier 2 (Backend) saves PDF to private S3 bucket & executes ProcessDocumentOcrService synchronously (< 3s)
        ↓
Tier 3 (Database) stores extracted text + per-word confidence metrics in MySQL JSON columns
        ↓
Tier 1 (Frontend) immediately redirects to Split-Screen Canvas (PDF via Pre-Signed URL + OCR Text)
        ↓
User verifies, corrects flagged low-confidence words (< 0.65), and submits for Dean review
```

---

## **Why This Architecture?**

| Benefit | Why It Matters |
|---------|---|
| **Separation of Concerns** | Easy to maintain or upgrade OCR engines without altering the database schema |
| **Data Privacy & Security** | Multi-tenant college isolation, AES-256 encrypted storage, and expiring signed URLs (RA 10173 compliant) |
| **Lean & Responsive** | Synchronous OCR on short accreditation results eliminates complex queue workers while delivering instant feedback |
| **Institutional Synergy** | Google Cloud Vision API and Google SSO seamlessly leverage BU's enterprise Google Workspace |
| **Zero-Downtime PaaS** | Laravel Cloud provides automated point-in-time backups, health checks, and instant rollbacks |

---

## **Quick Summary for Panelists**

> IQArchive follows a **modern cloud 3-tier architecture**: users interact with a role-aware Inertia/Vue frontend featuring split-screen OCR validation → an authorized Laravel backend that enforces multi-tenant college isolation and runs synchronous OCR on accreditation results → and colocated managed MySQL + private S3 storage with Google Workspace SSO. Document access is secured through short-lived pre-signed URLs, and institutional identity is strictly bound to Google Workspace.