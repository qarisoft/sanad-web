<?php

namespace App\Livewire\Tanseeq;

use App\Filament\Resources\TaskResource\Pages\ListTasks;
use Filament\Notifications\Notification;
use Filament\Facades\Filament;
use Livewire\Attributes\On;
use Livewire\Component;
use function Symfony\Component\String\s;

//use View;

class TaskTable extends Component
{
    public ?array $red_data = [];
    public ?array $blue_data = [];
    public $a;
    public function render()
    {
        return view('livewire.tanseeq.task-table');
    }


//    #[On('echo:tasks,tasks')]
    public function up()
    {
        $this->update();

    }
    public function update(): void
    {
        $s = 10;
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
        $this->red_data = $tasks->filter(function ($a)use($s) {
            return $a['time'] < $s and $a['time'] > 0;
        })->toArray();
        $this->blue_data = $tasks->filter(function ($a)use ($s) {
            return $a['time'] > $s and $a['time'] < 48;
        })->toArray();
    }

    public function mount()
    {
        $this->update();
    }
}
