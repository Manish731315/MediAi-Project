<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Medicine') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.medicines.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Main Content (Left Column) -->
                    <div class="md:col-span-2 space-y-6">
                        <!-- Basic Details Card -->
                        <div class="bg-white dark:bg-gray-900  overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h3 class="text-lg font-semibold mb-4">Basic Details</h3>
                                <!-- Name -->
                                <div>
                                    <x-input-label for="name" :value="__('Medicine Name')" class="text-[#2563eb]"/>
                                    <x-text-input id="name" name="name" type="text" class="mt-1 bg-gray-700 border-none block w-full" :value="old('name')" required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                
                                <!-- Description -->
                                <div class="mt-4">
                                    <x-input-label for="description" :value="__('Description')" class="text-[#2563eb]"/>
                                    <textarea id="description" name="description" class="border-gray-300 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full h-32">{{ old('description') }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Pricing & Inventory Card -->
                        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h3 class="text-lg font-semibold mb-4">Pricing & Inventory</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Price -->
                                    <div>
                                        <x-input-label for="price" :value="__('Price (₹)')" class="text-[#2563eb]" />
                                        <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 bg-gray-700 border-none block w-full" :value="old('price')" required />
                                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                    </div>
                                    
                                    <!-- Stock -->
                                    <div>
                                        <x-input-label for="stock" :value="__('Stock Quantity')" class="text-[#2563eb]"/>
                                        <x-text-input id="stock" name="stock" type="number" class="mt-1 bg-gray-700 border-none block w-full" :value="old('stock')" required />
                                        <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar (Right Column) -->
                    <div class="md:col-span-1 space-y-6">
                        <!-- Publish Card -->
                        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h3 class="text-lg font-semibold mb-4">Publish</h3>
                                <x-primary-button class="w-full justify-center">
                                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    {{ __('Save Medicine') }}
                                </x-primary-button>
                            </div>
                        </div>

                        <!-- Organization Card -->
                        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h3 class="text-lg font-semibold mb-4">Organization</h3>
                                <!-- Category -->
                                <div>
                                    <x-input-label for="category" :value="__('Category')" class="text-[#2563eb]"/>
                                    <x-text-input id="category" name="category" type="text" class="mt-1 block bg-gray-700 border-none w-full" :value="old('category')" required />
                                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                </div>
                                <!-- Prescription Required -->
                                <div class="flex items-center space-x-2 mt-4 border-t dark:border-gray-700 pt-4">
                                    <input id="prescription_required" name="prescription_required" type="checkbox" value="1" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" @checked(old('prescription_required'))>
                                    <label for="prescription_required" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Requires Prescription?') }}</label>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Check this box if this medicine requires a doctor's prescription.</p>
                            </div>
                        </div>
                        
                        <!-- Image Card -->
                        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900 dark:text-gray-100">
                                <h3 class="text-lg font-semibold mb-4">Medicine Image</h3>
                                <!-- Image Preview -->
                                <img id="imagePreview" src="https://placehold.co/600x400/e2e8f0/cbd5e1?text=No+Image" alt="Image preview" class="w-full h-48 object-cover rounded-md mb-4 bg-gray-100 dark:bg-gray-700"/>
                                
                                <div>
                                    <x-input-label for="image" :value="__('Upload Image')" class="sr-only" />
                                    <input id="image" name="image" type="file" class="mt-1 block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-md file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-indigo-50 dark:file:bg-gray-700
                                      file:text-indigo-700 dark:file:text-indigo-300
                                      hover:file:bg-indigo-100 dark:hover:file:bg-gray-600"
                                      accept="image/png, image/jpeg, image/jpg"
                                      onchange="previewImage(event)"/>
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>
                            </div>
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