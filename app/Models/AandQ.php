<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AandQ extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'fileLink',
        'is_f',
        'uploaded_by',
    ];
}
