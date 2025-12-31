<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Order Details #') }}{{ $order->id }}
            </h2>
            <a href="{{ route('orders.index') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400">&larr; Back to Orders</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 border-b dark:border-gray-700 pb-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Order Information</h3>
                            <p><span class="text-gray-500">Date:</span> {{ $order->created_at->format('F d, Y h:i A') }}</p>
                            <p><span class="text-gray-500">Status:</span> {{ ucfirst(str_replace('_', ' ', $order->status)) }}</p>
                            <p><span class="text-gray-500">Payment Method:</span> {{ strtoupper($order->payment_method) }}</p>
                            @if($order->payment_id)
                                <p><span class="text-gray-500">Transaction ID:</span> {{ $order->payment_id }}</p>
                            @endif
                        </div>
                        <div class="md:text-right">
                            <h3 class="text-lg font-semibold mb-2">Total Amount</h3>
                            <p class="text-3xl font-bold text-blue-600">₹{{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-4">Items Ordered</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Medicine</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Qty</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="font-medium">{{ $item->medicine->name }}</div>
                                            @if($item->medicine->prescription_required)
                                                <span class="text-xs text-red-500 font-bold">Prescription Item</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">₹{{ number_format($item->price, 2) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $item->quantity }}</td>
                                        <td class="px-6 py-4 text-right font-medium">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($order->status === 'pending_prescription')
                        <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <h4 class="font-bold text-yellow-800">Action Required</h4>
                            <p class="text-sm text-yellow-700 mb-3">This order contains items that require a prescription.</p>
                            <a href="{{ route('prescription.upload', $order->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 text-sm">
                                Upload Prescription
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>