<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Successful!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold text-green-600 dark:text-green-400">Thank you for your order!</h3>
                    <p class="mt-2">Your order (ID: {{ $order->id }}) has been placed successfully.</p>
                    <p>An email confirmation will be sent to you shortly.</p>

                    <div class="mt-8">
                        <h4 class="text-lg font-semibold">Order Summary</h4>
                        <ul class="mt-4 space-y-2 divide-y dark:divide-gray-700">
                            @foreach ($order->items as $item)
                                <li class="py-2 flex justify-between">
                                    <span>{{ $item->medicine->name }} (x{{ $item->quantity }})</span>
                                    <span>₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-4 pt-4 border-t dark:border-gray-700 flex justify-between font-bold text-xl">
                            <span>Total</span>
                            <span>₹{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('shop.index') }}" class="mt-8 inline-block text-blue-600 dark:text-blue-400 hover:underline">
                        &larr; Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center items-center p-6 flex-col">
        <h3 class="text-2xl font-bold text-green-600 dark:text-green-400">Thank you for your order!</h3>
        <p class="mt-2 text-orange-400">Your order (ID: {{ $order->id }}) has been placed successfully.</p>
            
        @if($order->status == 'pending_approval')
            <p class="font-semibold text-yellow-600 dark:text-yellow-400">Your order is now pending prescription approval by our team.</p>
        @endif
    </div>
   
</x-app-layout>