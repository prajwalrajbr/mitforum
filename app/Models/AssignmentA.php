<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentA extends Model
{
    use HasFactory;
    protected $fillable = [
        'fileLink',
        'Assignment_id',
        'uploaded_by',
    ];
}
