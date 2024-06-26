<?php

namespace App\Filament\Admin\Resources\Map\PolygonResource\Pages;

use App\Filament\Admin\Resources\Map\PolygonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePolygon extends CreateRecord
{
    protected static string $resource = PolygonResource::class;

    protected function handleRecordCreation(array $data) : Model{
//        $data['place_id'];
        return parent::handleRecordCreation($data); // TODO: Change the autogenerated stub
    }
}
