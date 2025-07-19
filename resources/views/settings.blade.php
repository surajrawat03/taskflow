<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">User Settings</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-xl font-semibold mb-4">Profile Information</h2>
                @livewire('profile-settings')
            </div>
            <div>
                <h2 class="text-xl font-semibold mb-4">Change Password</h2>
                @livewire('password-settings')
            </div>
        </div>
    </div>
</x-app-layout>