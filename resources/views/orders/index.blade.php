<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-white tracking-tighter uppercase italic">
                    {{ __('My Order History') }}
                </h2>
                <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest mt-1">
                    Track and manage your healthcare deliveries
                </p>
            </div>
            @if(!$orders->isEmpty())
                <div class="bg-emerald-500/10 px-4 py-2 rounded-2xl border border-emerald-500/20">
                    <span class="text-emerald-500 font-black text-xs uppercase tracking-widest">
                        Total Orders: {{ $orders->total() }}
                    </span>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                
                @if($orders->isEmpty())
                    <div class="text-center py-24 px-6">
                        <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tighter italic">
                            Your bag is empty
                        </h3>
                        <p class="mt-2 text-gray-500 font-medium max-w-xs mx-auto">
                            You haven't placed any orders yet. Explore our pharmacy for your healthcare needs.
                        </p>
                        <a href="{{ route('shop.index') }}" class="mt-8 inline-flex items-center px-8 py-4 bg-emerald-500 hover:bg-emerald-400 text-gray-950 font-black rounded-2xl transition-all shadow-lg shadow-emerald-500/20 transform hover:-translate-y-1">
                            Start Shopping
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 dark:bg-gray-800/50">
                                <tr>
                                    <th class="px-8 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest">Order ID</th>
                                    <th class="px-6 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest">Date</th>
                                    <th class="px-6 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest">Status</th>
                                    <th class="px-6 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest">Total Amount</th>
                                    <th class="px-8 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-all group">
                                        <td class="px-8 py-6">
                                            <span class="text-indigo-600 dark:text-indigo-400 font-black text-lg">
                                                #{{ $order->id }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-6">
                                            <div class="text-gray-900 dark:text-white font-bold">{{ $order->created_at->format('M d, Y') }}</div>
                                            <div class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">{{ $order->created_at->format('h:i A') }}</div>
                                        </td>

                                        <td class="px-6 py-6">
                                            @php
                                                $statusStyles = [
                                                    'shipped'             => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                                    'completed'           => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                                    'cancelled'           => 'bg-red-500/10 text-red-500 border-red-500/20',
                                                    'pending_prescription' => 'bg-orange-500/10 text-orange-600 border-orange-500/20',
                                                    'processing'          => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                                                    'default'             => 'bg-gray-500/10 text-gray-500 border-gray-500/20',
                                                ];
                                                $style = $statusStyles[$order->status] ?? $statusStyles['default'];
                                            @endphp
                                            <span class="px-4 py-1.5 rounded-xl border text-[10px] font-black uppercase tracking-widest {{ $style }}">
                                                {{ str_replace('_', ' ', $order->status) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-6">
                                            <div class="text-gray-900 dark:text-white font-black text-lg italic tracking-tighter">
                                                ₹{{ number_format($order->total_amount, 2) }}
                                            </div>
                                        </td>

                                        <td class="px-8 py-6 text-right">
                                            <a href="{{ route('orders.show', $order) }}" 
                                               class="inline-flex items-center px-6 py-3 bg-gray-900 dark:bg-emerald-600 text-white dark:text-gray-950 text-xs font-black uppercase tracking-widest rounded-xl hover:scale-105 transition-transform shadow-lg">
                                                View Details
                                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($orders->hasPages())
                        <div class="px-8 py-8 bg-gray-50 dark:bg-gray-800/30 border-t dark:border-gray-800">
                            {{ $orders->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>