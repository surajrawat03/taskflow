<div>
    {{-- Filters --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex flex-col md:flex-row gap-4 md:items-center">
            <!-- Project Selector -->
            <div class="w-full md:w-64">
                <div class="relative">
                    <select 
                        wire:model="projectId" 
                        id="project-selector" 
                        class="w-full border border-gray-300 rounded-md py-2 pl-3 pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                        <option value="">Select Project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="relative">
                <input 
                    type="text" 
                    placeholder="Search tasks..." 
                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            
            <div class="relative">
                <select 
                    wire:model="status" 
                    class="border border-gray-300 rounded-md py-2 pl-3 pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
                    <option value="">All Status</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
            
            <div class="flex items-center">
                <label for="showCompleted" class="ml-2 block text-sm text-gray-900">
                    <input 
                    type="checkbox" 
                    wire:model="showCompleted" 
                    id="showCompleted" 
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                > Show completed tasks
                </label>
            </div>
        </div>
        
        <div class="flex space-x-3">
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                New Task
            </a>
            
            @if($projectId)
                <a href="{{ route('projects.show', $projectId) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    View Project
                </a>
            @endif
        </div>
    </div>
    
    <!-- Main loading indicator for the entire component -->
    {{-- <div wire:loading wire:target="projectId, search, status, showCompleted, sortField, sortDirection" class="w-full flex justify-center my-8">
        <div class="flex flex-col items-center">
            <svg class="animate-spin h-10 w-10 text-indigo-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-sm text-gray-500">Loading tasks...</p>
        </div>
    </div> --}}

    <!-- Task list with loading state -->
    <div wire:loading.remove wire:target="projectId, search, status, showCompleted, sortField, sortDirection">
        @if($projectId)
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @forelse ($tasks as $task)
                        <li class="px-4 py-4 sm:px-6 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 relative">
                                        <button 
                                            wire:click="toggleTaskStatus({{ $task->id }})" 
                                            class="flex items-center justify-center h-8 w-8 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                        >
                                            @if ($task->is_completed)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif
                                        </button>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 {{ $task->is_completed ? 'line-through text-gray-500' : '' }}">
                                            {{ $task->title }}
                                        </div>
                                        @if ($task->description)
                                            <div class="text-sm text-gray-500 {{ $task->is_completed ? 'line-through' : '' }}">
                                                {{ Str::limit($task->description, 100) }}
                                            </div>
                                        @endif
                                        <div class="mt-1 flex items-center text-xs text-gray-500">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                                   ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                            
                                            @if ($task->due_date)
                                                <span class="ml-2 flex items-center {{ $task->is_due_soon ? 'text-red-500' : '' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $task->due_date->format('M d, Y') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>
                                    <button 
                                        type="button"
                                        class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500"
                                        data-delete-url="{{ route('tasks.destroy', $task->id) }}"
                                        data-resource-type="Task"
                                        data-redirect-url="{{ route('tasks.index', ['projectId' => $projectId]) }}"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-4 py-12 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No tasks found</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Get started by creating a new task.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('tasks.create', ['project_id' => $projectId]) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    New Task
                                </a>
                            </div>
                        </li>
                    @endforelse
                </ul>
                @if ($tasks->hasPages())
                    <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $tasks->links() }}
                    </div>
                @endif
            </div>
        @else
            <div class="bg-white shadow-sm rounded-lg p-6 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No project selected</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Please select a project to view its tasks or create a new project.
                </p>
                <div class="mt-6">
                    <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Create New Project
                    </a>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Skeleton loader for task list -->
    <div wire:loading wire:target="projectId, search, status, showCompleted, sortField, sortDirection" class="w-full bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @for ($i = 0; $i < 5; $i++)
                <li class="px-4 py-4 sm:px-6 animate-pulse">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-gray-200"></div>
                            </div>
                            <div class="ml-4">
                                <div class="h-4 bg-gray-200 rounded w-48 mb-2"></div>
                                <div class="h-3 bg-gray-200 rounded w-64"></div>
                                <div class="mt-2 flex items-center">
                                    <div class="h-5 bg-gray-200 rounded w-16"></div>
                                    <div class="ml-2 h-5 bg-gray-200 rounded w-24"></div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="h-5 w-5 bg-gray-200 rounded mr-4"></div>
                            <div class="h-5 w-5 bg-gray-200 rounded"></div>
                        </div>
                    </div>
                </li>
            @endfor
        </ul>
    </div>
</div>
