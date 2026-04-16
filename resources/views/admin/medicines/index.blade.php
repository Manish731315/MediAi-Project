<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-black text-2xl text-white tracking-tighter uppercase italic">
                {{ __('Inventory Management') }}
            </h2>
            <a href="{{ route('admin.medicines.export.pdf') }}"
            class="px-6 py-3 bg-blue-500 hover:bg-blue-400 text-white font-bold rounded-2xl shadow-lg">
                Export PDF
            </a>
            <a href="{{ route('admin.medicines.create') }}" class="group relative px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-gray-950 font-black rounded-2xl transition-all shadow-lg shadow-emerald-500/20 overflow-hidden">
                <span class="relative z-10 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                    Add New Medicine
                </span>
                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 rounded-2xl font-bold flex items-center shadow-sm animate-pulse">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 dark:bg-gray-800/50">
                            <tr>
                                <th class="px-8 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest">Product Details</th>
                                <th class="px-6 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest">Category</th>
                                <th class="px-6 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest">Pricing</th>
                                <th class="px-6 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest text-center">Stock Level</th>
                                <th class="px-8 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse ($medicines as $medicine)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-all group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-4">
                                            <div class="relative w-14 h-14 shrink-0 overflow-hidden rounded-2xl border-2 border-gray-200 dark:border-gray-700 shadow-md">
                                                <img src="{{ $medicine->image ? asset('storage/' . $medicine->image) : 'https://via.placeholder.com/150' }}" 
                                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                            </div>
                                            <div>
                                                <div class="text-gray-900 dark:text-white font-black text-lg group-hover:text-emerald-500 transition-colors">{{ $medicine->name }}</div>
                                                <div class="flex items-center mt-1">
                                                    @if($medicine->prescription_required)
                                                        <span class="bg-red-500/10 text-red-500 text-[10px] font-black px-2 py-0.5 rounded-md uppercase tracking-tighter">Rx Only</span>
                                                    @else
                                                        <span class="bg-emerald-500/10 text-emerald-500 text-[10px] font-black px-2 py-0.5 rounded-md uppercase tracking-tighter">OTC</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-6 text-gray-500 dark:text-gray-400 font-bold">
                                        {{ $medicine->category->name ?? 'Uncategorized' }}
                                    </td>

                                    <td class="px-6 py-6 text-gray-900 dark:text-white font-black text-lg italic">
                                        ₹{{ number_format($medicine->price, 2) }}
                                    </td>

                                    <td class="px-6 py-6 text-center">
                                        @if($medicine->stock > 20)
                                            <span class="inline-flex px-4 py-1.5 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs font-black shadow-sm border border-emerald-500/20">
                                                {{ $medicine->stock }} Available
                                            </span>
                                        @elseif($medicine->stock > 0)
                                            <span class="inline-flex px-4 py-1.5 rounded-xl bg-orange-500/10 text-orange-600 dark:text-orange-400 text-xs font-black shadow-sm border border-orange-500/20">
                                                Low: {{ $medicine->stock }}
                                            </span>
                                        @else
                                            <span class="inline-flex px-4 py-1.5 rounded-xl bg-red-500/10 text-red-600 dark:text-red-400 text-xs font-black shadow-sm border border-red-500/20">
                                                Out of Stock
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-8 py-6 text-right space-x-3">
                                        <div class="flex justify-end items-center space-x-3">
                                            <a href="{{ route('admin.medicines.edit', $medicine) }}" 
                                               class="p-3 bg-gray-100 dark:bg-gray-800 rounded-xl text-indigo-500 hover:bg-indigo-500 hover:text-white transition-all shadow-md group/btn">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            
                                            <form action="{{ route('admin.medicines.destroy', $medicine) }}" method="POST" class="inline-block" onsubmit="return confirm('WARNING: Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-3 bg-gray-100 dark:bg-gray-800 rounded-xl text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-md group/btn">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-24 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            </div>
                                            <p class="text-xl font-black text-gray-400 dark:text-gray-600 tracking-tighter uppercase">No Medicines in Vault</p>
                                            <a href="{{ route('admin.medicines.create') }}" class="mt-4 text-emerald-500 hover:underline font-bold">Initiate your first entry →</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($medicines->hasPages())
                    <div class="px-8 py-8 bg-gray-50 dark:bg-gray-800/30 border-t dark:border-gray-800">
                        {{ $medicines->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>