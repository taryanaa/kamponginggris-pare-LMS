<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicEnglishResults extends Model
{
    use HasFactory;

    protected $table = 'basic_english_results';
    
    protected $fillable = [
        'user_name',
        'user_email',
        'whatsapp_number',
        'test_type',
        'test_date',
        'submitted_at',
        'overall_score',
        'overall_level',
        'total_correct',
        'total_questions',
        'total_percentage',
        'vocabulary_correct',
        'vocabulary_total',
        'vocabulary_percentage',
        'vocabulary_level',
        'grammar_correct',
        'grammar_total',
        'grammar_percentage',
        'grammar_level',
        'pronunciation_correct',
        'pronunciation_total',
        'pronunciation_percentage',
        'pronunciation_level',
        'reading_correct',
        'reading_total',
        'reading_percentage',
        'reading_level',
        'listening_correct',
        'listening_total',
        'listening_percentage',
        'listening_level'
    ];

    protected $casts = [
        'test_date' => 'date',
        'submitted_at' => 'datetime',
        'total_percentage' => 'decimal:2',
        'vocabulary_percentage' => 'decimal:2',
        'grammar_percentage' => 'decimal:2',
        'pronunciation_percentage' => 'decimal:2',
        'reading_percentage' => 'decimal:2',
        'listening_percentage' => 'decimal:2'
    ];
}