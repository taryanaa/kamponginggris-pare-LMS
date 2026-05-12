<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicResults extends Model
{
    use HasFactory;

    protected $table = 'academic_results';
    
    protected $fillable = [
        'user_name',
        'user_email',
        'whatsapp_number',
        'test_type',
        'test_date',
        'overall_score',
        'overall_level',
        'total_correct',
        'total_questions',
        'total_percentage',
        'listening_score',
        'listening_percentage',
        'listening_ielts',
        'reading_score',
        'reading_percentage',
        'reading_ielts',
        'certificate_type',
        'submitted_at'
    ];

    protected $casts = [
        'test_date' => 'date',
        'submitted_at' => 'datetime'
    ];
}