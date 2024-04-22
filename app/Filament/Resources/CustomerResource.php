<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

//use App\Filament\Company\Resources\CustomerResource\RelationManagers;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-s-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name') ->required(),
                TextInput::make('email')->required()->email(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\CustomerResource\Pages\ListCustomers::route('/'),
            // 'create' => Pages\CreateCustomer::route('/create'),
            // 'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
