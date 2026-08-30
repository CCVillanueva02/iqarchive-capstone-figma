<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class College extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'code', 'campus', 'logo_image'];
    protected $appends = ['logo'];

    public function getLogoAttribute()
    {
        if ($this->logo_image) {
            return '/logos/' . $this->logo_image;
        }

        // Hardcoded fallback for the 3 colleges whose codes don't match the logo filename
        $fallbacks = [
            'BUP' => 'BUPC.png',
            'CED' => 'CE.png',
            'IDA' => 'IDEA.png',
        ];

        if (array_key_exists($this->code, $fallbacks)) {
            return '/logos/' . $fallbacks[$this->code];
        }

        return '/logos/' . $this->code . '.png';
    }

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
