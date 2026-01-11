<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-white tracking-tighter uppercase italic">
                    {{ __('Your Medical Bag') }}
                </h2>
                <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest mt-1">
                    Review your items before clinical checkout
                </p>
            </div>
            <a href="{{ route('shop.index') }}" class="group text-gray-400 hover:text-white transition-all text-sm font-bold flex items-center">
                <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Continue Shopping
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 rounded-2xl font-bold flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-8 p-4 bg-red-500/10 border border-red-500/20 text-red-500 rounded-2xl font-bold flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            @if ($cartItems->isEmpty())
                <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 p-20 text-center">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tighter italic">Your bag is empty</h3>
                    <p class="mt-2 text-gray-500 font-medium">Add some items to your cart to see them here.</p>
                    <a href="{{ route('shop.index') }}" class="mt-8 inline-flex items-center px-8 py-4 bg-emerald-500 hover:bg-emerald-400 text-gray-950 font-black rounded-2xl transition-all shadow-lg shadow-emerald-500/20 transform hover:-translate-y-1">
                        Go to Shop
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                            <div class="p-8 md:p-10">
                                <h3 class="text-lg font-black mb-8 uppercase tracking-widest text-emerald-500 flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    Item Manifest
                                </h3>

                                <div class="space-y-6">
                                    @foreach ($cartItems as $item)
                                        <div class="flex flex-col sm:flex-row items-center justify-between p-5 bg-gray-50 dark:bg-gray-800/50 rounded-3xl border border-gray-100 dark:border-gray-700 group hover:border-emerald-500/30 transition-all">
                                            <div class="flex items-center space-x-5 mb-4 sm:mb-0">
                                                <div class="relative shrink-0">
                                                    <img src="{{ $item->medicine->image ? asset('storage/' . $item->medicine->image) : 'https://via.placeholder.com/100' }}" 
                                                         class="w-20 h-20 rounded-2xl object-cover shadow-md group-hover:scale-105 transition duration-500">
                                                    @if($item->medicine->prescription_required)
                                                        <span class="absolute -top-2 -left-2 bg-red-500 text-white text-[8px] font-black px-2 py-1 rounded-lg shadow-lg uppercase">Rx</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-black text-gray-900 dark:text-white uppercase tracking-tighter italic text-lg leading-tight">{{ $item->medicine->name }}</p>
                                                    <p class="text-xs text-emerald-500 font-black uppercase tracking-widest mt-1">₹{{ number_format($item->medicine->price, 2) }} / unit</p>
                                                </div>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center bg-white dark:bg-gray-900 rounded-xl p-1 border border-gray-200 dark:border-gray-700">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->medicine->stock }}" 
                                                           class="w-16 border-none bg-transparent text-center font-bold dark:text-white focus:ring-0 text-sm" />
                                                    <button type="submit" class="p-2 text-emerald-500 hover:bg-emerald-500 hover:text-white rounded-lg transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                    </button>
                                                </form>

                                                <div class="text-right min-w-[100px]">
                                                    <p class="text-lg font-black text-gray-900 dark:text-white italic tracking-tighter">₹{{ number_format($item->medicine->price * $item->quantity, 2) }}</p>
                                                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-[10px] font-black text-red-500 uppercase tracking-widest hover:underline mt-1">Remove</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 p-8 lg:sticky lg:top-8">
                            <h3 class="text-xs font-black mb-6 uppercase tracking-widest text-emerald-500">Cart Summary</h3>
                            
                            <div class="space-y-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500 font-bold">Items Subtotal</span>
                                    <span class="text-gray-900 dark:text-white font-black italic">₹{{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500 font-bold">Logistics / Tax</span>
                                    <span class="text-gray-400 font-bold uppercase text-[10px]">Calculated Next</span>
                                </div>
                                
                                <div class="pt-6 border-t border-gray-100 dark:border-gray-800 flex flex-col items-center">
                                    <span class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-1">Estimated Total</span>
                                    <span class="text-5xl font-black text-gray-900 dark:text-white italic tracking-tighter">₹{{ number_format($total, 2) }}</span>
                                </div>

                                <a href="{{ route('checkout.index') }}" 
                                   class="mt-8 flex items-center justify-center w-full py-5 bg-emerald-500 hover:bg-emerald-400 text-gray-950 font-black rounded-2xl shadow-xl transition-all hover:scale-105 group text-xs uppercase tracking-widest">
                                    Proceed to Checkout
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>

                                <p class="text-[10px] text-gray-400 text-center mt-4 font-medium uppercase tracking-widest leading-relaxed">
                                    Safe & Secure Payments <br> Authenticity Guaranteed
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </div>
</x-app-layout>