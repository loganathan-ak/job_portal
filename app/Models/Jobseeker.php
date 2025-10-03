<?php
// app/Models/Jobseeker.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobseeker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'resume',
        'experience',
        'skills',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

        // Add this
    public function applications()
    {
        return $this->hasMany(Application::class, 'user_id', 'user_id');
    }
}
