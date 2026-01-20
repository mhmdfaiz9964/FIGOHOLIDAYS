<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'image',
        'province_id',
        'attractions',
        'description',
        'label',
        'status',
    ];

    protected $casts = [
        'attractions' => 'array',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
