<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticalEnglishResults extends Model
{
    use HasFactory;

    protected $table = 'practical_english_results';
    
    protected $fillable = [
        'name',
        'email',
        'test_date',
        'overall_score',
        'overall_level',
        'total_correct',
        'total_questions',
        'total_percentage',
        'reading_percentage',
        'reading_level',
        'reading_score',
        'reading_ielts',
        'listening_percentage',
        'listening_level',
        'listening_score',
        'listening_ielts',
        'grammar_percentage',
        'grammar_level',
        'grammar_score',
        'grammar_ielts',
        'speaking_completed',
        'speaking_level',
        'reading_progress',
        'listening_progress',
        'grammar_progress',
        'submitted_at'
    ];

    protected $casts = [
        'test_date' => 'date',
        'submitted_at' => 'datetime',
        'total_percentage' => 'decimal:2',
        'reading_percentage' => 'decimal:2',
        'listening_percentage' => 'decimal:2',
        'grammar_percentage' => 'decimal:2',
        'reading_progress' => 'decimal:2',
        'listening_progress' => 'decimal:2',
        'grammar_progress' => 'decimal:2'
    ];
}