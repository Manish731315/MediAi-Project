<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{-- Change 1: Updated Title --}}
            {{ __('Edit Medicine: ') }} {{ $medicine->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Change 2: Form action points to 'update' route and passes the medicine ID --}}
                    <form action="{{ route('admin.medicines.update', $medicine->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH') {{-- Change 3: Added PATCH method for updating --}}
                        
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            {{-- Change 4: Pre-fill value from database --}}
                            <x-text-input id="name" name="name" type="text" class="mt-1 dark:bg-gray-800 block w-full" required :value="old('name', $medicine->name)" />
                        </div>
                        
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            {{-- Change 5: Pre-fill textarea content --}}
                            <textarea id="description" name="description" class="border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">{{ old('description', $medicine->description) }}</textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="price" :value="__('Price')" />
                                {{-- Change 6: Pre-fill value --}}
                                <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 dark:bg-gray-800 block w-full" required :value="old('price', $medicine->price)" />
                            </div>
                            
                            <div>
                                <x-input-label for="stock" :value="__('Stock')" />
                                {{-- Change 7: Pre-fill value --}}
                                <x-text-input id="stock" name="stock" type="number" class="mt-1 dark:bg-gray-800 block w-full" required :value="old('stock', $medicine->stock)" />
                            </div>
                            
                            <div>
                                <x-input-label for="category" :value="__('Category')" />
                                {{-- Change 8: Pre-fill value --}}
                                <x-text-input id="category" name="category" type="text" class="mt-1 dark:bg-gray-800 block w-full" required :value="old('category', $medicine->category)" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="image" :value="__('Image')" />
                            <x-text-input id="image" name="image" type="file" class="mt-1 dark:bg-gray-800 block w-full" />
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Leave blank to keep the current image.</p>
                            
                            {{-- Change 9: Show the current image --}}
                            @if ($medicine->image)
                                <div class="mt-4">
                                    <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}" class="w-32 h-32 object-cover rounded-md">
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center space-x-2">
                            {{-- Change 10: Check the box if 'prescription_required' is true --}}
                            <input id="prescription_required" name="prescription_required" type="checkbox" value="1" 
                                   class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                   @checked(old('prescription_required', $medicine->prescription_required))>
                            <label for="prescription_required" class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Requires Prescription?') }}</label>
                        </div>

                        <div>
                            {{-- Change 11: Updated button text --}}
                            <x-primary-button>
                                {{ __('Update Medicine') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>