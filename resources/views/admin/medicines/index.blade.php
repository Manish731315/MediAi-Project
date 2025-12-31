<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manage Medicines') }}
            </h2>
            <a href="{{ route('admin.medicines.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                {{ __('+ Add New Medicine') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Stock</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Prescription?</th>
                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($medicines as $medicine)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium">{{ $medicine->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $medicine->category }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">${{ $medicine->price }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $medicine->stock }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($medicine->prescription_required)
                                            <span class="text-red-500 font-semibold">Yes</span>
                                        @else
                                            <span>No</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('admin.medicines.edit', $medicine) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Edit</a>
                                        
                                        <form action="{{ route('admin.medicines.destroy', $medicine) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this medicine?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-sm">No medicines found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="mt-8">
                        {{ $medicines->links() }}
                    </div>

                </div>
            </div>
    </div>
</x-app-layout>