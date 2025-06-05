<x-app-layout>
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold">Team</h1>
        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            Invite Team Member
        </button>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Team Members
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Manage your team members and their access rights.
            </p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-4 border-b border-gray-200">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" class="focus:ring-indigo-500 border p-2 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Search team members...">
                </div>
            </div>
@php
    $roles = ['Admin', 'Manager', 'Member'];
    $members = collect(range(1, 6))->map(function ($i) use ($roles) {
        return [
            'name' => 'Team Member ' . $i,
            'email' => 'team' . $i . '@example.com',
            'role' => $roles[$i % 3],
            'initial' => chr(64 + $i),
            'joined' => rand(1, 12),
        ];
    });
@endphp
            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @for ($i = 1; $i <= 6; $i++)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 font-semibold text-lg">
                                    {{ chr(64 + $i) }}
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">Team Member {{ $i }}</h3>
                                    <p class="text-sm text-gray-500">team{{ $i }}@example.com</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $i % 3 === 0 ? 'bg-green-100 text-green-800' : ($i % 2 === 0 ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                                    {{ $i % 3 === 0 ? 'Admin' : ($i % 2 === 0 ? 'Manager' : 'Member') }}
                                </span>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 bg-gray-50 px-5 py-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Joined {{ rand(1, 12) }} months ago</span>
                                <div class="flex space-x-2">
                                    <button class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</button>
                                    <button class="text-red-600 hover:text-red-900 text-sm font-medium">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Pending Invitations
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Team members who have been invited but haven't joined yet.
            </p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            @php
    $pendingInvites = collect(range(1, 3))->map(function ($i) {
        return [
            'email' => "pending{$i}@example.com",
            'invited_days_ago' => rand(1, 10),
        ];
    });
@endphp

             <ul class="divide-y divide-gray-200">
                @for ($i = 1; $i <= 3; $i++)
                    <li class="py-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">pending{{ $i }}@example.com</p>
                                <p class="text-sm text-gray-500">Invited {{ rand(1, 10) }} days ago</p>
                            </div>
                        </div>
                        <div>
                            <button class="text-indigo-600 hover:text-indigo-900 text-sm font-medium mr-4">Resend</button>
                            <button class="text-red-600 hover:text-red-900 text-sm font-medium">Cancel</button>
                        </div>
                    </li>
                @endfor
            </ul>
        </div>
    </div>
</x-app-layout>
