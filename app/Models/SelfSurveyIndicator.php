<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfSurveyIndicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'parameter_id',
        'section',
        'code',
        'statement',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function parameter()
    {
        return $this->belongsTo(SelfSurveyParameter::class, 'parameter_id');
    }

    public function ratings()
    {
        return $this->hasMany(SelfSurveyRating::class, 'indicator_id');
    }
}
