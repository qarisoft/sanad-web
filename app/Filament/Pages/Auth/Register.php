<?php
namespace App\Filament\Pages\Auth;

use App\Models\Company;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;

// use App\Models\Team;

class Register extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register team';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
            ]);
    }

    protected function handleRegistration(array $data): Company
    {
        $team = Company::create($data);

        $team->users()->attach(auth()->user());
        $team->owner_id=auth()->user()->id;
        $team->save();
        auth()->user()->assignRole('admin');
        auth()->user()->update([
            'is_active'=>true
        ]);
        auth()->user()->save();

        return $team;
    }
}
