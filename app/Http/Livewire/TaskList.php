<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TaskList extends Component
{
    public $tasks = [];
    public function render()
    {
        return view('livewire.task-list');
    }
}
