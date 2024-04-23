<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeader(): ?View
    {
        return view('filament.pages.Tanseeq.header');
    }

    protected static string $view = 'filament.pages.Tanseeq.index';


    public function mount(): void
    {
//        dump()
    }


}
