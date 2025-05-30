<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;
use Livewire\WithPagination;

class ProjectTask extends Component
{
    use WithPagination;
    public $projectId;
    public $search = '';
    public $status = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $listeners = ['taskCreated' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    /**
     * @param string
     */
    public $statuses;

    public function mount()
    {
        $this->statuses = Task::statuses();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        
        $this->sortField = $field;
    }
    
    public function toggleTaskStatus($taskId)
    {
        $task = Task::find($taskId);
        if ($task && $task->project_id == $this->projectId) {
            $task->is_completed = !$task->is_completed;
            $task->status = !$task->is_completed ? $task::STATUS_IN_PROGRESS : $task::STATUS_COMPLETED;
            $task->save();
        }
    }

    public function render()
    {
        $query = Task::query()
            ->where('project_id', $this->projectId)
            ->when($this->search, function ($query) {
                return $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                return $query->where('status', $this->status);
            })
          ->orderBy($this->sortField, $this->sortDirection);
        
        $tasks = $query->paginate(5);
        return view('livewire.project-task',compact('tasks'));
    }
}
