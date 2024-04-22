<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Forms\Components\MapArea;
use App\Models\User;
//use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

//use App\Filament\Resources\UserResource\RelationManagers;
//use PHPUnit\Util\Filter;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';
    public static function getNavigationGroup():string
    {
        return __('Users');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Wizard::make([
                    Step::make('data')->columns(2)->schema([

                        Section::make('info')->columnSpan(1)

                            ->schema([
                                TextInput::make('name')    ->required(),
                                TextInput::make('email')   ->required(),
                                TextInput::make('password')->required(),
                            ]),
                        Section::make('specifications')->columnSpan(1)
                            ->schema([
                                Toggle::make('is_active'),
                                Toggle::make('is_viewer')->disabled(fn($operation)=>$operation=='edit'),

                            ])
                    ])->hidden(fn($operation)=>$operation!='create'),

                    Step::make('map')->columns(4)
                    ->schema([
                        Toggle::make('is_active'),
                        MapArea::make('place')
                            ->hiddenLabel()
                            ->live()
                            ->columnSpan(4)
                    ])

                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('place_id'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                TextColumn::make('is_viewer')
                    ->formatStateUsing(fn($state)=>$state==0?'employee':'viewer')
                    ->badge() ->color(fn (string $state): string => match ($state) {
                        '0' => 'warning',
                        '1' => 'success',
                    }),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
            ],layout: Tables\Enums\FiltersLayout::AboveContent,)
//
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}/view'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }


}
