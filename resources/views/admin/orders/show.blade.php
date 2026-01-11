<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-white tracking-tighter uppercase italic">
                    {{ __('Order Detail') }}: <span class="text-indigo-400">#{{ $order->id }}</span>
                </h2>
                <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest mt-1">
                    System Timestamp: {{ $order->created_at->format('d M Y - H:i') }}
                </p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-gray-400 hover:text-white transition-all text-sm font-bold flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Logistics
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
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                Manifest Items
                            </h3>

                            <div class="space-y-6">
                                @foreach ($order->items as $item)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700 group hover:border-emerald-500/30 transition-all">
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ $item->medicine->image ? asset('storage/' . $item->medicine->image) : 'https://via.placeholder.com/100' }}" 
                                                 class="w-16 h-16 rounded-xl object-cover shadow-sm group-hover:scale-105 transition duration-500">
                                            <div>
                                                <p class="font-black text-gray-900 dark:text-white uppercase tracking-tighter italic">{{ $item->medicine->name }}</p>
                                                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">
                                                    {{ $item->quantity }} Units × ₹{{ number_format($item->price, 2) }}
                                                </p>
                                                @if($item->medicine->prescription_required)
                                                    <span class="mt-1 inline-block text-[10px] font-black text-red-500 uppercase tracking-widest bg-red-500/10 px-2 py-0.5 rounded">Rx Required</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xl font-black text-gray-900 dark:text-white italic">₹{{ number_format($item->quantity * $item->price, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-10 pt-8 border-t border-gray-100 dark:border-gray-800 flex justify-between items-center">
                                <span class="text-gray-400 font-bold uppercase tracking-widest text-sm">Grand Total</span>
                                <span class="text-4xl font-black text-emerald-500 italic tracking-tighter">₹{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    @if($order->status == 'pending_approval' || $order->prescriptions->isNotEmpty())
                        <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 p-8 md:p-10">
                            <h3 class="text-lg font-black mb-8 uppercase tracking-widest text-red-500 flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Clinical Verification
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($order->prescriptions as $prescription)
                                    <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-[2rem] border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
                                        <div class="relative z-10">
                                            <div class="flex items-center justify-between mb-4">
                                                <span class="text-[10px] font-black uppercase tracking-widest {{ $prescription->status == 'pending' ? 'text-orange-500' : 'text-emerald-500' }}">
                                                    Status: {{ $prescription->status }}
                                                </span>
                                            </div>
                                            
                                            <a href="{{ asset('storage/' . $prescription->file_path) }}" target="_blank" 
                                               class="block w-full bg-white dark:bg-gray-700 py-4 rounded-xl text-center text-sm font-bold text-indigo-500 hover:bg-indigo-500 hover:text-white transition-all shadow-sm mb-6">
                                                Inspect Document
                                            </a>

                                            @if($prescription->status == 'pending')
                                                <div class="flex space-x-3">
                                                    <form action="{{ route('admin.prescriptions.approve', $prescription) }}" method="POST" class="flex-1">
                                                        @csrf
                                                        <button class="w-full bg-emerald-500 hover:bg-emerald-400 text-gray-950 py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-emerald-500/20">Approve</button>
                                                    </form>
                                                    <form action="{{ route('admin.prescriptions.reject', $prescription) }}" method="POST" class="flex-1">
                                                        @csrf
                                                        <button class="w-full bg-red-500 hover:bg-red-400 text-white py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all shadow-lg shadow-red-500/20">Reject</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="space-y-8">
                    
                    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 p-8">
                        <h3 class="text-xs font-black mb-6 uppercase tracking-widest text-emerald-500">Retail Client</h3>
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center text-white text-xl font-black italic">
                                {{ strtoupper(substr($order->user->name ?? 'N', 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="text-lg font-black text-gray-900 dark:text-white tracking-tighter">{{ $order->user->name }}</h4>
                                <p class="text-xs text-gray-500 font-bold truncate">{{ $order->user->email }}</p>
                            </div>
                        </div>
                        <div class="space-y-4 pt-6 border-t border-gray-100 dark:border-gray-800">
                            <div class="flex justify-between">
                                <span class="text-xs font-bold text-gray-400 uppercase">Payment</span>
                                <span class="text-xs font-black text-gray-900 dark:text-white uppercase">{{ strtoupper($order->payment_method ?? 'N/A') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 p-8">
                        <h3 class="text-xs font-black mb-6 uppercase tracking-widest text-emerald-500">Operation Status</h3>
                        
                        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                            @csrf
                            <select name="status" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl text-gray-900 dark:text-white font-bold py-4 px-6 focus:ring-2 focus:ring-emerald-500 transition-all">
                                <option value="pending" @selected($order->status == 'pending')>Awaiting Payment</option>
                                <option value="pending_prescription" @selected($order->status == 'pending_prescription')>Awaiting RX Upload</option>
                                <option value="pending_approval" @selected($order->status == 'pending_approval')>Awaiting Clinical Approval</option>
                                <option value="processing" @selected($order->status == 'processing')>Processing (Picking)</option>
                                <option value="shipped" @selected($order->status == 'shipped')>Dispatched / Shipped</option>
                                <option value="delivered" @selected($order->status == 'delivered')>Delivered</option>
                                <option value="cancelled" @selected($order->status == 'cancelled')>Terminated / Cancelled</option>
                            </select>

                            <button type="submit" class="w-full mt-6 bg-gray-900 dark:bg-emerald-500 text-white dark:text-gray-950 py-5 rounded-2xl font-black uppercase tracking-widest text-xs transition-all shadow-lg transform hover:-translate-y-1 active:scale-95">
                                Update Logistics Phase
                            </button>
                        </form>
                    </div>

                    <div class="p-2">
                        <a href="{{ route('admin.orders.index') }}" class="block w-full text-center py-4 bg-gray-100 dark:bg-gray-800 rounded-2xl text-gray-500 font-bold hover:text-emerald-500 transition-all text-xs uppercase tracking-widest">
                            Exit Inspection
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>