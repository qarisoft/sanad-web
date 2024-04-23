<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helper\Utils\Enums\Permissions\Permissions;
use App\Helper\Utils\Enums\Permissions\Resources;
//use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use App\Observers\UserObserver;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
//#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements FilamentUser, HasTenants
{
    use HasApiTokens;
    use HasFactory, Notifiable;
    use HasRoles;

    protected $appends=['place'];
//    protected $with=['location'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'is_viewer',

    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function visibleTasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
//            'place'=>'array'
        ];
    }
    public function active(): bool
    {
        return $this->is_active ?? false;
    }

    public function scopeViewer(Builder $q):void
    {
        $q->where('is_viewer',true);
    }

    public function getPlaceAttribute():array
    {
        $l = $this->location()->first();
        if ($l) return [
            'lat'=>$l->lat,
            'lng'=>$l->lng,
            'place_id'=>$l->place_id
        ];
        return [];

    }

    public function getPlaceIdAttribute():string|null
    {
        $l = $this->location()->first();
        if ($l) return $l->place_id;
        return null;
    }

    public static function good(string $id)
    {
        return User::addSelect([
            'place_id' => Location::select('place_id')
                ->whereColumn('location_id', 'users.id')
                ->whereColumn('location_type', User::class),
        ])->where('place_id', $id);
        //        $query->where('locations','!=','null');

    }

    public static function wherePlaceId( $id)
    {
        return User::all()->where('place_id',$id);
    }

    public function location(): MorphOne
    {
        return $this->morphOne(Location::class,'item');
    }

    public function company(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }

    public function is_owner($id=null):bool
    {
        $company=$id?Company::find($id):$this->company()->first();
        return ($company?->owner_id==$this->id)??false;
    }

    public function getTenants(Panel $panel): array|\Illuminate\Support\Collection
    {
        return $this->company;
    }

    public function canAccessTenant(\Illuminate\Database\Eloquent\Model $tenant): bool
    {
        return $this->company()->whereKey($tenant)->exists();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() == 'admin') {
            return  true;
//            return $this->can(Permissions::Access->can(Resources::AdminPanel));
        }

//            return $this->can(Permissions::Access->can(Resources::CompanyPanel));
        return true;
    }
}
