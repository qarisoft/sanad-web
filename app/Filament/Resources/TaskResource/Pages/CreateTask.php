<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;

//    protected function handleRecordCreation(array $data): Model
//    {
//        $record = parent::handleRecordCreation($data); // TODO: Change the autogenerated stub
//
//        return $record;
//    }

//    protected function getRedirectUrl(): string
//    {
//        return ViewTask::getUrl();
//    }
}
