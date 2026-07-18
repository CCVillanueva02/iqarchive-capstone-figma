<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentOCRValidation extends Model
{
    use HasFactory;

    protected $table = 'document_ocr_validations';

    protected $fillable = [
        'document_id',
        'validated_by',
        'extracted_data',
        'validated_at',
        'validation_status'
    ];

    protected $casts = [
        'validated_at' => 'datetime'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
