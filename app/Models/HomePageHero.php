<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageHero extends Model
{
    protected $fillable = [
        'tag',
        'title',
        'highlighted_title',
        'description',
        'background_image',
        'btn1_text',
        'btn1_url',
        'btn1_icon',
        'btn2_text',
        'btn2_url',
        'btn2_icon',
    ];
}
