<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TaskResource\Pages;
//use App\Filament\Admin\Resources\TaskResource\RelationManagers;
use App\Forms\Components\MapLocation;
use App\Models\Customer;
use App\Models\Task;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

//class TaskResource extends Resource
//{
//    protected static ?string $model = Task::class;
//
//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
//
//    public static function form(Form $form): Form
//    {
//        return $form
//            ->schema([
//                Forms\Components\TextInput::make('lat')
//                    ->required(),
//                Forms\Components\TextInput::make('lng')
//                    ->required(),
//                Forms\Components\TextInput::make('code')
//                    ->required(),
//                Forms\Components\TextInput::make('notes'),
//                Forms\Components\TextInput::make('company_id')
//                    ->numeric(),
//                Forms\Components\TextInput::make('location_id')
//                    ->numeric(),
//                Forms\Components\Select::make('customer_id')
//                    ->relationship('customer', 'name'),
//                Forms\Components\TextInput::make('task_status_id')
//                    ->numeric(),
//                Forms\Components\DateTimePicker::make('received_at'),
//                Forms\Components\DateTimePicker::make('must_do_at'),
//                Forms\Components\DateTimePicker::make('finished_at'),
//                Forms\Components\DateTimePicker::make('published_at'),
//            ]);
//    }
//
//    public static function table(Table $table): Table
//    {
//        return $table
//            ->columns([
//                Tables\Columns\TextColumn::make('lat')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('lng')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('code')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('notes')
//                    ->searchable(),
//                Tables\Columns\TextColumn::make('company_id')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('location_id')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('customer.name')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('task_status_id')
//                    ->numeric()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('received_at')
//                    ->dateTime()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('must_do_at')
//                    ->dateTime()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('finished_at')
//                    ->dateTime()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('published_at')
//                    ->dateTime()
//                    ->sortable(),
//                Tables\Columns\TextColumn::make('created_at')
//                    ->dateTime()
//                    ->sortable()
//                    ->toggleable(isToggledHiddenByDefault: true),
//                Tables\Columns\TextColumn::make('updated_at')
//                    ->dateTime()
//                    ->sortable()
//                    ->toggleable(isToggledHiddenByDefault: true),
//            ])
//            ->filters([
//                //
//            ])
//            ->actions([
//                Tables\Actions\ViewAction::make(),
//                Tables\Actions\EditAction::make(),
//            ])
//            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
//            ]);
//    }
//
//    public static function getRelations(): array
//    {
//        return [
//            //
//        ];
//    }
//
//    public static function getPages(): array
//    {
//        return [
//            'index' => Pages\ListTasks::route('/'),
//            'create' => Pages\CreateTask::route('/create'),
//            'view' => Pages\ViewTask::route('/{record}'),
//            'edit' => Pages\EditTask::route('/{record}/edit'),
//        ];
//    }
//}
class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-s-map';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()->columns(3)->schema([

                    Section::make()->columnSpan(1)->schema([

                        TextInput::make('code')->required(),

                        Select::make('customer_id')
                            ->label('Customer')
                            ->editOptionForm(Customer::getForm())
                            ->createOptionForm(Customer::getForm())
                            ->relationship('customer', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),

                        Textarea::make('notes'),
                        DatePicker::make('must_do_at')
                            ->label(__('must_do_at'))
                            ->native(false)
                            ->default(now()),
                        Forms\Components\Toggle::make('allUsers')->live(),
//                        Select::make('user')->options(function (Forms\Get $get){
//
//                            if (!$get('allUsers') && $get('location') !=null){
//
//                                return User::good($get('location')['place_id'])->pluck('name','id');
//                            }
//                            return User::pluck('name','id');
//                        })->searchable(),
//                        Forms\Components\CheckboxList::make('user')->options(fn()=>User::viewers())
                    ]),


                    Section::make()->columnSpan(2)->schema([
                        MapLocation::make('location')->columnSpanFull()
                            ->live()
                            ->afterStateUpdated(function($state, callable $get, callable $set){
                                $set('user',null);
                            }),

                        Section::make()->columns(2)->schema([
                            TextInput::make('lat')->columns(1),
                            TextInput::make('lng')->columns(1),
                        ])->collapsed()
                    ])->columnSpan(2),

                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('code')
                    ->searchable(),
                IconColumn::make('is_published')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('created_by')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('city.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('location.address')
                    ->numeric()
                    ->sortable()->limit('15'),
                TextColumn::make('received_at')
                    ->since()
                    ->sortable(),
                TextColumn::make('finished_at')
                    ->since()
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->toggleable(isToggledHiddenByDefault: true),


                Tables\Columns\ColorColumn::make('status.color')->view('tables.columns.status-label')
                ,
                TextColumn::make('viewer.name')
                    ->label(__('Viewer'))
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_published')->label('Published'),
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
            'index' => \App\Filament\Resources\TaskResource\Pages\ListTasks::route('/'),
            'create' => \App\Filament\Resources\TaskResource\Pages\CreateTask::route('/create'),
            'edit' => \App\Filament\Resources\TaskResource\Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
