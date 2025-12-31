<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shop Medicines') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($medicines as $medicine)

                            <div class="border dark:bg-gray-800 dark:border-gray-700 rounded-lg overflow-hidden shadow-lg flex flex-col">
                                <a href="{{ route('shop.show', $medicine) }}">
                                    <img src="{{ $medicine->image ? asset('storage/' . $medicine->image) : 'https://via.placeholder.com/300' }}" alt="{{ $medicine->name }}" class="w-full h-48 object-cover">
                                </a>
                                <div class="p-4 flex flex-col flex-grow">
                                    <h3 class="font-semibold text-lg">{{ $medicine->name }}</h3>
                                    <div class="mt-4 flex justify-between items-center pt-4 border-t dark:border-gray-700 mt-auto">
                                        <span class="font-bold text-xl">₹{{ $medicine->price }}</span>
                                        
                                        @if($medicine->stock > 0)
                                            <form action="{{ route('cart.add', $medicine) }}" method="POST">
                                                @csrf
                                                <input type="hidden" class="text-black" name="quantity" value="1">
                                                <x-primary-button type="submit">Add to Cart</x-primary-button>
                                            </form>
                                        @else
                                            <span class="px-3 py-1 bg-gray-400 text-white rounded text-sm">Out of Stock</span>
                                        @endif
                                    </div>
                                </div>
                            </div>                            
                        @endforeach
                    </div>
                    
                    <div class="mt-8">
                        {{ $medicines->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>