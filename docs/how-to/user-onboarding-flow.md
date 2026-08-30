# How-To: User Onboarding & Activation Flow

This practical guide walks through the end-to-end process of onboarding a new faculty member, dean, or accreditor into IQArchive using the pre-registration and Google SSO workflow.

---

## 1. Prerequisites

- The administrator must possess either the `system-administrator` or `iqa-staff` role.
- The new user must have an active official Bicol University email account (e.g. `@bicol-u.edu.ph`).

---

## 2. Step-by-Step Onboarding Recipe

### Step 1: Pre-Register the Account
1. Log into IQArchive as an Administrator or IQA Staff member.
2. Navigate to **User Management** (`/system-admin/accounts` or `/iqa/accounts`).
3. Click **Add User / Pre-Register**.
4. Fill in the required metadata:
   - **Institutional Email:** `faculty.name@bicol-u.edu.ph`
   - **Primary Role:** Select appropriate role (`task-force-member`, `college-head`, etc.).
   - **College / Program:** Assign parent college and degree program.
   - **Initial Status:** Set to `pending_activation`.
5. Submit the form. The system creates the user record with placeholder values (`first_name: 'Pending'`, `last_name: 'User'`).

---

### Step 2: First-Time User Login via Google SSO
1. Notify the user to navigate to the IQArchive login page (`/login`).
2. The user clicks **Sign in with Google**.
3. The user authenticates with their official institutional Google account.

---

### Step 3: Automated Activation & Token Sanitization
When Google redirects back to `/auth/google/callback`, [`GoogleAuthController`](../../app/Http/Controllers/GoogleAuthController.php) automatically executes:

1. **Domain Verification:** Validates that the email domain matches `ALLOWED_EMAIL_DOMAINS` (`bicol-u.edu.ph`).
2. **Account Linking:** Binds the user's permanent `google_id` and profile avatar.
3. **Status Promotion:** Promotes `status` from `'pending_activation'` to `'active'` and stamps `email_verified_at = now()`.
4. **Name Sanitization:** Extracts given/family names from Google while automatically stripping institutional ID digits (e.g. `Jcmm2023 Santos` $\rightarrow$ `Santos`).
5. **Audit Trail:** Dispatches a `GOOGLE_LOGIN` record to the system audit log.

---

### Step 4: Role-Specific Dashboard Landing
Upon successful authentication, the `/dashboard` gateway immediately redirects the user to their designated workspace:
- **IQA Staff:** `/dashboard/iqa-staff`
- **College Head (Dean):** `/dashboard/college-head`
- **Accreditor:** `/submissions/accreditor`
- **BU Executive:** `/analytics/university-administrator`
- **Task Force Member:** `/dashboard/task-force`

---

## 3. Troubleshooting Common Errors

| Error Message | Root Cause | Solution |
| :--- | :--- | :--- |
| *"Access is restricted to official @bicol-u.edu.ph accounts."* | User signed in with a personal Gmail account. | Instruct user to sign out of Google and select their institutional account. |
| *"Your account has not been pre-registered."* | Email is not present in `users` table. | Administrator must pre-register the email before login. |
| *"Your account has been deactivated."* | Account status is `inactive` or `revoked`. | Administrator must reactivate the account in User Management. |

---

## 4. Cross-Quadrant Links

- **Technical Reference:** [Google SSO Authentication Flow](../reference/auth-google-sso.md)
- **Role Reference:** [RBAC: System Administrator](../reference/rbac-system-administrator.md)
- **Schema Reference:** [Authentication & Security Schema](../reference/database-schema-auth-security.md)
