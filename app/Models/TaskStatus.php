<?php

namespace App\Models;

use App\Models\Scopes\DefaultScope;
//use DB;
use App\Traits\Defaults;
use Exception;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\DB;


class TaskStatus extends Model
{
    use HasFactory;
    use Defaults;

    protected $fillable=[
        'name','color','code',
    ];
    public function company():BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

}
