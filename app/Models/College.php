<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function taskForces()
    {
        return $this->hasMany(TaskForce::class);
    }
}
