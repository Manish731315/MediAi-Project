<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-white tracking-tighter uppercase italic">
                    {{ __('Command Center') }}
                </h2>
                <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest mt-1">
                    MediAI Real-time System Overview
                </p>
            </div>
            <div class="flex items-center space-x-2 text-emerald-500 bg-emerald-500/10 px-4 py-2 rounded-full border border-emerald-500/20">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                <span class="text-xs font-black uppercase tracking-widest">System Live</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="relative overflow-hidden bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 shadow-2xl border border-gray-100 dark:border-gray-800 group hover:border-orange-500/50 transition-all">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-500/10 rounded-full blur-2xl group-hover:bg-orange-500/20 transition-all"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <h3 class="text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Pending Orders</h3>
                            <p class="text-5xl font-black text-gray-900 dark:text-white italic tracking-tighter">{{ $pendingOrders }}</p>
                        </div>
                        <div class="bg-orange-500/10 p-4 rounded-2xl text-orange-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4 text-[10px] font-bold text-orange-600 uppercase tracking-widest">Requires Attention</div>
                </div>

                <div class="relative overflow-hidden bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 shadow-2xl border border-gray-100 dark:border-gray-800 group hover:border-emerald-500/50 transition-all">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <h3 class="text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Total Volume</h3>
                            <p class="text-5xl font-black text-gray-900 dark:text-white italic tracking-tighter">{{ $totalOrders }}</p>
                        </div>
                        <div class="bg-emerald-500/10 p-4 rounded-2xl text-emerald-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4 text-[10px] font-bold text-emerald-600 uppercase tracking-widest">Lifetime Sales</div>
                </div>

                <div class="relative overflow-hidden bg-white dark:bg-gray-900 rounded-[2.5rem] p-8 shadow-2xl border border-gray-100 dark:border-gray-800 group hover:border-indigo-500/50 transition-all">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-2xl group-hover:bg-indigo-500/20 transition-all"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <h3 class="text-xs font-black text-gray-500 uppercase tracking-widest mb-2">AI Interactions</h3>
                            <p class="text-5xl font-black text-gray-900 dark:text-white italic tracking-tighter">{{ $chatLogsCount }}</p>
                        </div>
                        <div class="bg-indigo-500/10 p-4 rounded-2xl text-indigo-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4 text-[10px] font-bold text-indigo-600 uppercase tracking-widest">MediBot Activity</div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-10 shadow-2xl border border-gray-100 dark:border-gray-800">
                <div class="flex items-center mb-8">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tighter italic">Tactical Actions</h3>
                    <div class="h-px flex-grow ml-6 bg-gray-100 dark:bg-gray-800"></div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <a href="{{ route('admin.medicines.create') }}" class="group bg-gray-50 dark:bg-gray-800 p-6 rounded-3xl border border-transparent hover:border-emerald-500/40 transition-all text-center">
                        <div class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-gray-900 mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-emerald-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <span class="text-xs font-black text-gray-700 dark:text-gray-300 uppercase tracking-widest">New Product</span>
                    </a>

                    <a href="{{ route('admin.medicines.index') }}" class="group bg-gray-50 dark:bg-gray-800 p-6 rounded-3xl border border-transparent hover:border-indigo-500/40 transition-all text-center">
                        <div class="w-12 h-12 bg-indigo-500 rounded-2xl flex items-center justify-center text-white mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-indigo-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <span class="text-xs font-black text-gray-700 dark:text-gray-300 uppercase tracking-widest">Inventory</span>
                    </a>

                    <a href="{{ route('admin.orders.index') }}" class="group bg-gray-50 dark:bg-gray-800 p-6 rounded-3xl border border-transparent hover:border-orange-500/40 transition-all text-center">
                        <div class="w-12 h-12 bg-orange-500 rounded-2xl flex items-center justify-center text-white mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-orange-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <span class="text-xs font-black text-gray-700 dark:text-gray-300 uppercase tracking-widest">Dispatch</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="group bg-gray-50 dark:bg-gray-800 p-6 rounded-3xl border border-transparent hover:border-blue-500/40 transition-all text-center">
                        <div class="w-12 h-12 bg-blue-500 rounded-2xl flex items-center justify-center text-white mx-auto mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-blue-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <span class="text-xs font-black text-gray-700 dark:text-gray-300 uppercase tracking-widest">Client Base</span>
                    </a>
                </div>
            </div>

            <div class="bg-gradient-to-r from-indigo-900 to-blue-900 rounded-[2.5rem] p-8 flex items-center justify-between shadow-2xl">
                <div class="text-white">
                    <h4 class="text-2xl font-black mb-1">Audit Logs & Security</h4>
                    <p class="text-indigo-200 text-sm font-medium">Review AI chat histories and system performance metrics.</p>
                </div>
                <a href="{{ route('admin.chat.logs') }}" class="px-8 py-3 bg-white text-indigo-900 font-black rounded-2xl hover:bg-emerald-500 hover:text-white transition-all text-xs uppercase tracking-widest">
                    Open Logs
                </a>
            </div>

        </div>
    </div>
</x-app-layout>