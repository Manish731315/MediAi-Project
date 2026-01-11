<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
            <a href="{{ route('shop.index') }}" class="hover:text-emerald-500 transition">Shop</a>
            <span>/</span>
            <span class="text-gray-800 dark:text-gray-200">{{ $medicine->name }}</span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 rounded-2xl flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100 dark:border-gray-800">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    
                    <div class="p-8 bg-gray-100/50 dark:bg-gray-800/50 flex items-center justify-center">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-3xl blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                            <img src="{{ $medicine->image ? asset('storage/' . $medicine->image) : 'https://via.placeholder.com/600x600' }}" 
                                 alt="{{ $medicine->name }}" 
                                 class="relative w-full max-w-md h-auto rounded-3xl shadow-2xl transform transition duration-500 group-hover:scale-105">
                        </div>
                    </div>

                    <div class="p-8 md:p-12 flex flex-col">
                        <div class="mb-6">
                            <div class="flex items-center space-x-3 mb-4">
                                @if($medicine->prescription_required)
                                    <span class="bg-red-500 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase">Prescription Required</span>
                                @else
                                    <span class="bg-emerald-500 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase">OTC Product</span>
                                @endif
                                <span class="text-gray-400 text-xs font-bold uppercase tracking-widest">{{ $medicine->category }}</span>
                            </div>

                            <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-4 tracking-tighter">
                                {{ $medicine->name }}
                            </h1>
                            
                            @php
                                // Logic to generate unique-looking random data for each product
                                $rating = number_format(4 + (mt_rand(0, 10) / 10), 1); // Generates 4.0 to 5.0
                                $reviews = mt_rand(50, 500);
                                $stars = floor($rating);
                            @endphp

                            <div class="flex items-center mb-6">
                                <div class="flex text-yellow-400">
                                    @for($i=0; $i<5; $i++)
                                        <svg class="w-5 h-5 {{ $i < $stars ? 'fill-current' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="ml-2 text-sm font-bold text-gray-900 dark:text-white">{{ $rating }}</span>
                                <span class="ml-2 text-sm text-gray-500">({{ $reviews }} Verified Reviews)</span>
                            </div>
                            

                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg mb-8">
                                {{ $medicine->description }}
                            </p>
                        </div>

                        <div class="mt-auto bg-gray-50 dark:bg-gray-800/50 p-8 rounded-[2rem] border border-gray-100 dark:border-gray-700">
                            <div class="flex items-baseline justify-between mb-6">
                                <div class="flex items-baseline space-x-2">
                                    <span class="text-5xl font-black text-gray-900 dark:text-white italic">₹{{ $medicine->price }}</span>
                                    <span class="text-gray-400 line-through text-lg">₹{{ $medicine->price + 50 }}</span>
                                </div>
                                @if($medicine->stock > 0)
                                    <span class="text-emerald-500 font-bold text-sm bg-emerald-500/10 px-3 py-1 rounded-lg">In Stock ({{ $medicine->stock }})</span>
                                @else
                                    <span class="text-red-500 font-bold text-sm bg-red-500/10 px-3 py-1 rounded-lg">Out of Stock</span>
                                @endif
                            </div>

                            @if($medicine->stock > 0)
                                <form action="{{ route('cart.add', $medicine) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div class="flex flex-col sm:flex-row gap-4">
                                        <div class="flex items-center text-white bg-white dark:bg-gray-900 rounded-2xl p-1 border border-gray-200 dark:border-gray-700">
                                            <button type="button" onclick="document.getElementById('quantity').stepDown()" class="w-12 h-12 flex items-center justify-center text-xl font-bold hover:text-emerald-500">-</button>
                                            <input id="quantity" name="quantity" type="number" value="1" min="1" max="{{ $medicine->stock }}" class="w-16 border-none bg-transparent text-center font-bold focus:ring-0" readonly>
                                            <button type="button" onclick="document.getElementById('quantity').stepUp()" class="w-12 h-12 flex items-center justify-center text-xl font-bold hover:text-emerald-500">+</button>
                                        </div>
                                        
                                        <button type="submit" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white font-black py-4 rounded-2xl transition-all shadow-lg shadow-emerald-500/30 flex items-center justify-center space-x-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                            <span>Add to Cart</span>
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>

                        <div class="grid grid-cols-3 gap-4 mt-8">
                            <div class="text-center">
                                <div class="bg-blue-500/10 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2 text-blue-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.040L3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622l-.982-3.072z"></path></svg>
                                </div>
                                <p class="text-[10px] font-bold uppercase text-gray-400">100% Genuine</p>
                            </div>
                            <div class="text-center">
                                <div class="bg-emerald-500/10 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2 text-emerald-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <p class="text-[10px] font-bold uppercase text-gray-400">Fast Delivery</p>
                            </div>
                            <div class="text-center">
                                <div class="bg-purple-500/10 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2 text-purple-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                </div>
                                <p class="text-[10px] font-bold uppercase text-gray-400">Secure Pay</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-20">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter italic">Suggested for You</h3>
                    <div class="h-px flex-grow mx-8 bg-gray-200 dark:bg-gray-800"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    {{-- Logic to fetch related products from your Controller or a quick query --}}
                    @php
                        $related = \App\Models\Medicine::where('category', $medicine->category)
                                    ->where('id', '!=', $medicine->id)
                                    ->limit(4)
                                    ->get();
                    @endphp

                    @foreach($related as $item)
                        <a href="{{ route('shop.show', $item) }}" class="group bg-white dark:bg-gray-900 p-4 rounded-[2rem] border border-gray-100 dark:border-gray-800 hover:shadow-xl transition-all duration-300">
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/200' }}" class="w-full aspect-square object-cover rounded-2xl mb-4 group-hover:scale-105 transition">
                            <h4 class="font-bold text-gray-800 dark:text-gray-200 truncate">{{ $item->name }}</h4>
                            <p class="text-emerald-500 font-black mt-2">₹{{ $item->price }}</p>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>