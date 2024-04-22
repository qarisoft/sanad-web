<?php

namespace App\Models;

use App\Traits\Defaults;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\DB;


class Task extends Model
{

    use HasFactory;
    protected $fillable = [
        'code',
        'received_at',
        'must_do_at',
        'finished_at',
        'published_at',
        'customer_id',
    ];

    protected $appends = [
        'location',
    ];

    public function company(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }


    static function booted()
    {
        static::created( function(Task $task){
            $task->loc()->create();
        });
        static::deleted(function(Task $task){
            $task->loc()->delete();
        });


    }



    public function loc(){
        return $this->morphOne(Location::class,'item');
    }

    public  function location():Attribute
    {
        return Attribute::make(
            get:function(){
                $loc = $this->loc()->first();
                return [
                    'lat'=>$loc->lat,
                    'lng'=>$loc->lng,
    //                 'place_id'=>$loc->place_id,
                ];
            }
    //         set:fn($a)=>dump($a)
    //         // function($location){
    //             // if (is_array($location))
    //             // dump($location);
    //             // $this->loc()->first()->update([
    //             //     'lat'=>$location['lat'],
    //             //     'lng'=>$location['lng'],
    //             //     'place_id'=>$location['place_id'],
    //             // ]);
    //         // }
        );
    }
}
