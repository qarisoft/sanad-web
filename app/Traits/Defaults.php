<?php

namespace App\Traits;

use DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

trait Defaults
{
    public static function defaults(): Collection
    {
        return self::defaults_query()->get();
    }

    public static function defaults_query(): Builder
    {
        return DB::table('defaults')
            ->where('default_type', '=', self::class);
    }

    //    public function getDefaultAttribute(): bool
    //    {
    //        return $this->is_default();
    //    }

    public function default(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->is_default(),
            set: function (bool $a) {
                if ($a) {
                    if (! $this->is_default()) {
                        DB::table('defaults')
                            ->insert(['default_type' => self::class, 'default_id' => $this->id]);
                    }
                }
            }
        );

    }

    public static function bootDefaults(): void
    {
        static::deleting(function (Model $model) {
            if ($model->default != null) {
                DB::table('defaults')->delete(['default_type' => self::class, 'default_id' => $model->id,

                ]);
            }
        });
    }

    public function is_default(): bool
    {
        return DB::table('defaults')
            ->where('default_type', self::class)
            ->where('default_id', $this->id)
            ->get()->isNotEmpty();
    }
}
