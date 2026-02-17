<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    protected $fillable = [
        'title',
        'vehicle_type',
        'vehicle_image',
        'includes',
        'starting_price',
        'seats',
        'bags',
        'label_icon',
        'status',
    ];

    protected $casts = [
        'includes' => 'array',
        'starting_price' => 'decimal:2',
    ];
}
