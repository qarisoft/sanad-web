<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait Defaults
{
    public static function defaults(): Collection
    {
        return static::all()->where('default', true);
    }

    public function scopeDefault($q)
    {
        return $q->where('default', true);
    }

    public function is_default(): bool
    {
        return $this->default ?? false;
    }
}
