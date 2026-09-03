<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfSurveyArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'label',
        'title',
        'type',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function parameters()
    {
        return $this->hasMany(SelfSurveyParameter::class, 'area_id')->orderBy('sort_order', 'asc');
    }
}
