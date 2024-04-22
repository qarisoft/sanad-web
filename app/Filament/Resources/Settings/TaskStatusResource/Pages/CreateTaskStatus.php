<?php

namespace App\Filament\Resources\Settings\TaskStatusResource\Pages;

use App\Filament\Resources\Settings\TaskStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTaskStatus extends CreateRecord
{
    protected static string $resource = TaskStatusResource::class;
}
