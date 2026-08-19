<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['college_id', 'name', 'code', 'accreditation_level'];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function complianceRequirements()
    {
        return $this->hasMany(ComplianceRequirement::class);
    }

    public function taskForceAssignments()
    {
        return $this->hasMany(TaskForceAssignment::class);
    }
}
