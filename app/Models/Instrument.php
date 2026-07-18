<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = ['document_id', 'name', 'code', 'level', 'description'];

    public function referenceDocument()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function areas()
    {
        return $this->hasMany(InstrumentArea::class);
    }

    public function complianceRequirements()
    {
        return $this->hasMany(ComplianceRequirement::class);
    }
}
