<x-app-layout>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <p class="mt-1 text-sm text-gray-600">Welcome back, {{ auth()->user()->name }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                New Task
            </a>
            <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                New Project
            </a>
        </div>
    </div>
    
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-2">
        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Projects</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $dashboardData['total_projects'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Tasks</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $dashboardData['total_tasks'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Completed Projects</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $dashboardData['completed_projects'] }}</div>
                            @if($dashboardData['total_projects'] > 0)
                                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                    {{ round(($dashboardData['completed_projects'] / $dashboardData['total_projects']) * 100) }}%
                                </p>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Completed Tasks</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $dashboardData['completed_tasks'] }}</div>
                            @if($dashboardData['total_tasks'] > 0)
                                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                    {{ round(($dashboardData['completed_tasks'] / $dashboardData['total_tasks']) * 100) }}%
                                </p>
                            @endif
                        </dd>
                    </dl>   
                </div>
            </div>
        </div>
    </div>
    
    <!-- Project Progress -->
    <div class="mt-8">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Project Progress</h2>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <ul class="divide-y divide-gray-200">
                @forelse($projects as $project)
                    <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('projects.show', $project->id) }}" class="hover:underline">
                                            {{ $project->name }}
                                        </a>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $project->tasks_count }} tasks
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="w-32 bg-gray-200 rounded-full h-2.5 mr-2">
                                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $project->tasks_count ? round($project->completed_tasks_count / $project->tasks_count * 100) : 0 }}%"></div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $project->tasks_count ? round($project->completed_tasks_count / $project->tasks_count * 100) : 0 }}%</span>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-6 text-center text-gray-500">
                        No projects found
                    </li>
                @endforelse
            </ul>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a href="{{ route('projects.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    View all projects <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>