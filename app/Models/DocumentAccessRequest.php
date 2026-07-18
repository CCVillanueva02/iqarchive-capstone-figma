<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentAccessRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'requested_by',
        'status',
        'remarks',
        'approved_by',
        'approved_at',
        'expires_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'expires_at' => 'datetime'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
