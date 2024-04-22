<?php

namespace App\Models;

//use DB;
use App\Traits\Defaults;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class TaskStatus extends Model
{
    use Defaults;
    use HasFactory;

    protected $fillable = [
        'name', 'color', 'code', 'default',
    ];

    public function company(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }
}
