<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages\CreateTask;
use App\Filament\Resources\TaskResource\Pages\EditTask;
use App\Filament\Resources\TaskResource\Pages\ListTasks;
use App\Filament\Resources\TaskResource\Pages\ViewTask;
use App\Forms\Components\MapLocation;
use App\Models\Customer;
use App\Models\Task;
use App\Models\User;
use Filament\Facades\Filament;
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
use Illuminate\Contracts\Support\Htmlable;

//use App\Filament\Resources\TaskResource\RelationManagers;

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
                            ->default(now()->add(10,'hours')),
                        Forms\Components\Toggle::make('allUsers')->live(),
//                        Select::make('user')->options(function (Forms\Get $get){
//
//                            if (!$get('allUsers') && $get('location') !=null){
//
//                            return User::good($get('location')['place_id'])->pluck('name','id');
//                            }
//                            return User::pluck('name','id');
//                        })->searchable(),
                        Forms\Components\CheckboxList::make('users')
                            ->live()
                            ->options(function ($get){
                                if ($get('allUsers'))return Filament::getTenant()->viewers()->pluck('name','id');
                                if ($location=$get('location') and key_exists('place_id',$location)){
                                    $place_id=$location['place_id'];
                                    $u=User::wherePlaceId($place_id)->pluck('name','id');
                                    return $u;
                                }
//                            return
                                return [];
                        })->searchable()
                    ]),


                    Section::make()->columnSpan(2)->schema([
                        MapLocation::make('location')->columnSpanFull()
                        ->live()
                        ->afterStateUpdated(function($state, callable $get, callable $set){
//                            $set('user',null);
//                            $a = Filament::getTenant()->viewers();
                        //    dump($state);


                            // dump($state);
                        })
                        ,

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
                    ->sortable()
                ,
                TextColumn::make('created_by')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('city.name')
                    ->numeric()
                    ->sortable(),
//                TextColumn::make('location.address')
//                    ->numeric()
//                    ->sortable()->limit('15'),
                TextColumn::make('received_at')
                    ->since()
                    ->sortable(),
                TextColumn::make('must_do_at')
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


//                Tables\Columns\ColorColumn::make('status.color')->view('tables.columns.status-label')
//                ,
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
            ])->headerActions([
                Tables\Actions\CreateAction::make()
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
            'index' => ListTasks::route('/'),
            'create' => CreateTask::route('/create'),
            'edit' => EditTask::route('/{record}/edit'),
            'view' => ViewTask::route('/{record}/view'),
        ];
    }
}
