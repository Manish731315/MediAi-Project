<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 dark:text-emerald-400 leading-tight">
            {{ __('Create New Medicine') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.medicines.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="md:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-xl sm:rounded-[2rem] border border-gray-100 dark:border-gray-800">
                            <div class="p-8 text-gray-900 dark:text-gray-100">
                                <h3 class="text-lg font-black mb-6 uppercase tracking-widest text-emerald-500">Basic Details</h3>
                                
                                <div>
                                    <x-input-label for="name" :value="__('Medicine Name')" class="text-gray-600 dark:text-gray-400 font-bold" />
                                    <x-text-input id="name" name="name" type="text" class="mt-2 block w-full bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500" :value="old('name')" placeholder="e.g. Amoxicillin 500mg" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                
                                <div class="mt-6">
                                    <x-input-label for="description" :value="__('Product Description')" class="text-gray-600 dark:text-gray-400 font-bold" />
                                    <textarea id="description" name="description" class="w-full mt-2 rounded-2xl bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500 text-gray-900 dark:text-gray-100 h-40" placeholder="Describe the usage, dosage, and warnings...">{{ old('description') }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-xl sm:rounded-[2rem] border border-gray-100 dark:border-gray-800">
                            <div class="p-8 text-gray-900 dark:text-gray-100">
                                <h3 class="text-lg font-black mb-6 uppercase tracking-widest text-emerald-500">Pricing & Inventory</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="price" :value="__('Unit Price (₹)')" class="text-gray-600 dark:text-gray-400 font-bold" />
                                        <x-text-input id="price" name="price" type="number" step="0.01" class="mt-2 block w-full bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500" :value="old('price')" required />
                                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                    </div>
                                    
                                    <div>
                                        <x-input-label for="stock" :value="__('Available Stock')" class="text-gray-600 dark:text-gray-400 font-bold" />
                                        <x-text-input id="stock" name="stock" type="number" class="mt-2 block w-full bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500" :value="old('stock')" required />
                                        <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-1 space-y-6">
                        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-xl sm:rounded-[2rem] border border-gray-100 dark:border-gray-800">
                            <div class="p-8 text-gray-900 dark:text-gray-100">
                                <h3 class="text-lg font-black mb-6 uppercase tracking-widest text-emerald-500">Organization</h3>
                                
                                <div>
                                    <x-input-label for="category_id" :value="__('Select Category')" class="text-gray-600 dark:text-gray-400 font-bold" />
                                    <select id="category_id" name="category_id" class="mt-2 block w-full rounded-2xl bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500 text-gray-900 dark:text-gray-100" required>
                                        <option value="">Choose a Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                </div>

                                <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="prescription_required" value="1" class="sr-only peer" @checked(old('prescription_required'))>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 dark:peer-focus:ring-emerald-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-1/2 peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-500"></div>
                                        <span class="ml-3 text-sm font-bold text-gray-700 dark:text-gray-300 italic">Rx Required?</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-xl sm:rounded-[2rem] border border-gray-100 dark:border-gray-800">
                            <div class="p-8 text-gray-900 dark:text-gray-100">
                                <h3 class="text-lg font-black mb-6 uppercase tracking-widest text-emerald-500">Medicine Image</h3>
                                
                                <div class="relative group mb-4">
                                    <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-2xl blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
                                    <img id="imagePreview" src="https://placehold.co/600x400/111827/cbd5e1?text=No+Image+Selected" alt="Image preview" class="relative w-full h-48 object-cover rounded-2xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700"/>
                                </div>
                                
                                <input id="image" name="image" type="file" class="hidden" accept="image/png, image/jpeg, image/jpg" onchange="previewImage(event)"/>
                                <label for="image" class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-xl cursor-pointer hover:bg-emerald-500 hover:text-white transition-all font-bold">
                                    Upload Photo
                                </label>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-xl sm:rounded-[2rem] border border-gray-100 dark:border-gray-800 p-2">
                            <button type="submit" class="w-full flex items-center justify-center py-5 bg-emerald-500 hover:bg-emerald-400 text-gray-900 font-black rounded-[1.5rem] transition-all shadow-lg shadow-emerald-500/20 transform hover:-translate-y-1">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                {{ __('SAVE MEDICINE') }}
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