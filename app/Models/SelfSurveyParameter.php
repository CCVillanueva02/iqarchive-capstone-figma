<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfSurveyParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'code',
        'title',
        'best_practices',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function area()
    {
        return $this->belongsTo(SelfSurveyArea::class, 'area_id');
    }

    public function indicators()
    {
        return $this->hasMany(SelfSurveyIndicator::class, 'parameter_id')->orderBy('sort_order', 'asc');
    }

    public function systemIndicators()
    {
        return $this->hasMany(SelfSurveyIndicator::class, 'parameter_id')
            ->where('section', 'system')
            ->orderBy('sort_order', 'asc');
    }

    public function implementationIndicators()
    {
        return $this->hasMany(SelfSurveyIndicator::class, 'parameter_id')
            ->where('section', 'implementation')
            ->orderBy('sort_order', 'asc');
    }

    public function outcomeIndicators()
    {
        return $this->hasMany(SelfSurveyIndicator::class, 'parameter_id')
            ->where('section', 'outcome')
            ->orderBy('sort_order', 'asc');
    }
}
