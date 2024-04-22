<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TaskStatusResource\Pages;
use App\Filament\Admin\Resources\TaskStatusResource\RelationManagers;
use App\Models\TaskStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskStatusResource extends Resource
{
    protected static ?string $model = TaskStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('code')
                    ->numeric(),
                Forms\Components\TextInput::make('color'),
                Forms\Components\Toggle::make('default')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('color')
                    ->searchable(),
                Tables\Columns\IconColumn::make('default')
                    ->boolean(),
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
            'index' => Pages\ListTaskStatuses::route('/'),
            'create' => Pages\CreateTaskStatus::route('/create'),
            'view' => Pages\ViewTaskStatus::route('/{record}'),
            'edit' => Pages\EditTaskStatus::route('/{record}/edit'),
        ];
    }
}
