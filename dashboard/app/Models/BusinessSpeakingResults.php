<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSpeakingResults extends Model
{
    use HasFactory;

    protected $table = 'business_speaking_results';
    
    protected $fillable = [
        'name',
        'email',
        'test_date',
        'overall_score',
        'completion_info',
        'negotiating_completed',
        'negotiating_total',
        'issues_completed',
        'issues_total',
        'meeting_completed',
        'meeting_total',
        'total_completed',
        'total_tasks',
        'overall_percent',
        'submitted_at'
    ];

    protected $casts = [
        'test_date' => 'date',
        'submitted_at' => 'datetime',
        'overall_score' => 'decimal:1',
        'overall_percent' => 'decimal:2'
    ];
}