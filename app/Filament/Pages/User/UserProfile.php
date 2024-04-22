<?php

namespace App\Filament\Pages\User;

//use Filament\Forms\Components\FileUpload;
//use Filament\Forms\Components\TextInput;
//use Filament\Forms\Form;
//use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile;

class UserProfile extends EditProfile
{
//    public static function getLabel(): string
//    {
//        return 'Team profile';
//    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('username')
            ->required()->maxLength(255),
            $this->getNameFormComponent(),
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getPasswordConfirmationFormComponent()
        ]);
    }
}

