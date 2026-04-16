<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-white tracking-tighter uppercase italic">
                    {{ __('Identity Vault') }}
                </h2>
                <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest mt-1">
                    System Access & Member Management
                </p>
            </div>
            
            <div class="flex items-center space-x-4">

                <a href="{{ route('admin.users.export.pdf') }}"
                class="px-6 py-3 bg-blue-500 hover:bg-blue-400 text-white font-bold rounded-2xl shadow-lg">
                    Export PDF
                </a>

                <div class="bg-gray-800/50 px-5 py-2 rounded-2xl border border-gray-700">
                    <span class="text-[10px] text-gray-500 font-black uppercase block">Registered Users</span>
                    <span class="text-emerald-500 font-black text-lg italic tracking-tighter">{{ $users->total() }} Members</span>
                </div>

            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 dark:bg-gray-800/50">
                            <tr>
                                <th class="px-8 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest">ID</th>
                                <th class="px-6 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest">Member Profile</th>
                                <th class="px-6 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest">Contact Info</th>
                                <th class="px-6 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest text-center">Permissions</th>
                                <th class="px-8 py-6 text-emerald-500 font-black uppercase text-xs tracking-widest text-right">Join Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-all group">
                                    <td class="px-8 py-6">
                                        <span class="text-indigo-600 dark:text-indigo-400 font-black text-sm italic">
                                            #USR-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-6">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-700 flex items-center justify-center text-white font-black text-xl italic shadow-lg group-hover:scale-110 transition duration-500">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="text-gray-900 dark:text-white font-black uppercase tracking-tighter italic">{{ $user->name }}</div>
                                                <div class="text-[10px] text-gray-500 font-bold uppercase tracking-widest truncate max-w-[150px]">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-6">
                                        <div class="space-y-1">
                                            <div class="flex items-center text-sm text-gray-700 dark:text-gray-300 font-medium">
                                                <svg class="w-3 h-3 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                {{ $user->phone ?? '+91 00000 00000' }}
                                            </div>
                                            <div class="text-[10px] text-gray-500 truncate max-w-xs uppercase font-bold">
                                                {{ $user->address ?? 'Location Not Set' }}
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-6 text-center">
                                        @if($user->role === 'admin')
                                            <span class="px-4 py-1.5 rounded-xl bg-indigo-500/10 text-indigo-500 border border-indigo-500/20 text-[10px] font-black uppercase tracking-widest italic shadow-sm">
                                                🛡️ Admin Access
                                            </span>
                                        @else
                                            <span class="px-4 py-1.5 rounded-xl bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 text-[10px] font-black uppercase tracking-widest italic shadow-sm">
                                                👤 Retail User
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-8 py-6 text-right">
                                        <div class="text-gray-900 dark:text-white font-bold text-sm">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-[9px] text-gray-500 font-black uppercase tracking-widest mt-1">
                                            Registered Member
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="px-8 py-8 bg-gray-50 dark:bg-gray-800/30 border-t dark:border-gray-800">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>