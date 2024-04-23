<?php

namespace App\Forms\Components;

use App\Models\Map\Polygon;
use Filament\Facades\Filament;
use Filament\Forms\Components\Field;

class MapArea extends Field
{
    public $polygons=[];
    protected string $view = 'forms.components.map-area';
//    public function mount() {
//        $this->polygons=collect([
//            Filament::getTenant()->polygons,
//            Polygon::defaults()
//        ]);
//    }

    public function getPolygons()
    {
        $this->polygons=collect([
            Polygon::defaults(),
            Filament::getTenant()->polygons,
        ])->flatten()->toArray();
        return $this->evaluate($this->polygons);
    }
}
