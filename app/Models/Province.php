<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = ['name'];

    public function destinations()
    {
        return $this->hasMany(Destination::class);
    }
}
