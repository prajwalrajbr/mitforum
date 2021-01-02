<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentA extends Model
{
    use HasFactory;
    protected $fillable = [
        'fileLink',
        'Assessment_id',
        'uploaded_at',
        'uploaded_by',
    ];
}
