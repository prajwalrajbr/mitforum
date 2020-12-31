<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentQ extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'branch',
        'sem',
        'is_f',
        'fileName',
        'fileLink',
        'startTime',
        'endTime',
        'subject_id',
        'subject_name',
        'sub_code',
        'created_by_id',
        'created_by_name',
        'date',
    ];
}
