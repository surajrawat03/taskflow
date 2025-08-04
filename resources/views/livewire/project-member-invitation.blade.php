<div>
    <!-- Invitation Modal -->
    <div x-data="{ show: @entangle('showModal') }" 
         x-show="show" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
             @click="$wire.closeModal()"></div>
        
        <!-- Modal Content -->
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative w-full max-w-md transform overflow-hidden rounded-lg bg-white shadow-xl transition-all"
                 @click.stop>
                
                <!-- Header -->
                <div class="bg-white px-6 pt-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">Invite Team Member</h3>
                                <p class="text-sm text-gray-500">Send an invitation to join your team</p>
                            </div>
                        </div>
                        <button @click="$wire.closeModal()" 
                                class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Form -->
                <form wire:submit.prevent="sendInvitation" class="px-6 py-4">
                    <!-- Email Field -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address *
                        </label>
                        <div class="relative">
                            <input type="email" 
                                   id="email"
                                   wire:model.defer="email"
                                   placeholder="colleague@example.com"
                                   class="w-full rounded-md border border-gray-300 pl-10 pr-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-300 @enderror">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <div wire:loading wire:target="email" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="animate-spin h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Role Field -->
                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Role *
                        </label>
                        <select id="role" 
                                wire:model.defer="role"
                                class="w-full rounded-md border border-gray-300 py-2 pl-3 pr-10 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="member">Member</option>
                            <option value="manager">Manager</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <!-- Role Descriptions -->
                        <div class="mt-2 text-xs text-gray-500">
                            <div x-show="$wire.role === 'member'">Can view and manage assigned tasks</div>
                            <div x-show="$wire.role === 'manager'">Can manage projects and assign tasks to team members</div>
                            <div x-show="$wire.role === 'admin'">Full access to all projects and team management</div>
                        </div>
                    </div>
                    
                     <!-- Role Field -->
                    <div class="mb-4">
                        <label for="project_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Project *
                        </label>
                        <select id="project_id" 
                                wire:model.defer="project_id"
                                class="w-full rounded-md border border-gray-300 py-2 pl-3 pr-10 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Please Select Project</option>
                            @foreach ($projects as $project)
                                <option value="{{$project->id}}">{{$project->name}}</option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <!-- Role Descriptions -->
                        {{-- <div class="mt-2 text-xs text-gray-500">
                            <div x-show="$wire.role === 'member'">Can view and manage assigned tasks</div>
                            <div x-show="$wire.role === 'manager'">Can manage projects and assign tasks to team members</div>
                            <div x-show="$wire.role === 'admin'">Full access to all projects and team management</div>
                        </div> --}}
                    </div>

                    <!-- Message Field -->
                    <div class="mb-6">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Personal Message (Optional)
                        </label>
                        <textarea id="message"
                                  wire:model.defer="message"
                                  rows="3"
                                  placeholder="Add a personal message to the invitation..."
                                  class="w-full rounded-md border border-gray-300 py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500 resize-none @error('message') border-red-300 @enderror"></textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">{{ strlen($message ?? '') }}/500 characters</p>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" 
                                @click="$wire.closeModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </button>
                        <button type="submit"
                                wire:loading.attr="disabled"
                                wire:target="sendInvitation"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                            <span wire:loading.remove wire:target="sendInvitation">Send Invitation</span>
                            <span wire:loading wire:target="sendInvitation" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Sending...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
