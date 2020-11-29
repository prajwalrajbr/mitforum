<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notes extends Model
{
    use HasFactory;
    protected $fillable = [
        'fileName',
        'uploaded_subject_id',
        'uploaded_by',
    ];
}
