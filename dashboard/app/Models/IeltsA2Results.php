<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IeltsA2Results extends Model
{
    use HasFactory;

    protected $table = 'ielts_a2_results';
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'overall_score',
        'overall_level',
        'overall_band',
        'listening_accuracy',
        'listening_correct',
        'listening_ielts',
        'reading_accuracy',
        'reading_correct',
        'reading_ielts',
        'writing_task1',
        'writing_task2',
        'writing_overall',
        'listening_percent',
        'reading_percent',
        'writing_percent',
        'submitted_at'
    ];

    protected $casts = [
        'test_date' => 'date',
        'submitted_at' => 'datetime',
        'listening_accuracy' => 'decimal:2',
        'listening_ielts' => 'decimal:1',
        'reading_accuracy' => 'decimal:2',
        'reading_ielts' => 'decimal:1',
        'writing_task1' => 'decimal:1',
        'writing_task2' => 'decimal:1',
        'writing_overall' => 'decimal:1',
        'listening_percent' => 'decimal:2',
        'reading_percent' => 'decimal:2',
        'writing_percent' => 'decimal:2'
    ];
}