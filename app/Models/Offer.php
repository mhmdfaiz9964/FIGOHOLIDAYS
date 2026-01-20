<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'offer_category_id',
        'offer_type_id',
        'title',
        'status',
        'meta_description',
        'price',
        'offer_price',
        'video',
        'thumbnail_image',
        'gallery_images',
        'nights',
        'days',
        'star_rating',
        'sidebar_banner_image',
        'sidebar_banner_title',
        'sidebar_banner_label',
        'sidebar_banner_description',
        'sidebar_banner_url',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'price' => 'decimal:2',
        'offer_price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(OfferCategory::class, 'offer_category_id');
    }

    public function primaryType()
    {
        return $this->belongsTo(OfferType::class, 'offer_type_id');
    }

    public function types()
    {
        return $this->belongsToMany(OfferType::class);
    }

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }
}
