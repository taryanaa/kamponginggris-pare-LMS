<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToeicResults extends Model
{
    use HasFactory;

    protected $table = 'toeic_results';
    
    protected $fillable = [
        'name',
        'email',
        'whatsapp',
        'listening_correct',
        'listening_total',
        'listening_percentage',
        'listening_score',
        'listening_cefr',
        'reading_correct',
        'reading_total',
        'reading_percentage',
        'reading_score',
        'reading_cefr',
        'overall_correct',
        'overall_total',
        'overall_percentage',
        'overall_score',
        'overall_cefr',
        'submitted_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime'
    ];
}