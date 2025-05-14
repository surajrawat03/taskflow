<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class TaskList extends Component
{
    use WithPagination;
    public $projects = [];
    public $projectId;
    public $statuses = [];
    public $status;
    public $search;

    public function mount()
    {
        $this->statuses = Task::statuses();  // e.g. ['pending','completed',…]
    }

    public function updatedProjectId()
    {
        $this->resetPage(); 
    }

    public function render()
    {
        $tasks = collect();
        if (!empty($this->projectId)) {
            $query = Project::find($this->projectId)->tasks()->orderBy('due_date','asc');
            
             // apply status filter if one is selected
             if (!empty($this->status)) {
                $query->where('status', $this->status);
            }

            // apply search filter if one is selected
            if (!empty($this->search)) {
                $query->where('title', $this->search);
            }

            $tasks = $query->paginate(5) ?? collect();
        }
        return view('livewire.task-list', compact('tasks'));
    }
}
