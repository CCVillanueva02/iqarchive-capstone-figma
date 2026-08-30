<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumentArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'instrument_id',
        'name',
        'code',
        'order',
        'weight',
        'description',
    ];

    protected $casts = [
        'order' => 'integer',
        'weight' => 'decimal:2',
    ];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }

    public function parameters()
    {
        return $this->hasMany(InstrumentParameter::class, 'instrument_area_id')->orderBy('order', 'asc');
    }
}
