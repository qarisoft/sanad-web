<?php

namespace App\Filament\Resources\Settings\PolygonResource\Pages;

use App\Filament\Resources\Settings\PolygonResource;
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
