<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-white tracking-tighter uppercase italic">
                    {{ __('Intelligence Audit') }}
                </h2>
                <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest mt-1">
                    MediBot Natural Language Processing Logs
                </p>
            </div>
            <div class="flex items-center space-x-4">

                <a href="{{ route('admin.logs.export.pdf') }}"
                class="px-6 py-3 bg-blue-500 hover:bg-blue-400 text-white font-bold rounded-2xl shadow-lg">
                    Export PDF
                </a>

                <div class="bg-indigo-500/10 px-4 py-2 rounded-2xl border border-indigo-500/20 text-indigo-400 font-black text-xs uppercase tracking-widest">
                    Total Logs: {{ $logs->total() }}
                </div>

            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="space-y-8">
                @forelse ($logs as $log)
                    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 overflow-hidden group hover:border-indigo-500/30 transition-all duration-500">
                        
                        <div class="px-8 py-5 bg-gray-50 dark:bg-gray-800/50 border-b dark:border-gray-800 flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center text-indigo-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <span class="font-black text-gray-900 dark:text-white uppercase tracking-tighter italic">{{ $log->user->name ?? 'Guest User' }}</span>
                            </div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $log->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="p-8 space-y-6">
                            <div class="relative pl-6 border-l-2 border-indigo-500">
                                <span class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-indigo-500 border-4 border-gray-900"></span>
                                <h4 class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-2">Symptom Input</h4>
                                <p class="text-gray-700 dark:text-gray-300 font-medium italic">"{{ $log->symptoms_input }}"</p>
                            </div>

                            <div class="relative pl-6 border-l-2 border-emerald-500">
                                <span class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-emerald-500 border-4 border-gray-900"></span>
                                <h4 class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-2">MediAI Processing Output</h4>
                                
                                <div class="bg-gray-50 dark:bg-gray-800/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-700">
                                    @php
                                        $aiData = json_decode($log->ai_response, true);
                                    @endphp
                                    
                                    @if(is_array($aiData))
                                        <div class="space-y-4">
                                            <div>
                                                <span class="text-[10px] text-gray-500 font-bold uppercase">Analysis Result:</span>
                                                <p class="text-sm text-gray-800 dark:text-gray-200 mt-1 leading-relaxed">{{ $aiData['analysis'] ?? 'N/A' }}</p>
                                            </div>

                                            @if(!empty($aiData['recommendations']))
                                                <div class="pt-4 border-t dark:border-gray-700">
                                                    <span class="text-[10px] text-gray-500 font-bold uppercase">Medication Logic:</span>
                                                    <ul class="mt-2 space-y-2">
                                                        @foreach($aiData['recommendations'] as $rec)
                                                            <li class="text-xs text-emerald-500 font-bold">
                                                                • {{ $rec['medicine_name'] }}: <span class="text-gray-400 font-medium">{{ $rec['reason'] }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <pre class="text-xs text-gray-400 overflow-x-auto">{{ $log->ai_response }}</pre>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="px-8 py-3 bg-gray-50/50 dark:bg-gray-900/50 flex items-center justify-between text-[9px] font-black text-gray-500 uppercase tracking-[0.2em]">
                            <span>System ID: #LOG-{{ $log->id }}</span>
                            <span>NLP Model: GPT-4o-Medical</span>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-20 text-center border border-gray-100 dark:border-gray-800">
                        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <h3 class="text-xl font-black text-gray-400 uppercase tracking-tighter italic">No Intelligence Data</h3>
                        <p class="text-gray-500 mt-2">The AI has not processed any symptom queries yet.</p>
                    </div>
                @endforelse

                <div class="mt-12">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>