<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected function handleRecordCreation(array $data): Model
    {
        $user = parent::handleRecordCreation($data);
        $user->location()->create([
            'lat'=>$data['location']['lat'],
            'lng'=>$data['location']['lng'],
            'place_id'=>$data['location']['place_id']
        ]);
        return $user;
    }
}
