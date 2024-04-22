<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $user = parent::handleRecordCreation($data);
        $user->location()->create([
            'lat'=>$data['place']['lat'],
            'lng'=>$data['place']['lng'],
            'place_id'=>$data['place']['place_id']
        ]);
        return $user;

    }
}
