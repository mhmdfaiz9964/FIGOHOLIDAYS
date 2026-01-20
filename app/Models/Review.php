<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_name',
        'user_image',
        'rating',
        'description',
        'date',
        'source',
        'added_by',
        'user_location',
        'images',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
        'date' => 'date',
    ];
}
