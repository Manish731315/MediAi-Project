<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-white tracking-tighter uppercase italic">
                    {{ __('Order Summary') }} <span class="text-emerald-500">#{{ $order->id }}</span>
                </h2>
                <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest mt-1">
                    Placed on {{ $order->created_at->format('F d, Y • h:i A') }}
                </p>
            </div>
            <a href="{{ route('orders.index') }}" class="group text-gray-400 hover:text-white transition-all text-sm font-bold flex items-center">
                <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to History
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                        <div class="p-8 md:p-10">
                            <h3 class="text-lg font-black mb-8 uppercase tracking-widest text-emerald-500 flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                Package Contents
                            </h3>

                            <div class="space-y-6">
                                @foreach($order->items as $item)
                                    <div class="flex items-center justify-between p-5 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border border-gray-100 dark:border-gray-700 group hover:border-emerald-500/30 transition-all">
                                        <div class="flex items-center space-x-5">
                                            <div class="relative">
                                                <img src="{{ $item->medicine->image ? asset('storage/' . $item->medicine->image) : 'https://via.placeholder.com/100' }}" 
                                                     class="w-20 h-20 rounded-2xl object-cover shadow-md group-hover:scale-105 transition duration-500">
                                                @if($item->medicine->prescription_required)
                                                    <span class="absolute -top-2 -left-2 bg-red-500 text-white text-[8px] font-black px-2 py-1 rounded-lg shadow-lg uppercase">Rx</span>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-black text-gray-900 dark:text-white uppercase tracking-tighter italic text-lg leading-tight">{{ $item->medicine->name }}</p>
                                                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">
                                                    Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xl font-black text-gray-900 dark:text-white italic tracking-tighter">₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @if($order->status === 'pending_prescription')
                        <div class="bg-gradient-to-r from-orange-500 to-amber-600 rounded-[2.5rem] p-8 shadow-xl shadow-orange-500/20 flex flex-col md:flex-row items-center justify-between gap-6">
                            <div class="text-white flex items-center space-x-4">
                                <div class="bg-white/20 p-3 rounded-2xl">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-black uppercase tracking-tighter italic">Prescription Required</h4>
                                    <p class="text-orange-50 text-sm font-medium opacity-90">Please upload a valid doctor's prescription to proceed.</p>
                                </div>
                            </div>
                            <a href="{{ route('prescription.upload', $order->id) }}" class="w-full md:w-auto px-8 py-4 bg-white text-orange-600 font-black rounded-2xl text-xs uppercase tracking-widest hover:scale-105 transition-transform shadow-lg">
                                Upload Now
                            </a>
                        </div>
                    @endif
                </div>

                <div class="space-y-8">
                    
                    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 p-8">
                        <h3 class="text-xs font-black mb-6 uppercase tracking-widest text-emerald-500">Logistics Phase</h3>
                        <div class="flex items-center space-x-4 mb-8">
                            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center">
                                @if($order->status === 'shipped' || $order->status === 'completed')
                                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @else
                                    <svg class="w-6 h-6 text-orange-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0114 0z"></path></svg>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-gray-900 dark:text-white font-black uppercase tracking-widest text-xs">{{ str_replace('_', ' ', $order->status) }}</h4>
                                <p class="text-[10px] text-gray-500 font-bold uppercase mt-1">Current State</p>
                            </div>
                        </div>

                        <div class="space-y-4 pt-6 border-t border-gray-100 dark:border-gray-800">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 font-bold">Payment Method</span>
                                <span class="text-gray-900 dark:text-white font-black uppercase tracking-widest text-[10px]">{{ strtoupper($order->payment_method) }}</span>
                            </div>
                            @if($order->payment_id)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500 font-bold">Transaction ID</span>
                                    <span class="text-gray-900 dark:text-white font-mono text-[10px]">{{ substr($order->payment_id, 0, 12) }}...</span>
                                </div>
                            @endif
                            <div class="pt-6 flex flex-col items-center">
                                <span class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Total Paid</span>
                                <span class="text-4xl font-black text-gray-900 dark:text-white italic tracking-tighter">₹{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <a href="{{ route('orders.invoice', $order) }}" 
                           class="flex items-center justify-center w-full py-5 bg-gray-900 dark:bg-gray-800 text-white font-black rounded-2xl shadow-xl transition-all hover:bg-emerald-500 hover:scale-105 group text-xs uppercase tracking-widest">
                            <svg class="w-5 h-5 mr-3 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download Invoice (PDF)
                        </a>

                        <button onclick="window.print()" 
                                class="flex items-center justify-center w-full py-4 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-gray-500 font-bold rounded-2xl hover:text-emerald-500 transition-all text-xs uppercase tracking-widest">
                            Print Details
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>