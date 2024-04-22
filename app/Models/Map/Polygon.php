<?php

namespace App\Models\Map;

use App\Models\Company;
use App\Traits\Defaults;
use App\Traits\Polygons;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Polygon extends Model
{
    use Defaults;
    use HasFactory;
    use Polygons;

    protected $fillable = [
        'place_id', 'name', 'data',
    ];

    public function company(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    //    public function scopeDefault($q)
    //    {
    //        return $q->where('default',true);
    //    }
    //
    //    public function isDefault():bool
    //    {
    //        return $this->default??false;
    //    }
    //    protected static function booted():void
    //    {
    //        static::addGlobalScope('default', function (Builder $builder) {
    //            $builder->orWhere('default', true);
    //        });
    //    }
}
