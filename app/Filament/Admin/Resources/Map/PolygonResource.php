<?php

namespace App\Filament\Admin\Resources\Map;

use App\Filament\Admin\Resources\Map\PolygonResource\Pages;
//use App\Filament\Admin\Resources\Map\PolygonResource\RelationManagers;
use App\Forms\Components\MapArea;
use App\Forms\Components\MapPolygon;
use App\Models\Map\Polygon;
use Filament\Forms;
//use Filament\Forms;
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
    protected static ?string $model = Polygon::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([

                MapPolygon::make('data')->columnSpanFull()->live()->afterStateUpdated(function ($state){
//                    dd($state);
                })->hiddenLabel()
                ])->collapsed()
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
                Tables\Actions\EditAction::make()->hidden(fn($record)=>$record->isDefault()),
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
            'edit' => Pages\EditPolygon::route('/{record}/edit'),
            'view' => Pages\ViewPolygon::route('/{record}/view'),
        ];
    }
}
