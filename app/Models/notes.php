<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notes extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'fileName',
        'fileId',
        'uploaded_subject_id',
        'uploaded_by',
    ];
}
