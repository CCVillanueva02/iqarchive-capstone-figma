<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfSurveyRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'indicator_id',
        'rated_by',
        'rating',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function indicator()
    {
        return $this->belongsTo(SelfSurveyIndicator::class, 'indicator_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'rated_by');
    }
}
