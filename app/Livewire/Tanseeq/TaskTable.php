<?php

namespace App\Livewire\Tanseeq;

use App\Filament\Resources\TaskResource\Pages\ListTasks;
use Filament\Facades\Filament;
use Livewire\Attributes\On;
use Livewire\Component;

//use View;

class TaskTable extends Component
{
    public function render()
    {
        return view('livewire.tanseeq.task-table');
    }
    public $time;

    #[On('echo:tasks,tasks')]
    public function up()
    {
        $this->time=now();
    }

    public function mount()
    {
        $this->up();
    }
}
