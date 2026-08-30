# Explanation: College & Department Head Contextual Elevation

This architectural explanation document details why and how College Heads (Deans) and Department Chairs receive contextual elevation to **Task Force Lead** without mutating their primary system role.

---

## 1. The Design Challenge: Static Roles vs. Dynamic Leadership

In academic institutions, leadership structures operate on two distinct planes:
1. **Permanent Academic Persona:** A College Dean holds executive responsibility over an entire college (`college-head`).
2. **Contextual Accreditation Responsibilities:** When a degree program under their college prepares for AACCUP survey visits, the Dean serves as the ex-officio **Lead** of the task force body.

### Why Mutating User Roles is an Anti-Pattern
If the system changed the Dean's primary role to `task-force-lead`:
- The Dean would lose college-wide administrative dashboard access and verification privileges over other non-accrediting programs in their college.
- Multiple active task forces across different departments would cause race conditions and role identity conflicts.

---

## 2. The Solution: Pivot-Level Contextual Elevation

IQArchive cleanly separates **global role identity** from **contextual team role**:

```
Global Identity (users.role_id)         Contextual Assignment (task_force_members)
┌───────────────────────────────┐       ┌─────────────────────────────────────────┐
│ User: Dr. Carlos Mendoza      │       │ Task Force: BS Civil Engineering        │
│ Role: 'college-head' (Dean)   │──────►│ role_in_team: 'lead'                    │
│ College: College of Eng (CENG)│       │ Assigned: Automatic via Observer        │
└───────────────────────────────┘       └─────────────────────────────────────────┘
```

---

## 3. Automated Observer Mechanics

To eliminate manual administrative overhead, an Eloquent model event listener is registered in [`app/Providers/AppServiceProvider.php`](file:///c:/Users/janss/Herd/iqarchive/app/Providers/AppServiceProvider.php):

1. **Trigger:** Whenever an IQA coordinator creates a new `TaskForce` record with a `college_id`.
2. **Resolution:** The observer queries all active users assigned to that `college_id` holding the `college-head` role (via primary `role_id` or `role_user` pivot).
3. **Automatic Elevation:** It creates a record in `task_force_members`:
   ```php
   \App\Models\TaskForceMember::firstOrCreate(
       ['task_force_id' => $taskForce->id, 'user_id' => $dean->id],
       ['role_in_team' => 'lead', 'assigned_at' => now()]
   );
   ```

---

## 4. Key Benefits

- **Zero Administrative Delay:** Deans immediately gain leadership access upon task force creation.
- **Role Purity:** The Dean's system account retains executive `college-head` authority across the entire academic unit.
- **Dynamic Scope:** In the UI, the Dean seamlessly accesses Dean Verification queues while simultaneously participating in task force checklists.

---

## 5. Cross-Quadrant Links

- **Role Reference:** [RBAC: College Head Reference](file:///c:/Users/janss/Herd/iqarchive/docs/reference/rbac-college-head.md)
- **Pivot Reference:** [Task Force Members Pivot](file:///c:/Users/janss/Herd/iqarchive/docs/reference/rbac-task-force-members-pivot.md)
- **Schema Reference:** [Task Forces Schema](file:///c:/Users/janss/Herd/iqarchive/docs/reference/database-schema-task-forces.md)
