<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Upload Prescription for Order #') }}{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <p class="mb-4">Your order requires a valid prescription for one or more items. Please upload a clear image (JPG, PNG) or PDF of your prescription to proceed. An admin will review it shortly.</p>

                    <form action="{{ route('prescription.store', $order) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <x-input-label for="prescription_file" :value="__('Prescription File')" />
                            <x-text-input id="prescription_file" name="prescription_file" type="file" class="mt-1 block w-full" required />
                        </div>

                        <div class="mt-6">
                            <x-primary-button>
                                {{ __('Upload and Submit for Review') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>