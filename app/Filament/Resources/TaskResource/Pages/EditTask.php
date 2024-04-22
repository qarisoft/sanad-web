<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        // $record->update($data);
        // dump($data);
        // $location = $record->loc()->first();
        // $location->lat= $data['lat'];
        // $location->lng= $data['lng'];
        // $location->place_id=$data['place_id'];
        // $location->save();
        // $record->save();
        $record->loc()->first()->update($data['location']);
            // dump($location,$record);

        // return $record;
        return parent::handleRecordUpdate($record, $data);
    }



}
