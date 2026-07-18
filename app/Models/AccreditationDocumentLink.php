<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccreditationDocumentLink extends Model
{
    use HasFactory;

    protected $fillable = ['document_id', 'compliance_requirement_id'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function complianceRequirement()
    {
        return $this->belongsTo(ComplianceRequirement::class);
    }
}
