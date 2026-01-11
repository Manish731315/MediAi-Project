<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Account Settings') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Section 1: Profile Information --}}
            <div class="p-6 sm:p-10 bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 sm:rounded-xl transition-all">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Section 2: Set Local Password (For Google/Social Users) --}}
            {{-- Logic: If password is null, it means they logged in via Social provider --}}
            @if (is_null(Auth::user()->password))
                <div class="p-6 sm:p-10 bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-900/30 shadow-sm sm:rounded-xl">
                    <div class="max-w-xl">
                        <header class="flex items-center gap-3">
                            <div class="p-2 bg-indigo-500 rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ __('Create Local Password') }}
                            </h2>
                        </header>
                        
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('You are currently using Google Login. Set a password if you want to log in directly with your email address in the future.') }}
                        </p>

                        <div class="mt-6">
                            <a href="{{ route('password.set') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-all shadow-md shadow-indigo-500/20">
                                {{ __('Set My Password') }}
                            </a>
                        </div>
                    </div>
                </div>
            @else
                {{-- Section 3: Update Existing Password --}}
                <div class="p-6 sm:p-10 bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 sm:rounded-xl transition-all">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            @endif

            {{-- Section 4: Danger Zone --}}
            <div class="p-6 sm:p-10 bg-white dark:bg-gray-900 shadow-sm border border-gray-200 dark:border-gray-800 sm:rounded-xl border-l-4 border-l-red-500">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>