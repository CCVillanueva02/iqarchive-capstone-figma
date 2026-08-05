# IQArchive System — Input and Output Screen Specifications

**System:** IQArchive — Document Management and Monitoring System  
**Organization:** Internal Quality Assurance (IQA) Office, Bicol University  

This document describes all input forms and output screens for IQArchive based on the system's Data Entry Procedures.

---

## System-Wide UI & Data Entry Standards

- **Dual-Layer Validation**: All input forms feature real-time client-side validation for instant user feedback, backed by authoritative server-side validation.
- **Error Display**: Failed validation displays field-level inline error messages directly below the offending inputs in red text. Inputs with errors are highlighted with red borders.
- **Data Protection**: All forms include CSRF protection, role-based Gate authorization checks, output HTML escaping to prevent XSS, and parameter binding to prevent SQL injection.
- **Atomic Writes**: Operations involving multiple records or file saves are executed within database transactions.

---

## 1. User Account Management

### 1.1. Add / Edit User (Input Screen)
- **Screen Type**: Modal Window / Form View (`UserFormModal`)
- **Authorized Roles**: System Administrator, IQA Admin
- **Purpose**: To provision user credentials, assign system roles, and set department scopes.
- **Layout & Structure**:
  - **Header**: "Add New User Account" or "Edit User Account: [User Name]".
  - **Form Fields**:
    - **Full Name**: Text input (`^[a-zA-Z\s.'-]+$`, 2–100 characters).
    - **Email Address**: Email input (RFC 5322 standard format). Validates uniqueness against the database on field exit.
    - **Password & Confirm Password**: Password inputs (shown during creation only). Includes a real-time password strength meter requiring 8+ characters, mixed case, numbers, and symbols.
    - **Role**: Dropdown selector (`System Admin`, `IQA Admin`, `IQA Member`, `Accreditor`, `University Admin`, `Task Force`, `College/Dept Head`).
    - **College/Department**: Dropdown selector. Dynamically renders as required when the selected role is `College/Dept Head`, `Program Chair`, or `IQA Member`.
    - **Account Status**: Toggle switch (`Active` / `Inactive`, defaults to `Active`).
- **Submit Action**: "Save User Account" button with a loading indicator. On success, a confirmation toast appears and the list refreshes.

### 1.2. User Directory & Management (Output Screen)
- **Screen Type**: Datatable View (`UserManagementDirectory`)
- **Authorized Roles**: System Administrator, IQA Admin
- **Purpose**: To view, search, filter, and manage all registered system accounts.
- **Layout & Structure**:
  - **Filter Controls**: Search bar (matches Name/Email), Role dropdown filter, College dropdown filter, Status filter (`Active`/`Inactive`), and an "Add User" action button.
  - **Table Columns**:
    1. **User Details**: User avatar, Full Name, and Email Address.
    2. **Role**: Color-coded badge (e.g., Purple for IQA Admin, Blue for System Admin, Green for Dept Head).
    3. **College/Department**: Displayed college code (e.g., `CEDU`, `CS`) or "System-Wide".
    4. **Status**: Green pill for `Active`, Gray pill for `Inactive`.
    5. **Actions**: `Edit` (opens Edit User modal), `Deactivate`/`Reactivate` toggle button.
  - **Footer**: Pagination controls and total active/inactive count summary.

---

## 2. College / Department Management

### 2.1. Add / Edit College (Input Screen)
- **Screen Type**: Compact Modal (`CollegeFormModal`)
- **Authorized Roles**: System Administrator, IQA Admin
- **Purpose**: To register academic colleges and departments for system scoping.
- **Layout & Structure**:
  - **College Name**: Text input (3–150 characters, unique).
  - **College Code**: Text input (Alphanumeric, 2–10 characters). Automatically converts characters to uppercase as typed (e.g., `cedu` $\rightarrow$ `CEDU`).
- **Submit Action**: "Save College" button.

### 2.2. College Directory (Output Screen)
- **Screen Type**: Card Grid & List View (`CollegeDirectoryView`)
- **Authorized Roles**: System Administrator, IQA Admin
- **Purpose**: To browse all university colleges and view metrics.
- **Layout & Structure**:
  - **Grid Cards**: Displaying College Code badge, Full College Name, Total Assigned Users count, Total Uploaded Documents count, and an `Edit` action button.

---

## 3. Document Management

### 3.1. Upload / Edit Document (Input Screen)
- **Screen Type**: Upload Modal / Form Page (`DocumentUploadModal`)
- **Authorized Roles**: IQA Admin, IQA Member, College/Dept Head, Program Chair
- **Purpose**: To upload accreditation-related documents and capture metadata for indexing and OCR processing.
- **Layout & Structure**:
  - **File Drag-and-Drop Zone**: Accepts PDF, DOCX, XLSX, JPG, PNG up to 25 MB. Performs client-side MIME type and size checks.
  - **Document Title**: Text input (3–255 characters).
  - **Category / Type**: Dropdown (`Policy`, `Manual`, `Report`, `Certificate`, `Other`).
  - **College / Program**: Dropdown selector. Locked to the uploader's assigned college unless logged in as IQA Admin.
  - **Description / Remarks**: Textarea (Optional, max 500 characters with live character counter).
  - **Duplicate Title Detection Banner**: Displays an informational message if a document with the same title exists: *"A document titled '[Title]' already exists in this college. Saving will create Revision v[N+1]."*
