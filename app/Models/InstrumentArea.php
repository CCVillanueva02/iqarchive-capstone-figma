<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumentArea extends Model
{
    use HasFactory;

    protected $fillable = ['instrument_id', 'name', 'code'];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }
}
