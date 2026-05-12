<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'mentor_id', 'material_id', 'achievement_score',
        'last_activity', 'feedback_notes', 'progress_date'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}