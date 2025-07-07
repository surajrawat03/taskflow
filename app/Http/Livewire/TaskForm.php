<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Cookie;  

class TaskForm extends Component
{
    /**
     * @param int
     */
    public $project_id;

    /**
     * @param int
     */
    public $created_by;

    /**
     * @param string
     */
    public $title;

    /**
     * @param string
     */
    public $description;

    /**
     * @param string
     */
    public $due_date;
    
    /**
     * @param string
     */
    public $priority = Task::PRIORITIES_LOW;

    /**
     * @param string
     */
    public $status = Task::STATUS_TODO;

    /**
     * @param int
     */
    public $user_id;

    /**
     * Store a newly created task.
     */
    public function createTask()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'priority' => 'required|string',
            'status' => 'required|string'
        ]);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'priority' => $this->priority,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'project_id' => $this->project_id
        ];

        Task::create($data);

        // Generate a JWT for the authenticated user
        $token = JWTAuth::refresh(JWTAuth::getToken());

        // Queue a secure, HttpOnly cookie
        Cookie::queue(
            Cookie::make(
                'jwt',
                $token,
                JWTAuth::factory()->getTTL(), // minutes
                '/',                           // path
                null,                          // domain
                true,                          // secure
                true,                          // httpOnly
                false,                         // raw
                'Strict'                       // sameSite
            )
        );

        // Plain redirect — Laravel will include the queued cookie
        // return $this->redirectRoute('projects.index');
        $this->reset(['title', 'description', 'due_date', 'priority']);
    
        $this->emit('taskCreated');
        $this->dispatchBrowserEvent('task-created');
        
        session('success', 'Task created successfully.');
    }

    public function render()
    {
        
        $priorities = Task::priorities();
        $statuses = Task::statuses();
        return view('livewire.task-form', compact('priorities', 'statuses'));
    }
}
