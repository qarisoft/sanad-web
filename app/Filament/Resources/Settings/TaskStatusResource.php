<?php

namespace App\Filament\Resources\Settings;

use App\Filament\Resources\Settings\TaskStatusResource\Pages;
//use App\Filament\Resources\Settings\TaskStatusResource\RelationManagers;
use App\Models\Company;
use App\Models\TaskStatus;
use App\Traits\DefaultsResource;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class TaskStatusResource extends Resource
{
    use DefaultsResource;

    protected static ?string $model = \App\Models\TaskStatus::class;

    protected static ?string $navigationIcon = 'heroicon-s-qr-code';
    public static function getNavigationGroup():string
    {
        return __('Settings');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\ColorPicker::make('color'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\ColorColumn::make('color')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->hidden(fn($record)=>$record->default),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])

            ])->checkIfRecordIsSelectableUsing(fn(Model $record)=>!$record->  is_default());
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
            'index' => Pages\ListTaskStatuses::route('/'),
//            'create' => Pages\CreateTaskStatus::route('/create'),
//            'view' => Pages\ViewTaskStatus::route('/{record}'),
//            'edit' => Pages\EditTaskStatus::route('/{record}/edit'),
        ];
    }

}
