<?php

namespace App\Filament\Resources\Settings\PolygonResource\Pages;

use App\Filament\Resources\Settings\PolygonResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPolygon extends ViewRecord
{
    protected static string $resource = PolygonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->disabled(fn($record)=>$record->is_default()),
        ];
    }
}
