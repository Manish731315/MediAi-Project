<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-white tracking-tighter uppercase italic">
                    {{ __('Order Operations') }}
                </h2>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">
                    MediAI Real-time Fulfillment Center
                </p>
            </div>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.orders.export.pdf') }}"
                class="px-6 py-3 bg-blue-500 hover:bg-blue-400 text-white font-bold rounded-2xl shadow-lg">
                    Export PDF
                </a>

                <div class="bg-gray-800/50 px-4 py-2 rounded-2xl border border-gray-700">
                    <span class="text-[10px] text-gray-500 font-black uppercase block">Active Volume</span>
                    <span class="text-emerald-500 font-black text-lg">{{ $orders->total() }} Orders</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 rounded-2xl font-bold flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                
                @if ($orders->isEmpty())
                    <div class="p-20 text-center">
                        <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tighter italic">{{ __('Logistics Clear') }}</h3>
                        <p class="mt-2 text-gray-500 font-medium">{{ __('No pending or processed orders found in the system.') }}</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 dark:bg-gray-800/50">
                                <tr>
                                    <th class="px-8 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest">Order ID</th>
                                    <th class="px-6 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest">Customer</th>
                                    <th class="px-6 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest">Revenue</th>
                                    <th class="px-6 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest">Status</th>
                                    <th class="px-6 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest">Timeline</th>
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
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center font-bold text-gray-500 border border-gray-200 dark:border-gray-700">
                                                    {{ strtoupper(substr($order->user->name ?? 'N', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="text-gray-900 dark:text-white font-bold">{{ $order->user->name ?? 'Deleted User' }}</div>
                                                    <div class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Retail Client</div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-6">
                                            <div class="text-gray-900 dark:text-white font-black text-lg italic">
                                                ₹{{ number_format($order->total_amount, 2) }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-6">
                                            @php
                                                $statusStyles = [
                                                    'pending_approval'    => 'bg-yellow-500/10 text-yellow-600 border-yellow-500/20',
                                                    'pending_prescription' => 'bg-orange-500/10 text-orange-600 border-orange-500/20',
                                                    'shipped'             => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                                    'delivered'           => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                                    'cancelled'           => 'bg-red-500/10 text-red-500 border-red-500/20',
                                                    'processing'          => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                                                    'default'             => 'bg-gray-500/10 text-gray-500 border-gray-500/20',
                                                ];
                                                $style = $statusStyles[$order->status] ?? $statusStyles['default'];
                                            @endphp
                                            <span class="px-4 py-1.5 rounded-xl border text-[10px] font-black uppercase tracking-widest {{ $style }}">
                                                {{ str_replace('_', ' ', $order->status) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-6 text-gray-500 dark:text-gray-400 font-bold text-sm">
                                            {{ $order->created_at->format('M d, Y') }}
                                            <span class="block text-[10px] opacity-50">{{ $order->created_at->format('h:i A') }}</span>
                                        </td>

                                        <td class="px-8 py-6 text-right">
                                            <a href="{{ route('admin.orders.show', $order) }}" 
                                               class="inline-flex items-center px-5 py-2.5 bg-gray-900 dark:bg-emerald-600 text-white dark:text-gray-950 text-xs font-black uppercase tracking-widest rounded-xl hover:scale-105 transition-transform shadow-lg">
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