<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tasks</h1>
        <p class="mt-1 text-sm text-gray-600">Manage and organize your tasks by project</p>
    </div>
    
    @livewire('task-list', ['projects' => $projects])
</x-app-layout>
