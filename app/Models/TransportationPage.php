<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportationPage extends Model
{
    protected $fillable = [
        'main_title',
        'main_subtitle',
        'image_01',
        'image_02',
        'faqs',
    ];

    protected $casts = [
        'faqs' => 'array',
    ];
}
