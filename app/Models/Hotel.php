<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'location',
        'city',
        'rating',
        'price_per_night',
        'meta_description',
        'hotel_type_id',
        'activities',
        'image',
        'status',
    ];

    protected $casts = [
        'activities' => 'array',
        'price_per_night' => 'decimal:2',
    ];

    public function hotelType()
    {
        return $this->belongsTo(HotelType::class);
    }
}
