<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Details #') }}{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="md:col-span-2 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold">Order Items</h3>
                    <ul class="mt-4 divide-y dark:divide-gray-700">
                        @foreach ($order->items as $item)
                            <li class="py-2 flex justify-between items-center">
                                <div>
                                    <p class="font-semibold">{{ $item->medicine->name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Qty: {{ $item->quantity }} x ₹{{ $item->price }}</p>
                                    @if($item->medicine->prescription_required)
                                        <span class="text-xs font-bold text-red-500">Requires Prescription</span>
                                    @endif
                                </div>
                                <span class="font-semibold">₹{{ number_format($item->quantity * $item->price, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-4 pt-4 border-t dark:border-gray-700 text-right">
                        <strong class="text-xl">Total: ₹{{ $order->total_amount }}</strong>
                    </div>
                </div>
            </div>

            <div classs="space-y-6">
                <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold">Customer</h3>
                        <p class="mt-2">{{ $order->user->name }}</p>
                        <p>{{ $order->user->email }}</p>
                    </div>
                </div>

                @if($order->status == 'pending_approval' || $order->prescriptions->isNotEmpty())
                <div class="mt-6 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold">Prescription Review</h3>
                        @foreach($order->prescriptions as $prescription)
                            <div class="mt-4 p-2 border dark:border-gray-700 rounded">
                                <a href="{{ asset('storage/' . $prescription->file_path) }}" target="_blank" class="text-blue-500 hover:underline">
                                    View Uploaded Prescription ({{ $prescription->status }})
                                </a>
                                @if($prescription->status == 'pending')
                                <div class="mt-4 flex space-x-2">
                                    <form action="{{ route('admin.prescriptions.approve', $prescription) }}" method="POST">
                                        @csrf
                                        <x-primary-button>Approve</x-primary-button>
                                    </form>
                                    <form action="{{ route('admin.prescriptions.reject', $prescription) }}" method="POST">
                                        @csrf
                                        <x-danger-button>Reject</x-danger-button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div class="mt-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold">Update Status</h3>
                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="mt-4">
                            @csrf
                            <select name="status" class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                <option value="pending" @selected($order->status == 'pending')>Pending Payment</option>
                                <option value="pending_prescription" @selected($order->status == 'pending_prescription')>Pending Prescription</option>
                                <option value="pending_approval" @selected($order->status == 'pending_approval')>Pending Approval</option>
                                <option value="processing" @selected($order->status == 'processing')>Processing</option>
                                <option value="shipped" @selected($order->status == 'shipped')>Shipped</option>
                                <option value="cancelled" @selected($order->status == 'cancelled')>Cancelled</option>
                            </select>
                            <x-primary-button class="mt-4">Update</x-primary-button>
                        </form>
                    </div>
                </div>
            </div>

            <div>
                <a href="{{ route('admin.orders.index') }}">
                    <x-primary-button class="mt-6 px-4">Back</x-primary-button>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>