- **Submit Action**: "Upload & Process Document" button. Triggers background Tesseract OCR text extraction.

### 3.2. Document Repository & Detail Inspector (Output Screen)
- **Screen Type**: Searchable Repository Table & Side-Drawer Inspector (`DocumentRepository`)
- **Authorized Roles**: All authenticated roles (content scoped by user permissions)
- **Purpose**: To search, preview, verify, and track document revision histories.
- **Layout & Structure**:
  - **Top Controls**: Search input (supports OCR full-text search), Category filter, College filter, Status filter (`Draft`, `Submitted`, `Approved`, `Archived`), Date range picker.
  - **Repository Table Columns**: Document Title, Category, College Code, Version (e.g., `v1.0`), Status Badge, Upload Date, and `Inspect` button.
  - **Detail Inspector Drawer**:
    - **Document Previewer**: Embedded PDF/Image view pane.
    - **OCR Extracted Text Panel**: Collapsible drawer displaying raw extracted text.
    - **Version History Timeline**: List of past revisions (`v1.0`, `v2.0`) with download links.
    - **Audit Log Snippet**: Timestamps and names of uploaders and reviewers.
    - **Workflow Actions**: `Approve`, `Return for Revision`, `Reject` buttons (visible to IQA Members/Admins).

---

## 4. Instrument Management

### 4.1. Add / Edit Instrument (Input Screen)
- **Screen Type**: Form Modal (`InstrumentFormModal`)
- **Authorized Roles**: IQA Admin, IQA Member
- **Purpose**: To register accreditation instruments, checklists, and rubrics.
- **Layout & Structure**:
  - **Instrument Name**: Text input (3–150 characters).
  - **Instrument Type**: Dropdown (`Survey`, `Checklist`, `Rubric`, `Other`).
  - **Effectivity Date**: Calendar datepicker.
  - **File Attachment**: PDF or DOCX file upload (Max 25 MB).
  - **Description**: Textarea (Max 500 characters).
- **Submit Action**: "Save Instrument" button.

### 4.2. Instrument Library (Output Screen)
- **Screen Type**: Card Library & Table View (`InstrumentLibrary`)
- **Authorized Roles**: All authenticated roles
- **Purpose**: To view and download official accreditation instruments.
- **Layout & Structure**:
  - **Instrument Cards**: Displaying Instrument Name, Type Badge, Effectivity Date, Description, Direct File Download button, and Linked Requirements Count.

---

## 5. Compliance Report Management

### 5.1. Submit Compliance Report (Input Screen)
- **Screen Type**: Form Page (`SubmitComplianceReportForm`)
- **Authorized Roles**: IQA Member, College/Dept Head, Program Chair
- **Purpose**: To record program compliance status against a document or instrument.
- **Layout & Structure**:
  - **Context Banner**: Auto-filled read-only fields showing Submitter College Name and Server Timestamp.
  - **Related Document**: Searchable dropdown showing documents belonging to the user's college.
  - **Compliance Status**: Dropdown (`Compliant`, `Non-Compliant`, `For Revision`).
  - **Remarks / Findings**: Textarea. **Dynamically required (min 10 chars)** when Status is set to `Non-Compliant` or `For Revision`.
- **Submit Action**: "Submit Compliance Report" button.

### 5.2. Compliance Monitoring Dashboard & Report Inspector (Output Screen)
- **Screen Type**: High-Level Dashboard & Inspection Table (`ComplianceMonitoringDashboard`)
- **Authorized Roles**: All authenticated roles (views tailored by role)
- **Purpose**: To monitor compliance progress across colleges and programs.
- **Layout & Structure**:
  - **Summary Cards**: Overall Compliance Rate %, Total Compliant Items, Total Deficiencies (`Non-Compliant`), Total Pending Revisions.
  - **College Progress Bars**: Visual bar charts showing percentage completion for each college.
  - **Report Table**: Filterable list of reports showing College, Related Document, Status Badge (Green = Compliant, Red = Non-Compliant, Yellow = For Revision), Submission Date, and `View Details` action.

---

## 6. Task Force Management

### 6.1. Create Task Force (Input Screen)
- **Screen Type**: Form Modal (`TaskForceCreateModal`)
- **Authorized Roles**: IQA Admin, University Administrator/Executive
- **Purpose**: To assemble task forces for specific college accreditation tasks.
- **Layout & Structure**:
  - **Task Force Name**: Text input (3–150 characters, unique).
  - **Assigned College/Program**: Dropdown selector.
  - **Members Selection**: Multi-select searchable list of active user accounts. Requires at least 1 member.
  - **Purpose / Mandate**: Textarea (Max 500 characters).
