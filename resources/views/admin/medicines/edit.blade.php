<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-white tracking-tighter uppercase italic">
                {{ __('Edit Medicine') }}: <span class="text-emerald-500">{{ $medicine->name }}</span>
            </h2>
            <a href="{{ route('admin.medicines.index') }}" class="text-gray-400 hover:text-white transition-all text-sm font-bold flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Inventory
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.medicines.update', $medicine->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-8">
                        
                        <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 p-8 md:p-10">
                            <h3 class="text-lg font-black mb-8 uppercase tracking-widest text-emerald-500 flex items-center">
                                <span class="w-8 h-8 bg-emerald-500/10 rounded-lg flex items-center justify-center mr-3 text-emerald-500">1</span>
                                Core Information
                            </h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="name" :value="__('Medicine Name')" class="text-gray-500 font-bold ml-1" />
                                    <x-text-input id="name" name="name" type="text" class="mt-2 block w-full bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500 py-4 px-6 rounded-2xl" :value="old('name', $medicine->name)" required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="description" :value="__('Detailed Description')" class="text-gray-500 font-bold ml-1" />
                                    <textarea id="description" name="description" class="mt-2 w-full rounded-[1.5rem] bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500 text-gray-900 dark:text-gray-100 h-48 px-6 py-4">{{ old('description', $medicine->description) }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 p-8 md:p-10">
                            <h3 class="text-lg font-black mb-8 uppercase tracking-widest text-emerald-500 flex items-center">
                                <span class="w-8 h-8 bg-emerald-500/10 rounded-lg flex items-center justify-center mr-3 text-emerald-500">2</span>
                                Pricing & Stock
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <x-input-label for="price" :value="__('Selling Price (₹)')" class="text-gray-500 font-bold ml-1" />
                                    <x-text-input id="price" name="price" type="number" step="0.01" class="mt-2 block w-full bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500 py-4 px-6 rounded-2xl" :value="old('price', $medicine->price)" required />
                                </div>
                                
                                <div>
                                    <x-input-label for="stock" :value="__('Current Stock Level')" class="text-gray-500 font-bold ml-1" />
                                    <x-text-input id="stock" name="stock" type="number" class="mt-2 block w-full bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500 py-4 px-6 rounded-2xl" :value="old('stock', $medicine->stock)" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        
                        <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 p-8">
                            <h3 class="text-sm font-black mb-6 uppercase tracking-widest text-emerald-500">Organization</h3>
                            
                            <div>
                                <x-input-label for="category_id" :value="__('Assign Category')" class="text-gray-500 font-bold ml-1" />
                                <select id="category_id" name="category_id" class="mt-2 block w-full rounded-2xl bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500 text-gray-900 dark:text-gray-100 py-4 px-6" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $medicine->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="prescription_required" value="1" class="sr-only peer" @checked(old('prescription_required', $medicine->prescription_required))>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 dark:peer-focus:ring-emerald-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-1/2 peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-500"></div>
                                    <span class="ml-3 text-sm font-bold text-gray-700 dark:text-gray-300 italic">Rx Required?</span>
                                </label>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 p-8">
                            <h3 class="text-sm font-black mb-6 uppercase tracking-widest text-emerald-500">Product Visual</h3>
                            
                            <div class="relative group mb-6 overflow-hidden rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700 p-2">
                                <img id="imagePreview" 
                                     src="{{ $medicine->image ? asset('storage/' . $medicine->image) : 'https://placehold.co/600x400/111827/cbd5e1?text=No+Image' }}" 
                                     class="w-full h-48 object-cover rounded-2xl transition duration-500 group-hover:scale-105">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="text-white text-xs font-bold uppercase tracking-widest">Change Photo</span>
                                </div>
                            </div>
                            
                            <input id="image" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(event)"/>
                            <label for="image" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-xl cursor-pointer hover:bg-emerald-500 hover:text-white transition-all font-bold text-sm">
                                Upload New Image
                            </label>
                        </div>

                        <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 p-2">
                            <button type="submit" class="w-full flex items-center justify-center py-5 bg-emerald-500 hover:bg-emerald-400 text-gray-950 font-black rounded-[1.8rem] transition-all shadow-lg shadow-emerald-500/20 transform hover:-translate-y-1">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                {{ __('SYNC UPDATES') }}
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('imagePreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    @endpush
</x-app-layout>