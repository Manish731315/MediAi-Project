<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('MediAI Pharmacy') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="relative overflow-hidden bg-gradient-to-br from-indigo-900 via-blue-900 to-emerald-900 rounded-[2.5rem] mb-12 shadow-2xl group">
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition-all duration-700"></div>
                <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl group-hover:bg-blue-500/20 transition-all duration-700"></div>

                <div class="relative px-8 py-16 md:px-20 md:py-24 flex flex-col md:flex-row items-center justify-between">
                    <div class="text-center md:text-left z-10">
                        <span class="inline-block px-4 py-1.5 mb-6 text-xs font-bold tracking-widest text-emerald-400 uppercase bg-emerald-400/10 border border-emerald-400/20 rounded-full">
                            ✨ AI-Powered Healthcare
                        </span>
                        <h1 class="text-5xl md:text-6xl font-black text-white mb-6 leading-tight">
                            Smart Pharmacy for <br> <span class="text-emerald-400 italic">Smart Living.</span>
                        </h1>
                        <p class="text-blue-100 text-lg max-w-lg mb-8 opacity-80">
                            Upload your prescription and let our AI handle the rest. Authenticity guaranteed, delivered in 60 minutes.
                        </p>
                        <div class="flex items-center space-x-6">
                            <a href="#products">                                
                                <button class="px-8 py-4 bg-emerald-500 hover:bg-emerald-400 text-gray-900 font-black rounded-2xl transition-all shadow-lg hover:shadow-emerald-500/50 hover:-translate-y-1">
                                    Order Now
                                </button>
                            </a>
                            <div class="flex -space-x-3">
                                <img class="w-10 h-10 rounded-full border-2 border-indigo-900" src="https://i.pravatar.cc/100?u=1" alt="">
                                <img class="w-10 h-10 rounded-full border-2 border-indigo-900" src="https://i.pravatar.cc/100?u=2" alt="">
                                <div class="w-10 h-10 rounded-full border-2 border-indigo-900 bg-emerald-500 flex items-center justify-center text-[10px] font-bold text-gray-900">+1k</div>&nbsp;&nbsp;&nbsp;
                                <span class="ml-4 text-xs text-blue-200 mt-3 font-medium">Trusted by 10,000+ users</span>
                            </div>
                        </div>
                    </div>
                    <div class="hidden lg:block relative">
                        <div class="animate-bounce" style="animation-duration: 4s;">
                            <img src="https://cdn-icons-png.flaticon.com/512/4320/4320350.png" class="w-80 h-80 drop-shadow-[0_35px_35px_rgba(16,185,129,0.3)]" alt="Pharmacy">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-10 max-w-2xl mx-auto">
                <form action="{{ route('shop.index') }}" method="GET" class="relative group">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search for medicines..." class="block w-full pl-12 pr-4 py-4 bg-white dark:bg-gray-800 border-none rounded-2xl shadow-xl focus:ring-2 focus:ring-emerald-500 dark:text-white">
                    <button type="submit" class="absolute right-2 top-2 bottom-2 px-6 bg-emerald-500 text-gray-900 font-bold rounded-xl hover:bg-emerald-400 transition-all">Search</button>
                </form>
            </div>

            <div class="flex overflow-x-auto space-x-4 mb-12 pb-4 no-scrollbar">
                <a href="{{ route('shop.index') }}" 
                   class="flex-shrink-0 px-6 py-3 rounded-2xl font-bold transition-all shadow-sm {{ !request('category') ? 'bg-emerald-500 text-white' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300' }}">
                    All Items
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('shop.index', ['category' => $cat->slug]) }}" 
                       class="flex-shrink-0 px-6 py-3 rounded-2xl font-bold transition-all shadow-sm {{ request('category') == $cat->slug ? 'bg-emerald-500 text-white' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:border-emerald-500' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            <div id="products" class="mb-16">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tighter italic">
                        {{ request('category') ? str_replace('-', ' ', request('category')) : 'Essential Medicines' }}
                    </h3>
                    <div class="h-px flex-grow mx-8 bg-gray-200 dark:bg-gray-800"></div>
                </div>

                @if($medicines->isEmpty())
                    <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-[2rem]">
                        <p class="text-gray-500">No medicines found matching your criteria.</p>
                        <a href="{{ route('shop.index') }}" class="text-emerald-500 font-bold hover:underline">Clear all filters</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                        @foreach ($medicines as $medicine)
                            <div class="group relative bg-white dark:bg-gray-800 rounded-[2rem] overflow-hidden transition-all duration-500 hover:-translate-y-4 hover:shadow-[0_30px_60px_rgba(0,0,0,0.12)] border border-transparent hover:border-emerald-500/40 flex flex-col">
                                <div class="relative overflow-hidden aspect-square">
                                    <a href="{{ route('shop.show', $medicine) }}">
                                        <img src="{{ $medicine->image ? asset('storage/' . $medicine->image) : 'https://via.placeholder.com/300' }}" 
                                             class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                                    </a>
                                    <div class="absolute bottom-4 left-4">
                                        <span class="bg-black/60 backdrop-blur-md text-white px-4 py-1.5 rounded-xl font-bold border border-white/20">
                                            ₹{{ $medicine->price }}
                                        </span>
                                    </div>
                                    @if($medicine->prescription_required)
                                        <div class="absolute top-4 right-4">
                                            <span class="bg-red-500 text-white text-[10px] font-black px-2 py-1 rounded-md uppercase tracking-widest shadow-lg">Rx</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-6">
                                    <h4 class="font-bold text-lg text-gray-800 dark:text-white mb-4 group-hover:text-emerald-500 transition-colors">{{ $medicine->name }}</h4>
                                    @if($medicine->stock > 0)
                                        <form action="{{ route('cart.add', $medicine) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full bg-gray-50 dark:bg-gray-900 group-hover:bg-emerald-500 text-gray-700 dark:text-gray-300 group-hover:text-white py-3 rounded-xl font-bold transition-all duration-300 flex items-center justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                Add to Cart
                                            </button>
                                        </form>
                                    @else
                                        <div class="w-full bg-gray-100 dark:bg-gray-700 text-gray-400 py-3 text-center rounded-xl font-bold cursor-not-allowed">Sold Out</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                <div class="bg-gradient-to-r from-red-500 to-pink-600 rounded-[2rem] p-8 flex items-center justify-between shadow-xl transform transition hover:scale-[1.02]">
                    <div class="text-white">
                        <h4 class="text-2xl font-black mb-2">Emergency Care?</h4>
                        <p class="text-white/80 mb-4">Fast-track delivery for life-saving drugs.</p>
                        <button class="bg-white text-red-600 px-6 py-2 rounded-xl font-bold text-sm">Priority Order</button>
                    </div>
                    <img src="https://cdn-icons-png.flaticon.com/512/1032/1032989.png" class="w-24 h-24 opacity-20 rotate-12" alt="">
                </div>

                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-[2rem] p-8 flex items-center justify-between shadow-xl transform transition hover:scale-[1.02]">
                    <div class="text-white">
                        <h4 class="text-2xl font-black mb-2">AI Consultation</h4>
                        <p class="text-white/80 mb-4">Ask our AI for supplement recommendations.</p>
                        <a href="{{ route('dashboard') }}">
                            <button class="bg-white text-emerald-600 px-6 py-2 rounded-xl font-bold text-sm">Chat Now</button>
                        </a>
                    </div>
                    <img src="https://cdn-icons-png.flaticon.com/512/2043/2043914.png" class="w-24 h-24 opacity-20 -rotate-12" alt="">
                </div>
            </div>

            <div class="mt-8">
                {{ $medicines->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>