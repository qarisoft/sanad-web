<?php

namespace App\Providers;

use Filament\Facades\Filament;
//use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Filament\Support\Assets\Js;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
//        FilamentAsset::
        FilamentAsset::register([

            Js::make('map', resource_path('js/map.js')),
//            Js::make('app', resource_path('js/app.js')),
            AlpineComponent::make('map-polygon-component', resource_path() .'/js/dist/components/map-polygon.js'),
            AlpineComponent::make('map-location-component', resource_path() .'/js/dist/components/map-location.js'),
            AlpineComponent::make('map-area-component', resource_path() .'/js/dist/components/map-area.js'),
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Relation::enforceMorphMap([
            'point' => 'App\Models\Map\Point',
            'polygon' => 'App\Models\Map\Polygon',
            'user'=>'App\Models\User',
            'company'=>'App\Models\Company',
            'customer'=>'App\Models\Customer',
            'task'=>'App\Models\Task',
        ]);
    }
}
