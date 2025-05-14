<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class TaskList extends Component
{
    use WithPagination;
    public $projects = [];
    public $projectId;

    public function updatedProjectId()
    {
        $this->resetPage(); 
    }

    public function render()
    {
        $tasks = collect();
        if (!empty($this->projectId)) {
            $project = Project::find($this->projectId);
            $tasks = $project->tasks()->paginate(5) ?? collect();
        }
        return view('livewire.task-list', compact('tasks'));
    }
}
