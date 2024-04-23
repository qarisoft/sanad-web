<?php

namespace App\Traits;

use App\Models\Company;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

trait BelongsToCompany
{
    public function company(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }
}