- **Submit Action**: "Create Task Force" button. Multi-select assignments save atomically.

### 6.2. Task Force Overview & Roster (Output Screen)
- **Screen Type**: Task Force Dashboard (`TaskForceOverview`)
- **Authorized Roles**: All authenticated roles
- **Purpose**: To view task force members, mandates, and linked accreditation progress.
- **Layout & Structure**:
  - **Task Force Cards**: Displaying Task Force Name, Assigned College, Purpose, Member Avatars, Assigned Accreditation Area, and Progress Meter.

---

## 7. Accreditation Submission

### 7.1. New Accreditation Package Submission (Input Screen)
- **Screen Type**: Submission Form (`AccreditationPackageForm`)
- **Authorized Roles**: IQA Admin, College/Dept Head, Program Chair
- **Purpose**: To compile and submit supporting documents for program accreditation areas.
- **Layout & Structure**:
  - **Program Name**: Dropdown of active academic programs under the college.
  - **Area / Parameter**: Dropdown list of accreditation areas (e.g., *Area I: Vision, Mission, Goals*).
  - **Related Documents Selection**: Multi-select checkbox table displaying approved documents uploaded by that college. At least 1 document must be selected.
- **Submit Action**: "Submit Accreditation Package" button.

### 7.2. Accreditation Evidence Viewer (Output Screen)
- **Screen Type**: Split-Screen Reviewer View (`AccreditationEvidenceViewer`)
- **Authorized Roles**: Accreditor, IQA Admin, University Admin
- **Purpose**: To allow Accreditors to review submitted evidence packages per area/parameter.
- **Layout & Structure**:
  - **Left Pane (Area Navigation Tree)**: Expandable tree view of Accreditation Areas (Areas I–X) and Parameters.
  - **Right Pane (Evidence Document Grid)**: List of linked supporting documents for the selected parameter, with embedded PDF viewing, OCR text inspection, and evaluator feedback note tools.

---

## 8. Login and Password Reset

### 8.1. Login & Forgot Password (Input Screen)
- **Screen Type**: Authentication Cards (`LoginForm`, `PasswordResetForm`)
- **Authorized Roles**: All users (Self-service)
- **Purpose**: Authenticates users and initiates password recovery.
- **Layout & Structure**:
  - **Login Form**: Email input, Password input, "Sign in with Google" button, "Remember Me" checkbox, and "Forgot Password?" link.
  - **Rate-Limiting Feedback**: Displays a rate-limit lockout message after 5 consecutive failed attempts.
  - **Generic Error Messaging**: Shows generic message *"These credentials do not match our records"* on failure to prevent account enumeration.
  - **Password Reset Form**: New Password and Confirm New Password inputs (enforces 8+ chars, uppercase, lowercase, number, symbol rule).

### 8.2. Role-Based Landing Dashboard (Output Screen)
- **Screen Type**: Post-Login Home Screen
- **Authorized Roles**: All users
- **Purpose**: Directs users to their primary workspace based on role.
- **Layout & Structure**:
  - **System Admin**: System User Summary, Server Health, Audit Log Activity Feed.
  - **IQA Admin / Member**: Document Review Queue, Overall Compliance Rate, Recent Submissions.
  - **College/Dept Head**: Department Upload Quick-Link, Program Compliance Progress Bars, Pending Revisions.
  - **Accreditor**: Assigned Accreditation Schedule, Evidence Package Links.

---

## 9. System-Generated Records (System Outputs)

### 9.1. Notification Center (Output Screen)
- **Screen Type**: Top Navigation Slide-over Drawer & Full List Page (`NotificationDrawer`)
- **Authorized Roles**: All authenticated users
- **Purpose**: Displays system alerts (submission updates, review status changes, task force assignments).
- **Layout & Structure**:
  - **Notification Item**: Unread indicator badge, Event Title, Relative Timestamp (e.g., "5 minutes ago"), Message Snippet, and a direct link to the affected record.

### 9.2. System Audit Log (Output Screen)
- **Screen Type**: Read-Only Datatable & JSON Diff Inspector (`AuditLogViewer`)
- **Authorized Roles**: System Administrator, IQA Admin (scoped)
- **Purpose**: Provides an unalterable audit trail for system activity.
- **Layout & Structure**:
  - **Filters**: Search by Actor Name/Email, Action Type filter (`CREATE`, `UPDATE`, `DELETE`, `LOGIN`), Date range filter.
  - **Audit Table Columns**: Timestamp, Acting User, Role, Action Type Badge, Target Entity & ID, IP Address, and `View Details` action.
  - **JSON Diff Modal**: Pop-up window displaying exact before-and-after attribute values for modified records.
