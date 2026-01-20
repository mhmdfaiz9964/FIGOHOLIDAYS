<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OfferType extends Model
{
    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($type) {
            $type->slug = Str::slug($type->name);
        });
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class);
    }
}
