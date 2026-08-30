# RBAC: Task Force Members Pivot & Team Roles

This reference document specifies the schema, Eloquent relationships, and team leadership mechanics of the `task_force_members` pivot table.

---

## 1. Pivot Architecture Overview

Rather than assigning a permanent static "Lead" role to user accounts, leadership is assigned dynamically **per task force** via the `task_force_members` pivot table.

```
┌─────────────────┐       ┌────────────────────────┐       ┌─────────────────┐
│     User        │       │   task_force_members   │       │   TaskForce     │
│   (Faculty)     │◄─────►│ role_in_team:          │◄─────►│ (BSCS Level II) │
│                 │       │   'lead' | 'member'    │       │                 │
└─────────────────┘       └────────────────────────┘       └─────────────────┘
```

This architecture allows a faculty member to be the **Lead** for their department's task force while participating as a standard **Member** in an interdisciplinary task force.

---

## 2. Pivot Table Schema & Constraints

```sql
CREATE TABLE task_force_members (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    task_force_id BIGINT UNSIGNED NOT NULL REFERENCES task_forces(id) ON DELETE CASCADE,
    user_id BIGINT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    role_in_team VARCHAR(255) NOT NULL DEFAULT 'member', -- 'lead', 'member'
    assigned_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE(task_force_id, user_id)
);
```

---

## 3. Eloquent Model & Aliases

- **Model:** [`App\Models\TaskForceMember`](../../app/Models/TaskForceMember.php)
- **Accessor/Mutator Compatibility:** To support legacy references expecting `role_in_task_force`, `TaskForceMember` maps:
  ```php
  public function getRoleInTaskForceAttribute(): string {
      return $this->role_in_team ?? 'member';
  }
  public function setRoleInTaskForceAttribute($value): void {
      $this->attributes['role_in_team'] = $value;
  }
  ```

---

## 4. Automatic Lead Assignment via Observer

In [`app/Providers/AppServiceProvider.php`](../../app/Providers/AppServiceProvider.php), the `TaskForce::created` observer detects the College Head and creates the lead record:

```php
\App\Models\TaskForce::created(function (\App\Models\TaskForce $taskForce) {
    if ($taskForce->college_id) {
        $collegeHeadRoleId = \App\Models\Role::where('role_name', 'college-head')->value('id');
        if ($collegeHeadRoleId) {
            $deans = \App\Models\User::where('college_id', $taskForce->college_id)
                ->where(function ($query) use ($collegeHeadRoleId) {
                    $query->where('role_id', $collegeHeadRoleId)
                        ->orWhereHas('roles', fn($q) => $q->where('roles.id', $collegeHeadRoleId));
                })->get();

            foreach ($deans as $dean) {
                \App\Models\TaskForceMember::firstOrCreate(
                    ['task_force_id' => $taskForce->id, 'user_id' => $dean->id],
                    ['role_in_team' => 'lead', 'assigned_at' => now()]
                );
            }
        }
    }
});
```

---

## 5. Cross-Quadrant Links

- **Explanation:** [College Head Contextual Elevation](../explanation/head-contextual-elevation.md)
- **Role Reference:** [RBAC: College Head](./rbac-college-head.md)
- **Role Reference:** [RBAC: Task Force Member](./rbac-task-force-member.md)
- **Schema Reference:** [Task Forces Schema](./database-schema-task-forces.md)
