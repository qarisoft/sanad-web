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
        return view('filament.pages.tanseeq.header');
    }

    protected static string $view = 'filament.pages.Tanseeq.index';

    public ?array $red_data = [];

    public ?array $blue_data = [];

    public $a;

    public function mount(): void
    {
        $this->update();
    }

//    #[On('echo:tasks,tasks')]
    public function go($event): void
    {
        dump($event);
//        $this->update();
    }

    public function getListeners(): array
    {
        return [
            "echo:tasks,tasks" => 'go',
        ];
    }

    public function update(): void
    {
        $this->a = ListTasks::getUrl();
        $tasks   = Filament::getTenant()->tasks()->published()->get()
            ->map(function ($a) {
                return
                    ['time' => now()
                        ->diffInHours(
                            $a->must_do_at
                        ),
                        'task' => $a,
                    ];
            });
        $this->red_data = $tasks->filter(function ($a) {
            return $a['time'] < 5 and $a['time'] > 0;
        })->toArray();
        $this->blue_data = $tasks->filter(function ($a) {
            return $a['time'] > 5 and $a['time'] < 48;
        })->toArray();
    }
}
