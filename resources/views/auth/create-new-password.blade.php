<x-guest-layout>
    <div class="min-h-screen flex">
        <!-- Left side with illustration -->
        <div class="hidden lg:block lg:w-1/2 bg-indigo-600 relative">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-purple-600 opacity-90"></div>
            <div class="absolute inset-0 flex items-center justify-center p-12">
                <div class="text-white max-w-lg">
                    <svg class="w-20 h-20 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.104.896-2 2-2s2 .896 2 2v1h-4v-1zm-2 4h8v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2zm8-4V9a6 6 0 10-12 0v2a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2z" />
                    </svg>
                    <h1 class="text-4xl font-bold mb-4"><a href="{{route('welcome')}}">TaskMaster</a></h1>
                    <p class="text-xl mb-8">Set a new password to regain access to your account.</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-8 text-white text-center text-sm">
                &copy; {{ date('Y') }} TaskMaster. All rights reserved.
            </div>
        </div>

        <!-- Right side with new password form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center mb-10 lg:hidden">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-600 mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.104.896-2 2-2s2 .896 2 2v1h-4v-1zm-2 4h8v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2zm8-4V9a6 6 0 10-12 0v2a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold">TaskMaster</h1>
                </div>

                <div class="text-center mb-10">
                    <h2 class="text-3xl font-extrabold text-gray-900">Create New Password</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Please enter your new password below.
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-4 rounded-md bg-green-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-green-800">{{ session('status') }}</h3>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <ul class="text-sm font-medium text-red-800 list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form class="space-y-6" action="{{ route('password-reset-post', $token) }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <input id="email" name="email" type="email" required value="{{ old('email', $email ?? '') }}" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="you@example.com">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input id="password" name="password" type="password" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="New password">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Confirm new password">
                    </div>
                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.104.896-2 2-2s2 .896 2 2v1h-4v-1zm-2 4h8v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2zm8-4V9a6 6 0 10-12 0v2a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2z" />
                                </svg>
                            </span>
                            Set New Password
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        Remembered your password?
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Back to login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout> 