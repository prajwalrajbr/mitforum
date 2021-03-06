<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subjects extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_code',
        'subject_name',
        'sem',
        'branch',
        'created_by',
    ];
}
