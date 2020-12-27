<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentQ extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'fileName',
        'fileLink',
        'subject_id',
        'last_date_time',
        'created_by',
    ];
}
