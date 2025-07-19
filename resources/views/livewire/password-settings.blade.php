<div>
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <form wire:submit.prevent="updatePassword" class="space-y-4">
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
            <input type="password" id="current_password" wire:model.defer="current_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2" />
            @error('current_password') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
            <input type="password" id="new_password" wire:model.defer="new_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2" />
            @error('new_password') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
            <input type="password" id="new_password_confirmation" wire:model.defer="new_password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2" />
            @error('new_password_confirmation') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Change Password</button>
    </form>
</div>
