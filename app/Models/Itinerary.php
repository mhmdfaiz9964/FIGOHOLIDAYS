<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    protected $fillable = [
        'offer_id',
        'day',
        'title',
        'description',
        'images',
        'activities',
    ];

    protected $casts = [
        'images' => 'array',
        'activities' => 'array', // [{text: string, icon: string}]
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
