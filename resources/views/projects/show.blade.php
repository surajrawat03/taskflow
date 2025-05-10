<x-app-layout>
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-900 mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold">{{ $project->name }}</h1>
                    <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $project->status === 'completed' ? 'bg-green-100 text-green-800' : ($project->status === 'on_hold' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                        {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                    </span>
                </div>
                @if($project->description)
                    <p class="mt-1 text-sm text-gray-600">{{ $project->description }}</p>
                @endif
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('projects.edit', $project->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Edit Project
                </a>
                <button type="button" id="new-task-button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    New Task
                </button>
            </div>
        </div>
        
        <div class="mt-4">
            <div class="bg-white shadow-sm rounded-lg p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Created</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $project->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Last Updated</h3>
                        <p class="mt-1 text-sm text-gray-900">{{ $project->updated_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Progress</h3>
                        <div class="mt-1 flex items-center">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $project->progress ?? 0 }}%"></div>
                            </div>
                            <span class="ml-4 text-sm text-gray-600">{{ $project->progress ?? 0 }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Task Creation Form Modal -->
    <div id="task-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Create New Task</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                @livewire('task-form', ['project_id' => $project->id, 'created_by' => auth()->user()->id])
            </div>
        </div>
    </div>
    
    <!-- Task List -->
    @livewire('project-task', ['projectId' => $project->id])
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('task-modal');
            const newTaskButton = document.getElementById('new-task-button');
            
            newTaskButton.addEventListener('click', function() {
                modal.classList.remove('hidden');
            });
            
            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
            
            // Livewire event handlers
            window.addEventListener('task-created', function(e) {
                // Close modal and show toast
                modal.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>