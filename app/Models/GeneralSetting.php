<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable = [
        'logo',
        'footer_logo',
        'footer_description',
        'head_offices',
        'whatsapps',
        'landlines',
        'emails',
        'map_urls',
        'copyright_text',
        'experience_count',
        'destination_count',
        'customers_count',
        'trip_count',
        'primary_color',
    ];

    protected $casts = [
        'head_offices' => 'array',
        'whatsapps' => 'array',
        'landlines' => 'array',
        'emails' => 'array',
        'map_urls' => 'array',
    ];
}
