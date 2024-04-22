<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

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

    public function mount(): void
    {
        $t     = now()->add(-3, 'hours')->format('Y-m-d-H:i:s');
        $tasks = Filament::getTenant()->tasks()->published()->get()->map(function ($a) {
            return
                [
                    'time' => Carbon::now()
                        ->diffInMinutes(
                            Carbon::parse($a->must_do_at)
                        ),
                    'task' => $a,
                ];
        }); //->filter(fn($a)=>$a>0);

        $this->red_data = $tasks->filter(function ($a) {
            return $a['time'] <= 60*100;
        })->toArray();
        $this->blue_data = $tasks->filter(function ($a){
            return  60*100 < $a['time'] and $a['time'] < 140 * 60;
        } )->toArray();
            //    dump($tasks,
            //        $this->red_data,
            //        $this->blue_data
            //        );
    }
}
