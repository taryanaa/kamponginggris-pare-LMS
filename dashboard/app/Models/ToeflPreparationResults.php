<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToeflPreparationResults extends Model
{
    use HasFactory;

    protected $table = 'toefl_preparation_results';
    
    protected $fillable = [
        'user_name',
        'user_email',
        'user_whatsapp',
        'test_type',
        'test_date',
        'listening_score',
        'listening_correct',
        'listening_total',
        'listening_percentage',
        'reading_score',
        'reading_correct',
        'reading_total',
        'reading_percentage',
        'grammar_score',
        'grammar_correct',
        'grammar_total',
        'grammar_percentage',
        'overall_score',
        'total_correct',
        'total_questions',
        'overall_percentage',
        'cefr_level',
        'submitted_at'
    ];

    protected $casts = [
        'test_date' => 'date',
        'submitted_at' => 'datetime',
        'listening_percentage' => 'decimal:2',
        'reading_percentage' => 'decimal:2',
        'grammar_percentage' => 'decimal:2',
        'overall_percentage' => 'decimal:2'
    ];
}