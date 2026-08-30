<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumentCriterion extends Model
{
    use HasFactory;

    protected $table = 'instrument_criteria';

    protected $fillable = [
        'instrument_parameter_id',
        'section',
        'code',
        'statement',
        'description',
        'required_tags',
        'order',
    ];

    protected $casts = [
        'required_tags' => 'array',
        'order' => 'integer',
    ];

    public function parameter()
    {
        return $this->belongsTo(InstrumentParameter::class, 'instrument_parameter_id');
    }

    public function complianceRequirements()
    {
        return $this->hasMany(ComplianceRequirement::class, 'instrument_criterion_id');
    }
}
