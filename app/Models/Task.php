<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

//use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use BelongsToCompany;
    use HasFactory;

    protected $fillable = [
        'code',
        'received_at',
        'must_do_at',
        'finished_at',
        'published_at',
        'customer_id',
    ];

    protected $casts = [
        'must_do_at' => 'datetime',
    ];

    protected $appends = [
        'location',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function publish(): void
    {
        $title = 'Saved successfully';
        if (! $this->is_published) {
            $this->is_published = true;
            $this->published_at = now();
            $this->save();
            event(new \App\Events\Task($this));

            return;
        }
//        $title = 'task is already published';
//        Notification::make()
//            ->title($title)->danger()->send();

    }

    public function allowedViewers(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public static function booted(): void
    {
        static::created(function (Task $task) {
            $task->loc()->create();
        });
        static::deleted(function (Task $task) {
            $task->loc()->delete();
        });

    }

    public function loc(): MorphOne
    {
        return $this->morphOne(Location::class, 'item');
    }

    public function location(): Attribute
    {
        return Attribute::make(
            get: function () {
                $loc = $this->loc()->first();

                return [
                    'lat' => $loc->lat,
                    'lng' => $loc->lng,
                ];
            }
        );
    }

    public function scopeRed(Builder $q)
    {
        $red = 1;
        $now = now()->add(1, 'hours');
        $q->whereBetween('must_do_at', [now(), $now]);

        Carbon::now();
    }
}
