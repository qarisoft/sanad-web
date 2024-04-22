<?php
namespace App\Filament\Pages\Company;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;

class Profile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Team profile';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                FileUpload::make('avatar_url')
                    ->avatar()
            ]);
    }
}

