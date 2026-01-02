<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // This allows Laravel to save these fields to the database
    protected $fillable = [
        'title', 
        'description', 
        'priority', 
        'status'
    ];
}