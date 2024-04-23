<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait DefaultsResource
{
    public static function getEloquentQuery(): Builder
    {
        $q = parent::getEloquentQuery()->latest();
        $q->orWhere('default', true);

        return $q;
    }
}
