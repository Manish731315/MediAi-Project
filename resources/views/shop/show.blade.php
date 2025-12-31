<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $medicine->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div classm="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div classm="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div>
                        <img src="{{ $medicine->image ? asset('storage/' . $medicine->image) : 'https://via.placeholder.com/600x400' }}" alt="{{ $medicine->name }}" class="w-full h-auto rounded-lg shadow-md">
                    </div>

                    <div class="flex flex-col justify-between">
                        <div>
                            <h1 class="text-3xl font-bold">{{ $medicine->name }}</h1>
                            <p class="text-lg text-gray-300 dark:text-gray-400 mt-2">{{ $medicine->category }}</p>
                            
                            @if($medicine->prescription_required)
                                <span class="mt-2 inline-block bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded-full dark:bg-red-900 dark:text-red-200">
                                    Requires Prescription
                                </span>
                            @else
                                <span class="mt-2 inline-block bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full dark:bg-green-900 dark:text-green-200">
                                    Over-the-Counter (OTC)
                                </span>
                            @endif

                            <p class="mt-6 text-base">{{ $medicine->description }}</p>
                        </div>

                        <div class="mt-8">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-4xl font-extrabold">₹{{ $medicine->price }}</span>
                                @if($medicine->stock > 0)
                                    <span class="text-green-600 dark:text-green-400 font-semibold">{{ $medicine->stock }} in stock</span>
                                @else
                                    <span class="text-red-600 dark:text-red-400 font-semibold">Out of stock</span>
                                @endif
                            </div>

                            @if($medicine->stock > 0)
                                <form action="{{ route('cart.add', $medicine) }}" method="POST">
                                    @csrf
                                    <div class="flex items-center space-x-4">
                                        <div>
                                            <x-input-label for="quantity" :value="__('Quantity')" class="sr-only" />
                                            <x-text-input id="quantity" name="quantity" type="number" value="1" min="1" max="{{ $medicine->stock }}" class="w-20 bg-orange-500 text-center border-none outline-none shadow-lg" required />
                                        </div>
                                        <x-primary-button type="submit" class="flex-1 justify-center py-3 text-base">
                                            {{ __('Add to Cart') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            @else
                                <button class="w-full text-center py-3 text-base bg-gray-500 text-white rounded-md cursor-not-allowed" disabled>
                                    Out of Stock
                                </button>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>