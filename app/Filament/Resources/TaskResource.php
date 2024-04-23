<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages\CreateTask;
use App\Filament\Resources\TaskResource\Pages\EditTask;
use App\Filament\Resources\TaskResource\Pages\ListTasks;
use App\Filament\Resources\TaskResource\Pages\ViewTask;
use App\Forms\Components\MapLocation;
use App\Models\Customer;
use App\Models\Map\Polygon;
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
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
                            ->default(now()->add(10, 'hours')),
                        Forms\Components\Toggle::make('allUsers')
                            ->live()
                            ->afterStateUpdated(function ($state,$set) {
//                                dump($state);
                                if ($state){

                                    $set('users',Filament::getTenant()->viewers()->pluck( 'id')->toArray());
                                }
                            })
                        ,

                        Forms\Components\CheckboxList::make('users')
                            ->columns(2)
                            ->live()

                            ->relationship('users')
                            ->options(function ($get, $operation, ?Task $record) {
                                if ($operation == 'view') {
                                    return $record->allowedViewers()->get()->pluck('name', 'id');
                                }
                                if ($get('allUsers')) {
                                    return Filament::getTenant()->viewers()->pluck('name', 'id');
                                }
                                if ($location = $get('location') and array_key_exists('lat', $location) and array_key_exists('lng', $location)) {
                                    $a = Polygon::getPointPlaceIds($location['lat'], $location['lng']);
                                    $a = $a->map(function ($place_id) {
                                        return User::wherePlaceId($place_id)->pluck('name', 'id');
                                    })->flatten()->toArray();

                                    return $a;
                                }

                                return [];
                            })
                                                    ->searchable()
                        ,
                    ]),

                    Section::make()->columnSpan(2)->schema([
                        MapLocation::make('location')->columnSpanFull()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                //                            $set('user',null);
                                //                            $a = Filament::getTenant()->viewers();
                                //    dump($state);

                                // dump($state);
                            }),

                        Section::make()->columns(2)->schema([
                            TextInput::make('lat')->columns(1),
                            TextInput::make('lng')->columns(1),
                        ])->collapsed(),
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
                    ->boolean()
                    ->falseIcon('heroicon-o-server-stack')
                    ->falseColor('primary')
                    ->disabledClick(fn ($state) => $state),
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
                TextColumn::make('received_at')
                    ->since()
                    ->sortable(),
                TextColumn::make('must_do_at')
                    ->since(),

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
                TextColumn::make('viewer.name')
                    ->label(__('Viewer'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('publish')
                    ->action(function (Task $record) {
                        $record->publish();
                        Notification::make()
                            ->title('Task Published Successfully')->success()->send();

                    })
                    ->requiresConfirmation()
                    ->hidden(fn ($record) => $record->is_published)
                    ->icon('heroicon-s-map'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->headerActions([
                Tables\Actions\CreateAction::make(),
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
            'index'  => ListTasks::route('/'),
            'create' => CreateTask::route('/create'),
            'edit'   => EditTask::route('/{record}/edit'),
            'view'   => ViewTask::route('/{record}/view'),
        ];
    }
}
