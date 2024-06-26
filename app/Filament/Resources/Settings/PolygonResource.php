<?php

namespace App\Filament\Resources\Settings;

use App\Filament\Resources\Settings\PolygonResource\Pages;
//use App\Filament\Resources\Settings\PolygonResource\RelationManagers;
//use App\Models\Map\Settings\Polygon;
use App\Forms\Components\MapPolygon;
use App\Traits\DefaultsResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PolygonResource extends Resource
{
    use DefaultsResource;
    protected static ?string $model = \App\Models\Map\Polygon::class;

    protected static ?string $navigationIcon = 'heroicon-s-map-pin';
    public static function getNavigationGroup():string
    {
        return __('Settings');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('name')->required(),
                    MapPolygon::make('data')
                        ->columnSpanFull()->live()
//                        ->afterStateUpdated(function ($state){
////                    dd($state);
//                    })->hiddenLabel()
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('place_id'),
                IconColumn::make('default')->boolean()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->disabled(fn($record)=> $record->is_default()),
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
            'index' => Pages\ListPolygons::route('/'),
            'create' => Pages\CreatePolygon::route('/create'),
            'view' => Pages\ViewPolygon::route('/{record}'),
            'edit' => Pages\EditPolygon::route('/{record}/edit'),
        ];
    }

//    public static function getEloquentQuery() : Builder{
////        dump('ddddddddddddddddd');
//        return parent::getEloquentQuery(); // TODO: Change the autogenerated stub
//}
}
