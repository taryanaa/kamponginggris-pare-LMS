<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'material_id', 'difficulty_level', 'deadline', 'mentor_id'
    ];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function assignments()
    {
        return $this->hasMany(TaskAssignment::class);
    }
}