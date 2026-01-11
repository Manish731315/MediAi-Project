<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white tracking-tighter uppercase italic">
            {{ __('MediAI Virtual Doctor') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 p-6 bg-red-500/10 border border-red-500/20 rounded-[2rem] flex items-start space-x-4 animate__animated animate__fadeInDown">
                <div class="bg-red-500 p-2 rounded-xl text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="font-black text-red-500 uppercase text-xs tracking-widest mb-1">Medical Disclaimer</h3>
                    <p class="text-sm text-red-800/80 dark:text-red-200/80 leading-relaxed font-medium">
                        This AI is an assistant, not a doctor. For accurate diagnosis or emergencies, please consult a professional immediately.
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 overflow-hidden flex flex-col h-[95vh]">
                
                <div id="chat-log" aria-live="polite" class="flex-1 overflow-y-auto p-6 md:p-10 space-y-8 no-scrollbar bg-[url('https://img.freepik.com/premium-vector/blue-bright-doctor-silhouette-background_36402-427.jpg?semt=ais_hybrid&w=740&q=80')] bg-cover bg-center bg-no-repeat">
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white shadow-lg shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="p-5 rounded-2xl rounded-tl-none bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 shadow-sm max-w-[80%] border border-gray-200 dark:border-gray-700">
                            <p class="font-medium">Hello! I am your <strong>MediAI Assistant</strong>. How are you feeling today? Please describe your symptoms in detail.</p>
                        </div>
                    </div>

                    <div id="typing-indicator" class="flex items-start space-x-4 hidden">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-500 shrink-0">
                            <span class="animate-pulse font-black">AI</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-gray-100 dark:bg-gray-800 text-gray-400 italic text-sm">
                            MediAI is analyzing your symptoms...
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-800">
    
                    <div class="flex overflow-x-auto space-x-3 mb-4 pb-2 no-scrollbar">
                        <button type="button" onclick="quickAction('I have a severe headache and fever.')" 
                                class="flex-shrink-0 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-xs font-bold text-gray-600 dark:text-gray-400 hover:border-emerald-500 hover:text-emerald-500 transition-all shadow-sm">
                            🤒 Fever & Headache
                        </button>
                        <button type="button" onclick="quickAction('I have muscle pain and stiffness.')" 
                                class="flex-shrink-0 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-xs font-bold text-gray-600 dark:text-gray-400 hover:border-emerald-500 hover:text-emerald-500 transition-all shadow-sm">
                            💊 Muscles Pain
                        </button>
                        <button type="button" onclick="quickAction('I am experiencing Acidity and stomach discomfort.')" 
                                class="flex-shrink-0 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-xs font-bold text-gray-600 dark:text-gray-400 hover:border-emerald-500 hover:text-emerald-500 transition-all shadow-sm">
                            ✨ Acidity
                        </button>
                    </div>

                    <form id="chat-form" class="flex items-center space-x-4 bg-white dark:bg-gray-800 p-2 rounded-2xl shadow-inner border border-gray-200 dark:border-gray-700">
                        @csrf
                        <input id="message-input" name="message" type="text" 
                            class="flex-1 border-none bg-transparent focus:ring-0 dark:text-white px-4 font-medium" 
                            placeholder="Describe your symptoms..." required autocomplete="off" />
                        
                        <button id="send-button" type="submit" 
                                class="bg-emerald-500 hover:bg-emerald-400 text-gray-950 p-3 rounded-xl transition-all shadow-lg shadow-emerald-500/20 transform active:scale-95">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatForm = document.getElementById('chat-form');
            const messageInput = document.getElementById('message-input');
            const chatLog = document.getElementById('chat-log');
            const typingIndicator = document.getElementById('typing-indicator');
            const sendButton = document.getElementById('send-button');
            const csrfToken = document.querySelector('input[name="_token"]').value;
            const cartAddUrlBase = '{{ url('/cart/add') }}';

            const escapeHTML = (str) =>
                str.replace(/[&<>"']/g, (m) => (
                    { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m]
                ));

            chatForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const message = messageInput.value.trim();
                if (!message) return;

                addMessage(message, 'user');
                messageInput.value = '';
                
                // Show typing indicator at the bottom
                chatLog.appendChild(typingIndicator);
                typingIndicator.classList.remove('hidden');
                scrollToBottom();
                
                sendButton.disabled = true;

                fetch('{{ route('ai.chat.process') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ message: message })
                })
                .then(response => response.json())
                .then(data => {
                    typingIndicator.classList.add('hidden');
                    sendButton.disabled = false;
                    renderBotResponse(data);
                })
                .catch(error => {
                    typingIndicator.classList.add('hidden');
                    sendButton.disabled = false;
                    addMessage('Sorry, I encountered an error. Please check your internet connection.', 'bot');
                });
            });

            window.quickAction = function(text) {
                const input = document.getElementById('message-input');
                const form = document.getElementById('chat-form');
                
                input.value = text;
                
                // Dispatch a submit event to the form
                form.dispatchEvent(new Event('submit'));
            };

            function addMessage(content, type) {
                const messageWrapper = document.createElement('div');
                messageWrapper.className = 'flex items-start space-x-4 ' + (type === 'user' ? 'flex-row-reverse space-x-reverse' : '');

                // Avatar
                const avatar = document.createElement('div');
                avatar.className = `w-10 h-10 rounded-xl shrink-0 flex items-center justify-center shadow-md ${type === 'user' ? 'bg-indigo-600' : 'bg-emerald-500'}`;
                avatar.innerHTML = type === 'user' 
                    ? '<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>'
                    : '<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>';

                const messageBubble = document.createElement('div');
                messageBubble.className = `p-5 rounded-2xl max-w-[80%] shadow-sm font-medium leading-relaxed ${
                    type === 'user' 
                    ? 'bg-indigo-600 text-white rounded-tr-none' 
                    : 'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded-tl-none border border-gray-200 dark:border-gray-700'
                }`;

                if (type === 'user') {
                    messageBubble.textContent = content;
                } else {
                    messageBubble.innerHTML = content;
                }

                messageWrapper.appendChild(avatar);
                messageWrapper.appendChild(messageBubble);
                chatLog.appendChild(messageWrapper);
                scrollToBottom();
            }

            function renderBotResponse(data) {
                const safeText = (str) => escapeHTML(String(str || ''));
                let html = `<p class="mb-4">${safeText(data.analysis)}</p>`;

                if (data.recommendations?.length > 0) {
                    html += '<div class="bg-black/5 dark:bg-black/20 p-4 rounded-xl mb-4 border-l-4 border-emerald-500"><h4 class="font-black text-xs uppercase tracking-widest text-emerald-600 mb-2">Analysis & Recommendations</h4><ul class="space-y-2">';
                    data.recommendations.forEach(rec => {
                        html += `<li class="text-sm"><strong>${escapeHTML(rec.medicine_name)}:</strong> ${escapeHTML(rec.reason)}</li>`;
                    });
                    html += '</ul></div>';
                }

                if (data.matched_products?.length > 0) {
                    html += '<h4 class="font-black text-xs uppercase tracking-widest text-gray-400 mb-3 mt-6">Buy from our Pharmacy</h4><div class="space-y-3">';
                    data.matched_products.forEach(product => {
                        html += `
                            <div class="flex items-center bg-white dark:bg-gray-900 p-3 rounded-2xl border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow">
                                <img src="${escapeHTML(product.image)}" class="w-14 h-14 rounded-xl mr-4 object-cover border border-gray-100 dark:border-gray-800">
                                <div class="flex-1">
                                    <p class="font-black text-sm text-gray-800 dark:text-white uppercase italic tracking-tighter">${escapeHTML(product.name)}</p>
                                    <p class="text-emerald-500 font-bold">₹${escapeHTML(product.price.toString())}</p>
                                </div>
                                <form action="${cartAddUrlBase}/${escapeHTML(product.id.toString())}" method="POST">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="bg-gray-900 dark:bg-emerald-500 text-white dark:text-gray-950 px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:scale-105 transition-transform">
                                        Add
                                    </button>
                                </form>
                            </div>`;
                    });
                    html += '</div>';
                }

                html += `<div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700 opacity-60"><p class="text-[10px] italic leading-tight uppercase tracking-widest font-bold">${data.disclaimer}</p></div>`;
                addMessage(html, 'bot');
            }

            function scrollToBottom() {
                chatLog.scrollTo({ top: chatLog.scrollHeight, behavior: 'smooth' });
            }
        });
    </script>
    @endpush

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-app-layout>