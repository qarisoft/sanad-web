<?php

namespace App\Models\Map;

use App\Helper\Geocoder\Point;
use App\Traits\BelongsToCompany;
use App\Traits\Defaults;
use App\Traits\Polygons;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Polygon extends Model
{
    use BelongsToCompany;
    use Defaults;
    use HasFactory;
    use Polygons;

    protected $fillable = [
        'place_id', 'name', 'data',
    ];

    public function points(): Attribute
    {
        return Attribute::make(
            get: function () {
                return collect(
                    json_decode($this->data)
                )->map(fn ($a) => new Point($a->lat, $a->lng));
            }

        );
    }

    public function check($x, $y)
    {
        $point = new Point($x, $y);

        return $this->checkPointPosition($point, $this->points) == 'inside';
    }

    public static function getPointPlaceIds($x, $y)
    {
        //        $a =
        return static::all()->filter(function ($polygon) use ($x, $y) {
            return $polygon->check($x, $y);
        })->map(fn ($p) => $p->place_id)->flatten()->all();

        //        return $a;
    }
}
