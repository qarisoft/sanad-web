<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'lat',
        'lng',
        'street',
        'city',
        'type',
        'state',
        'zip',
        'address',
        'place_id'
    ];

    public function item():MorphTo
    {
        return $this->morphTo('item');

    }

}
