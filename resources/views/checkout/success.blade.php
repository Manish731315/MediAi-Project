<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $order->payment_method == 'cod' ? __('Order Confirmed!') : __('Order Placed!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-8 text-center">
                    
                    {{-- LOGIC: Show Success Logo only for COD --}}
                    @if($order->payment_method == 'cod')
                        <div class="flex justify-center mb-6">
                            <div class="p-4 bg-green-100 dark:bg-green-900/30 rounded-full">
                                <svg class="w-16 h-16 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-3xl font-extrabold text-green-600 dark:text-green-400">Order Successful!</h3>
                    @else
                        {{-- LOGIC: Simple text for Online Payment --}}
                        <h3 class="text-3xl font-extrabold text-blue-600 dark:text-blue-400">Order Placed</h3>
                    @endif

                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                        Your order (ID: <span class="font-mono font-bold text-gray-900 dark:text-white">#{{ $order->id }}</span>) has been received.
                    </p>

                    @if($order->status == 'pending_approval')
                        <div class="mt-4 p-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg text-amber-700 dark:text-amber-400 text-sm">
                            <strong>Note:</strong> Your order is pending prescription approval by our medical team.
                        </div>
                    @endif

                    <hr class="my-8 border-gray-200 dark:border-gray-700">

                    {{-- Order Summary Table --}}
                    <div class="text-left">
                        <h4 class="text-lg dark:text-orange-400 font-semibold mb-4">Order Summary</h4>
                        <div class="space-y-3">
                            @foreach ($order->items as $item)
                                <div class="flex justify-between text-gray-700 dark:text-gray-300">
                                    <span>{{ $item->medicine->name }} <span class="text-sm text-gray-500">x{{ $item->quantity }}</span></span>
                                    <span class="font-medium">₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center font-bold text-2xl text-gray-900 dark:text-white">
                            <span>Total Amount</span>
                            <span class="text-green-600 dark:text-green-400">₹{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        
                        <div class="mt-2 text-sm text-gray-500">
                            Payment Method: <span class="uppercase">{{ $order->payment_method }}</span>
                        </div>
                    </div>

                    <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('orders.index') }}" class="px-6 py-3 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-lg font-semibold hover:bg-gray-700 transition">
                            View My Orders
                        </a>
                        <a href="{{ route('shop.index') }}" class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert Logic --}}
    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: "{{ $order->payment_method == 'cod' ? 'Success!' : 'Placed!' }}",
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Great!',
            confirmButtonColor: '#059669',
            background: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
            color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#000000',
        });
    </script>
    @endif
</x-app-layout>