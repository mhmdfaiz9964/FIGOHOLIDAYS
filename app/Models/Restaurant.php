<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'type',
        'rating',
        'map_url',
        'image',
        'description',
        'status',
    ];
}
