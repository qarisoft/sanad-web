<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait DefaultsResource
{
    public static function getEloquentQuery(): Builder
    {
        $q = parent::getEloquentQuery();

        $q->orwhereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('defaults')
                ->where('defaults.default_type', '=', static::getModel())
                ->where('defaults.default_id', '=', 'id');
        });

        return $q;
    }
}
