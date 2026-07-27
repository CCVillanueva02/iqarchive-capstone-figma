# IQArchive System Sequence Diagram

This sequence diagram incorporates all the entities, processes, and data stores identified in the DFD Level 1 you provided. Due to the scale of the system, all interactions are represented in a unified flow, grouped by typical user actions.

```mermaid
sequenceDiagram
    autonumber
    
    %% Actors
    actor SysAdmin as System Administrator
    actor IQAAdmin as IQA Admin
    actor IQAMember as IQA Member
    actor DeptHead as College / Dept Head
    actor TaskForce as Task Force
    actor UnivAdmin as Univ Admin / Executives
    actor Accreditor as Accreditor

    %% Processes
    participant Auth as 1.0 User Auth & Access
    participant DocProcess as 2.0 Doc Submission
    participant DocReview as 3.0 Doc Review
    participant AccessMgmt as 4.0 Access Mgmt
    participant Monitor as 5.0 Monitoring & Compliance
    participant Notify as 6.0 Notification Mgmt
    
    %% Data Stores
    participant DB as Data Stores (D1-D7)

    %% ----------------------------------------------------
    %% User Authentication and Access Management
    %% ----------------------------------------------------
    rect rgb(240, 248, 255)
    Note over SysAdmin, DB: Account Setup & Management
    SysAdmin->>Auth: System & Initial Setup
    Auth->>DB: Store User Data (D1)
    
    IQAAdmin->>Auth: Login Credentials
    Auth-->>IQAAdmin: Access Granted
    IQAAdmin->>Auth: Create / Revoke / Edit Account Actions
    Auth->>DB: Update User (D1) & AuditLog (D7)
    Auth-->>IQAAdmin: Account Update Confirmation
    end

    %% ----------------------------------------------------
    %% Document Submission
    %% ----------------------------------------------------
    rect rgb(255, 245, 238)
    Note over DeptHead, DB: Document Upload Phase
    DeptHead->>Auth: Login Credentials
    Auth-->>DeptHead: Access Granted
    DeptHead->>DocProcess: Document Upload for OCR
    DocProcess->>DB: Store Document (D2) & AuditLog (D7)
    DocProcess-->>DeptHead: Submission Confirmation
    end

    %% ----------------------------------------------------
    %% Document Review and Verification
    %% ----------------------------------------------------
    rect rgb(240, 255, 240)
    Note over IQAMember, DB: Review & Verification Phase
    IQAMember->>Auth: Login Credentials
    Auth-->>IQAMember: Access
    IQAMember->>DocReview: Request Documents for Verification
    DocReview->>DB: Retrieve Document (D2)
    DB-->>DocReview: Document Data
    DocReview-->>IQAMember: Display Documents
    IQAMember->>DocReview: Document Review Action (Approve/Return/Deny)
    DocReview->>DB: Update DocumentReview (D3) & AuditLog (D7)
    DocReview->>Notify: Trigger Review Status Notification
    Notify->>DB: Store Notification (D6)
    Notify-->>DeptHead: Read Confirmation / Announcement Confirmation
    end

    %% ----------------------------------------------------
    %% Document Access Management
    %% ----------------------------------------------------
    rect rgb(255, 250, 240)
    Note over TaskForce, DB: Task Force Operations
    TaskForce->>Auth: Login Credentials
    Auth-->>TaskForce: Access
    TaskForce->>AccessMgmt: Faculty (Task Force) Access List Request
    AccessMgmt->>DB: Log DocumentAccessRequest (D4)
    AccessMgmt-->>TaskForce: Faculty (Task Force) Access List
    TaskForce->>DocProcess: Access Approved Documents for Task Force
    end

    %% ----------------------------------------------------
    %% Monitoring & Compliance Tracking
    %% ----------------------------------------------------
    rect rgb(245, 245, 245)
    Note over IQAAdmin, DB: System Monitoring
    IQAAdmin->>Monitor: Compliance Monitoring Request
    Monitor->>DB: Fetch MonitoringRecords (D5)
    DB-->>Monitor: Records Data
    Monitor-->>IQAAdmin: Compliance Reports & Notifications
    
    UnivAdmin->>Monitor: Request University Compliance Status
    Monitor->>DB: Fetch MonitoringRecords (D5)
    Monitor-->>UnivAdmin: Executive Compliance Reports
    end

    %% ----------------------------------------------------
    %% Notification & Accreditation
    %% ----------------------------------------------------
    rect rgb(253, 245, 230)
    Note over IQAAdmin, Accreditor: External Accreditation
    IQAAdmin->>Notify: Trigger Accreditation Notice
    Notify->>DB: Save Notification (D6)
    Notify-->>Accreditor: Accreditation Notice
    
    Accreditor->>Auth: Login Credentials
    Auth-->>Accreditor: Access Granted
    Accreditor->>AccessMgmt: Request Evidence/Documents
    AccessMgmt->>DB: Retrieve Document (D2) & Log Access (D7)
    AccessMgmt-->>Accreditor: Provide Verification Documents
    end
```
