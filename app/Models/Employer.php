<?php
// app/Models/Employer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_website',
        'contact_number',
        'company_logo',
        'company_description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
