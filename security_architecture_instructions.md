1. Project Overview

This final project asks each capstone group to extend the system already proposed in Capstone Project 1 with a documented security architecture and a corresponding Vulnerability Assessment and Penetration Testing (VAPT) plan. 

The security controls, design rationale, and test plans produced here are grounded in the concepts, tools, and techniques covered across IT 122 (IA52).

SCOPE BOUNDARY
This project is a planning, documentation, and presentation exercise. No source code implementation, system deployment, or live vulnerability scanning is required or graded in IT 122. Design artifacts approved through this project will serve as the
baseline specification your group can implement in Capstane Project 2.
Groups are the same groups already formed for Capstone Project 1. No re-formation of groups is permitted for this project.

2. Part 1 -Security Architecture Design

Each group must integrate the modules below and design how the corresponding controls would be integrated into their existing capstone system. Designs must be specific to the group's own capstone architecture - generic or textbook descriptions without system-specific detail will not satisfy the requirement.


Module A: Identity & Access Fortification
Required design elements:

Multi-Factor Authentication (MFA] design using Time-based One-Time Passwords (TOTP), including secret provisioning
and validation flow.
A strict Role-Based Access Control (RBAC) matrix covering every user role in the existing capstone system.
Required artifacts:

 TOTP enrollment and verification flow diagram.
Complete RBAC matrix (roles x resources x permitted actions).
Design rationale paragraph explaining how this ties to hashing/MAC concepts (Week 3) and privilege management

Module B: Cryptographic Data Protection
Required design elements:
AES-256 encryption-at-rest design for sensitive fields (e.g., PII, financial records) in the existing database schema.
TLS/HTTPS configuration plan including HSTS and CSP header specifications.
Required artifacts:
 Data-flow diagram showing which fields are encrypted and at what layer (application vs. database).
Key management approach (storage, rotation policy - design only).
TLS/header configuration table (header name, value, purpose].





3. Part 2 - VAPT Verification Plan

Groups must plan, but not execute, a vulnerability assessment and penetration test targeting the components addressed by their chosen modules in Part 1.

3.1 VAPT Test Plan
Scanner(s) to be used (e.g., OWASP ZAP, Nikto, Burp Suite, Nuclei, etc) and justification for the choice.
Scope: which components, endpoints, or network segments would be targeted.
Expected finding categories (e.g., missing security headers, injectable parameters, weak session handling).

3.2 Manual Test-Case Write-Ups (minimum 2)
Each test case must be written as a structured procedure - objective, method, tools, and success criteria - without being executed against live code. Suggested scenarios include a JWT replay-attack scenario or a login SQL-injection bypass scenario, matched to the modules the group selected.

3.3 Risk Matrix
A likelihood x impact risk matrix covering the anticipated vulnerabilities identified in the test plan, with each risk mapped to the mitigating control designed in Part 1.


