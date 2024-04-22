<?php

namespace App\Models;

use App\Traits\Defaults;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\DB;


class Task extends Model
{

    use HasFactory;
    protected $fillable = [
        'code',
        'received_at',
        'must_do_at',
        'finished_at',
        'published_at',
        'customer_id',
        'lat',
        'lng',
    ];

    protected $appends = [
        'location',
    ];

    public function company(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }





    public function getLocationAttribute(): array
    {
        return [
            "lat" => (float)$this->lat,
            "lng" => (float)$this->lng,
        ];
    }

    public function setLocationAttribute(?array $location): void
    {
        if (is_array($location)) {
            $this->attributes['lat'] = $location['lat'];
            $this->attributes['lng'] = $location['lng'];
            unset($this->attributes['location']);
        }
    }

    public static function getLatLngAttributes(): array
    {
        return [
            'lat' => 'lat',
            'lng' => 'lng',
        ];
    }
    public static function getComputedLocation(): string
    {
        return 'location';
    }
}
