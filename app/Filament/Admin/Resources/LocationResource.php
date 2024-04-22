<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LocationResource\Pages;
//use App\Filament\Admin\Resources\LocationResource\RelationManagers;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LocationResource extends Resource
{
//    function () {

//}
    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('place_id')
                    ->required(),
                Forms\Components\TextInput::make('lat'),
                Forms\Components\TextInput::make('lng'),
                Forms\Components\TextInput::make('street'),
                Forms\Components\TextInput::make('city'),
                Forms\Components\TextInput::make('type'),
                Forms\Components\TextInput::make('state'),
                Forms\Components\TextInput::make('zip'),
                Forms\Components\TextInput::make('address'),
                Forms\Components\TextInput::make('location_id')
                    ->numeric(),
                Forms\Components\TextInput::make('location_type'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('place_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lng')
                    ->searchable(),
                Tables\Columns\TextColumn::make('street')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'view' => Pages\ViewLocation::route('/{record}'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }

//    public static function getH() {

//}


}
