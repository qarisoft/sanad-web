<?php

namespace App\Models;

use App\Events\TaskPublished;
use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    protected $casts=[
        'must_do_at'=>'datetime'
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
//        $this->is_published=true;
//        $this->published_at=now();
//        $this->save();
//        event(new TaskPublished($this));
        event(new \App\Events\Task($this));
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
}
