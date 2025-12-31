<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('AI Chat Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="space-y-6">
                        @forelse ($logs as $log)
                            <div class="border-b dark:border-gray-700 pb-4">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold">{{ $log->user->name ?? 'Guest User' }}</span>
                                    <span class="text-sm text-gray-500">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="mt-2 space-y-2">
                                    <p><strong>User:</strong> {{ $log->symptoms_input }}</p>
                                    <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded">
                                        <p><strong>AI Response:</strong></p>
                                        <pre class="whitespace-pre-wrap text-sm">{{ json_encode(json_decode($log->ai_response), JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No chat logs found.</p>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>