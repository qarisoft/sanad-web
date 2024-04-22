<?php

namespace App\Filament\Admin\Resources\Map\PolygonResource\Pages;

use App\Filament\Admin\Resources\Map\PolygonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPolygons extends ListRecords
{
    protected static string $resource = PolygonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
