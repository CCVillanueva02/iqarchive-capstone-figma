<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'uploaded_by',
        'program_id',
        'office_id',
        'category_id',
        'confirmed_by',
        'confirmed_at',
        'title',
        'file_path',
        'status',
        'visibility',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function category()
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function confirmer()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function ocrValidation()
    {
        return $this->hasOne(DocumentOCRValidation::class);
    }

    public function reviews()
    {
        return $this->hasMany(DocumentReview::class);
    }

    public function accreditationLinks()
    {
        return $this->hasMany(AccreditationDocumentLink::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'related_document_id');
    }

    public function accessRequests()
    {
        return $this->hasMany(DocumentAccessRequest::class);
    }
}
