<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use App\Models\User;
use App\Models\Application;

class Job extends Model
{

    use HasFactory;

 protected $fillable = [
    'user_id',
    'title',
    'category',
    'description',
    'location',
    'skills',       // store as JSON
    'salary_min',
    'salary_max',
    'is_active',
];



public function employer()
{
    // jobs.user_id -> employers.user_id
    return $this->belongsTo(Employer::class, 'user_id', 'user_id');
}

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
