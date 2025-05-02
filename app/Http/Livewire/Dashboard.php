<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalTasks;
    public $completedTasks;
    public $pendingTasks;
    public $recentTasks;

    // public function mount()
    // {
    //     $this->totalTasks = Task::where('user_id', auth()->id())->count();
    //     $this->completedTasks = Task::where('user_id', auth()->id())->where('status', 'completed')->count();
    //     $this->pendingTasks = Task::where('user_id', auth()->id())->where('status', 'pending')->count();
    //     $this->recentTasks = Task::where('user_id', auth()->id())->latest()->take(5)->get();
    // }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
