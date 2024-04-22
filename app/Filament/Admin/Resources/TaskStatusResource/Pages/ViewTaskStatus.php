<?php

namespace App\Filament\Admin\Resources\TaskStatusResource\Pages;

use App\Filament\Admin\Resources\TaskStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTaskStatus extends ViewRecord
{
    protected static string $resource = TaskStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
