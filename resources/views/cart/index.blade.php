<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($cartItems->isEmpty())
                        <p>Your cart is empty.</p>
                        <a href="{{ route('shop.index') }}" class="mt-4 inline-block text-blue-600 dark:text-blue-400 hover:underline">
                            Continue Shopping
                        </a>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-white uppercase tracking-wider">Product</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-white uppercase tracking-wider">Price</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-white uppercase tracking-wider">Quantity</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-white uppercase tracking-wider">Total</th>
                                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium">{{ $item->medicine->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">${{ number_format($item->medicine->price, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form action="{{ route('cart.update', $item) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <x-text-input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->medicine->stock }}" class="w-20" />
                                                    <x-secondary-button type="submit" class="ml-2">Update</x-secondary-button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">₹{{ number_format($item->medicine->price * $item->quantity, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <div class="w-full max-w-md p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <h3 class="text-lg font-bold">Cart Summary</h3>
                                <div class="mt-4 flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-300">Subtotal</span>
                                    <span class="font-medium">₹{{ number_format($total, 2) }}</span>
                                </div>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Shipping and taxes calculated at checkout.</p>
                                
                                {{-- THIS IS THE NEW LINK --}}
                                <a href="{{ route('checkout.index') }}" 
                                    class="mt-6 inline-flex items-center justify-center w-full px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





