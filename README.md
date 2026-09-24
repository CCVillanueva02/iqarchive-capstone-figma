# IQArchive — Bicol University Accreditation Management System

**IQArchive** is an institutional document management and compliance monitoring system built for Bicol University to streamline accreditation surveys conducted by the Accrediting Agency of Chartered Colleges and Universities in the Philippines (AACCUP).

---

## 📌 Project Architecture & Documentation

The active codebase is maintained in the [`v2/`](v2/) workspace:

- **[Developer Onboarding & Setup Guide](v2/README.md):** Complete workstation requirements (PHP 8.4, Composer, Node.js, MySQL) and local setup instructions.
- **[Architecture Essentials](v2/docs/ARCHITECTURE-ESSENTIALS.md):** Architectural boundaries, 3NF schema zones, and multi-tenant scoping.
- **[Data Dictionary](v2/docs/db-design/data-dict/README.md):** Full 22-table data dictionary specifications across 4 schema zones.
- **[Engineering Backlog](v2/TODOS.md):** Prioritized roadmap and milestone tracking.

---

## 🛠️ Technology Stack

- **Backend:** Laravel 13 (PHP 8.4+)
- **Frontend:** Inertia.js + Vue 3 (Composition API)
- **Styling:** Tailwind CSS v4 + DaisyUI component library
- **Database:** MySQL 8 / SQLite (strict 3rd Normal Form)
- **Authentication:** Google Workspace OAuth 2.0 (restricted strictly to `@bicol-u.edu.ph` accounts)
- **Storage:** Private S3 Cloud Storage with temporary 15-minute signed URLs
- **OCR Pipeline:** Tesseract OCR with human-in-the-loop verification

---

## 👥 Core Contributors

- **Janssen Carl Marfil** (`@Janssen12`)
- **Carl Justine Tuazon** (`@j4j418`)
- **Vince Mathew** (`@Vince-Mathew`)
- **Cay02** (`@Cay02`)

---

## 📄 License

Proprietary academic capstone project for Bicol University.
