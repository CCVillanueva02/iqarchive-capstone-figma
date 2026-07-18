<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskForceAssignment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'program_id', 'assigned_at', 'status'];

    protected $casts = [
        'assigned_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
