<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumentParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'instrument_area_id',
        'code',
        'name',
        'description',
        'order',
        'weight',
    ];

    protected $casts = [
        'order' => 'integer',
        'weight' => 'decimal:2',
    ];

    public function area()
    {
        return $this->belongsTo(InstrumentArea::class, 'instrument_area_id');
    }

    public function criteria()
    {
        return $this->hasMany(InstrumentCriterion::class, 'instrument_parameter_id')->orderBy('order', 'asc');
    }

    public function systemsCriteria()
    {
        return $this->hasMany(InstrumentCriterion::class, 'instrument_parameter_id')
            ->where('section', 'systems')
            ->orderBy('order', 'asc');
    }

    public function implementationCriteria()
    {
        return $this->hasMany(InstrumentCriterion::class, 'instrument_parameter_id')
            ->where('section', 'implementation')
            ->orderBy('order', 'asc');
    }

    public function outcomesCriteria()
    {
        return $this->hasMany(InstrumentCriterion::class, 'instrument_parameter_id')
            ->where('section', 'outcomes')
            ->orderBy('order', 'asc');
    }

    public function bestPracticesCriteria()
    {
        return $this->hasMany(InstrumentCriterion::class, 'instrument_parameter_id')
            ->where('section', 'best_practices')
            ->orderBy('order', 'asc');
    }
}
