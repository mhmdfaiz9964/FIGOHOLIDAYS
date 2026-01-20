<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visa extends Model
{
    protected $fillable = [
        'title',
        'background_image',
        'image',
        'update_title',
        'description',
        'website_url',
    ];
}
