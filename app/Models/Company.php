<?php

namespace App\Models;

use App\Models\Map\Polygon;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Permission\Traits\HasRoles;

class Company extends Model implements HasAvatar

{
//    use HasRoles;
    use HasFactory;


    protected $fillable = [
        'name','avatar_url'
    ];


    public function defTaskStatus():MorphToMany
    {
        return $this->morphToMany(TaskStatus::class,'defaults');
    }

    public function polygons():BelongsToMany
    {
        return $this->belongsToMany(Polygon::class);
    }

    public function customers(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class);
    }
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }

    public function viewers()
    {
        return $this->users()->where('is_viewer',true)->get();
    }
    public function users() : BelongsToMany {
        return $this->belongsToMany(User::class);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->avatar_url==null){
            return null;
        }
        return env('APP_URL').'/media/'.$this->avatar_url;
    }

    public function roles():BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function taskStatuses():BelongsToMany
    {
        return  $this->belongsToMany(TaskStatus::class);
    }
}
