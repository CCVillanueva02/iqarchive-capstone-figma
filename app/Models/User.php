<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $role_id
 * @property int|null $program_id
 * @property int|null $college_id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property string|null $avatar
 * @property string|null $google_id
 * @property string|null $google_avatar
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string|null $avatar_url
 */
#[Fillable(['role_id', 'program_id', 'college_id', 'first_name', 'middle_name', 'last_name', 'name', 'email', 'avatar', 'password', 'status', 'google_id', 'google_avatar', 'email_verified_at'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationships
     */
    public function roleRelation()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Get all assigned roles for the user (including primary role_id fallback).
     */
    public function assignedRoles()
    {
        $assigned = $this->roles;
        if ($assigned->isEmpty() && $this->roleRelation) {
            return collect([$this->roleRelation]);
        }

        return $assigned;
    }

    public function getRoleAttribute(): string
    {
        $activeRole = session('active_role');
        if ($activeRole && $this->hasRole($activeRole)) {
            return $activeRole;
        }

        return $this->roleRelation ? $this->roleRelation->role_name : '';
    }

    public function hasRole($roleName): bool
    {
        if (is_array($roleName)) {
            foreach ($roleName as $r) {
                if ($this->hasRole($r)) {
                    return true;
                }
            }

            return false;
        }

        if ($this->roleRelation && $this->roleRelation->role_name === $roleName) {
            return true;
        }

        return $this->roles()->where('role_name', $roleName)->exists()
            || $this->roles->contains('role_name', $roleName);
    }

    public function hasAnyRole($roleNames): bool
    {
        return $this->hasRole($roleNames);
    }

    /**
     * Check if user holds task force lead authority for a specific task force (or any task force if null).
     */
    public function isTaskForceLead(?int $taskForceId = null): bool
    {
        $query = TaskForceMember::where('user_id', $this->id)
            ->whereIn('role_in_team', ['lead', 'task_force_lead']);

        if ($taskForceId) {
            $query->where('task_force_id', $taskForceId);
        }

        return $query->exists();
    }

    /**
     * Check if user is a member of a specific task force (or any task force if null).
     */
    public function isTaskForceMember(?int $taskForceId = null): bool
    {
        $query = TaskForceMember::where('user_id', $this->id);

        if ($taskForceId) {
            $query->where('task_force_id', $taskForceId);
        }

        return $query->exists();
    }

    public function syncRoles(array $roleIds): void
    {
        $this->roles()->sync($roleIds);
        if (! empty($roleIds) && (! in_array($this->role_id, $roleIds))) {
            $this->role_id = $roleIds[0];
            $this->save();
        }
    }

    public function getNameAttribute(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }

    public function setNameAttribute($value): void
    {
        $parts = explode(' ', trim($value), 2);
        $this->first_name = $parts[0] ?? '';
        $this->last_name = $parts[1] ?? '';
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function uploadedDocuments()
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    public function confirmedDocuments()
    {
        return $this->hasMany(Document::class, 'confirmed_by');
    }

    public function ocrValidations()
    {
        return $this->hasMany(DocumentOCRValidation::class, 'validated_by');
    }

    public function documentReviews()
    {
        return $this->hasMany(DocumentReview::class, 'reviewed_by');
    }

    public function taskForceAssignments()
    {
        return $this->hasMany(TaskForceAssignment::class);
    }

    public function taskForces()
    {
        return $this->belongsToMany(TaskForce::class, 'task_force_members')
            ->withPivot(['role_in_team', 'assigned_at'])
            ->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function requestedAccesses()
    {
        return $this->hasMany(DocumentAccessRequest::class, 'requested_by');
    }

    public function approvedAccesses()
    {
        return $this->hasMany(DocumentAccessRequest::class, 'approved_by');
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        $fullName = trim($this->first_name.' '.$this->last_name);
        $initials = Str::initials($fullName, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }

    /**
     * Get the resolved avatar URL for the user.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if ($this->avatar) {
            return Str::startsWith($this->avatar, ['http://', 'https://'])
                ? $this->avatar
                : Storage::url($this->avatar);
        }

        if ($this->google_avatar) {
            return $this->google_avatar;
        }

        return null;
    }
}
