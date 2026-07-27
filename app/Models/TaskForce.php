<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskForce extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'college_id',
        'program_id',
        'purpose',
        'status',
        'created_by',
    ];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'task_force_members')
            ->withPivot(['role_in_team', 'assigned_at'])
            ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get compliance statistics for this task force based on program or college requirements.
     */
    public function getProgressPercentageAttribute(): int
    {
        $programIds = [];

        if ($this->program_id) {
            $programIds = [$this->program_id];
        } elseif ($this->college_id) {
            $programIds = Program::where('college_id', $this->college_id)->pluck('id')->toArray();
        }

        if (empty($programIds)) {
            return 0;
        }

        $totalReqs = ComplianceRequirement::whereIn('program_id', $programIds)->count();
        if ($totalReqs === 0) {
            return 0;
        }

        $compliedReqs = ComplianceRequirement::whereIn('program_id', $programIds)
            ->where('status', 'complied')
            ->count();

        return (int) round(($compliedReqs / $totalReqs) * 100);
    }
}
