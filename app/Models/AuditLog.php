<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id', 'action', 'target_type', 'target_id', 'timestamp'];

    protected $casts = [
        'timestamp' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
