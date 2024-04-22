<?php

namespace App\Filament\Resources\Settings\PolygonResource\Pages;

use App\Filament\Resources\Settings\PolygonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPolygon extends EditRecord
{
    protected static string $resource = PolygonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
