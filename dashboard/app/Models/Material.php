<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'level', 'file_path', 'file_name', 'file_size', 'mentor_id'
    ];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}