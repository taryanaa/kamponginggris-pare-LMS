<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'profile_photo', // <-- PASTIKAN INI ADA
    'phone',
    'date_of_birth',
    'gender',
    'specialization',
    'bio',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Get profile photo URL
     */
    // public function getProfilePhotoUrlAttribute()
    // {
    //     if ($this->profile_photo) {
    //         return asset('storage/' . $this->profile_photo);
    //     }
    //     return asset('assets/static/images/faces/1.jpg');
    // }

    /**
     * Scope to filter by role
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Get students only
     */
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    /**
     * Get mentors only
     */
    public function scopeMentors($query)
    {
        return $query->where('role', 'mentor');
    }

    /**
     * Get admins only
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }
}