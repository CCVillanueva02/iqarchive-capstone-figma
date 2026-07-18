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
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;

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
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['role_id', 'program_id', 'college_id', 'first_name', 'middle_name', 'last_name', 'email', 'password', 'status'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements PasskeyUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, PasskeyAuthenticatable, TwoFactorAuthenticatable;

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

    public function getRoleAttribute(): string
    {
        return $this->roleRelation ? $this->roleRelation->role_name : '';
    }

    public function getNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
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
        $fullName = trim($this->first_name . ' ' . $this->last_name);
        $initials = Str::initials($fullName, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }
}
