<?php

namespace App\Filament\Resources\Settings\TaskStatusResource\Pages;

use App\Filament\Resources\Settings\TaskStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaskStatus extends EditRecord
{
    protected static string $resource = TaskStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
