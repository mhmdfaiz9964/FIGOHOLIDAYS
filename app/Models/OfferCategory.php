<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OfferCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'title',
        'sub_heading',
        'status',
        'banner_image',
    ];

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
