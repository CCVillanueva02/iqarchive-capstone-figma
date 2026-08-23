<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplianceRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'instrument_id',
        'program_id',
        'accreditation_id',
        'instrument_criterion_id',
        'description',
        'due_date',
        'status',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function accreditation()
    {
        return $this->belongsTo(Accreditation::class);
    }

    public function criterion()
    {
        return $this->belongsTo(InstrumentCriterion::class, 'instrument_criterion_id');
    }

    public function documentLinks()
    {
        return $this->hasMany(AccreditationDocumentLink::class);
    }
}
