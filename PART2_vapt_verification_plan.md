# Part 2 - VAPT Verification Plan: IQArchive Capstone

This Vulnerability Assessment and Penetration Testing (VAPT) plan specifically targets the security controls designed in **Module A (Identity & Access Fortification)** and **Module B (Cryptographic Data Protection)** for the IQArchive system.

---

## 3.1 VAPT Test Plan

**Scanners to be Used and Justification:**
- **Burp Suite Professional (or Community Edition):** Chosen as the primary interception proxy and dynamic application security testing (DAST) tool. It is ideal for manipulating HTTP requests to test the RBAC matrix (e.g., swapping session cookies between roles) and attempting to bypass the TOTP verification flow.
- **OWASP ZAP (Zed Attack Proxy):** Used as an automated scanner to crawl the application and identify missing security headers (like HSTS and CSP designed in Module B) and flag weak session configurations.
- **SSL Labs (Qualys) / testssl.sh:** A specialized scanner utilized specifically to verify the TLS 1.3 configuration, cipher suite strengths, and the correct deployment of HSTS, directly testing the perimeter defense designed in Module B.

**Scope:**
- **Endpoints:** All authentication and MFA endpoints (`/api/login`, `/api/mfa/setup`, `/api/mfa/verify`, `/api/mfa/challenge`), as well as document upload/delete endpoints and profile viewing endpoints (where PII is accessed).
- **Network Segments:** The external-facing web application layer (HTTPS/443). The internal database segment is out of scope for the external VAPT, but the application's handling of encrypted data at rest (Module B) will be verified through endpoint responses.
- **Roles in Scope:** Faculty Member, IQA Admin, and Accreditor accounts will be provisioned for testing.

**Expected Finding Categories:**
- Missing or misconfigured Security Headers (e.g., CSP missing directives).
- Broken Object Level Authorization (BOLA/IDOR) if RBAC is improperly enforced on document access.
- Weak Session Management (e.g., sessions not invalidated after MFA setup or password changes).
- Rate Limiting vulnerabilities on the TOTP challenge endpoint (allowing brute-force attacks).

---

## 3.2 Manual Test-Case Write-Ups

### Test Case 1: TOTP Replay and Brute Force Attack (Targets Module A)
**Objective:** Verify that the system prevents an attacker from reusing a previously intercepted TOTP code (Replay Attack) or brute-forcing the 6-digit code on the MFA challenge endpoint.
**Method:** 
1. Log into the application using valid credentials to reach the MFA challenge screen.
2. Intercept the `/api/mfa/challenge` request using Burp Suite.
3. Submit a valid TOTP code and capture the successful response.
4. Attempt to resubmit the exact same TOTP code immediately after the first success (Replay attempt).
5. Next, use Burp Intruder to send 1,000 rapid requests with sequential 6-digit codes to the challenge endpoint (Brute-force attempt).
**Tools:** Burp Suite (Proxy and Intruder module).
**Success Criteria:** The system must reject the replayed code with an error (e.g., "Code already used"). The brute-force attempt must be blocked by rate-limiting (HTTP 429 Too Many Requests) or account lockout after a predefined number of failed attempts (e.g., 5 attempts).

### Test Case 2: Vertical Privilege Escalation via RBAC Bypass (Targets Module A & B)
**Objective:** Ensure that a lower-privileged user (`faculty-member`) cannot access or modify resources designated for a higher-privileged user (`iqa-admin`), specifically targeting sensitive encrypted PII fields and accreditation folders.
**Method:**
1. Log into the application as an `iqa-admin` and capture a valid request for a restricted action (e.g., `DELETE /api/folders/12` or `GET /api/profiles/all` which returns decrypted PII).
2. Log out and log back in as a `faculty-member`.
3. Intercept a benign request from the `faculty-member` using Burp Suite.
4. Modify the HTTP method and URI to match the restricted action captured in Step 1, using the `faculty-member`'s session token/cookie.
5. Forward the manipulated request to the server.
**Tools:** Burp Suite (Repeater module).
**Success Criteria:** The server must return an HTTP 403 Forbidden or HTTP 401 Unauthorized status. The action must not be executed, proving that the RBAC matrix strictly verifies permissions on the server side regardless of hidden UI elements.

---

## 3.3 Risk Matrix

This matrix maps anticipated vulnerabilities from the VAPT plan to their Likelihood and Impact, along with the specific mitigating controls designed in Part 1.

| Anticipated Vulnerability | Likelihood | Impact | Risk Level | Mitigating Control Designed (Part 1) |
| :--- | :--- | :--- | :--- | :--- |
| **Bypass of standard password auth (Credential Stuffing)** | High | High | **Critical** | **Module A:** TOTP Multi-Factor Authentication prevents login even if the password is compromised. |
| **Vertical Privilege Escalation (Accessing Admin APIs)** | Medium | High | **High** | **Module A:** Strict RBAC matrix enforced at the backend controller level for every role. |
| **Exposure of Faculty PII via Database Dump/SQLi** | Low | High | **High** | **Module B:** AES-256 Encryption-at-Rest ensures stolen DB records remain unintelligible ciphertext. |
| **Man-in-the-Middle (MITM) Downgrade Attack** | Medium | Medium | **Medium** | **Module B:** Strict-Transport-Security (HSTS) header forces HTTPS connections, preventing downgrade to HTTP. |
| **Cross-Site Scripting (XSS) stealing Session Tokens** | High | High | **Critical** | **Module B:** Content-Security-Policy (CSP) header restricts malicious script execution. |
