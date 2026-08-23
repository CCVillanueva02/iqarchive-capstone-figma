<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'task_force_id',
        'status',
        'proposed_members',
        'target_date',
        'created_by'
    ];

    protected $casts = [
        'target_date' => 'date',
        'proposed_members' => 'array',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function taskForce()
    {
        return $this->belongsTo(TaskForce::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
