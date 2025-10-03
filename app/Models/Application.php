<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use App\Models\User;
use App\Models\Application;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id', 'user_id', 'status'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
