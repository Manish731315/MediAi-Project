<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('AI Health Assistant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- IMPORTANT DISCLAIMER --}}
                    <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 border border-red-300 dark:border-red-700 rounded-lg">
                        <p class="font-bold">IMPORTANT MEDICAL DISCLAIMER</p>
                        <p class="text-sm">
                            This AI is not a medical professional. Consult a qualified doctor for an accurate diagnosis.
                            If you are experiencing a medical emergency, call your local emergency services immediately.
                        </p>
                    </div>

                    {{-- Chat Container --}}
                    <div class="flex flex-col gap-4 h-[60vh]">
                        <div id="chat-log" aria-live="polite"
                             class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 dark:bg-gray-900 rounded-lg border dark:border-gray-700">
                            <div class="flex">
                                <div class="p-3 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 max-w-lg">
                                    <p>Hello! I am the MediAI Assistant. How are you feeling today? Please describe your symptoms.</p>
                                </div>
                            </div>

                            {{-- Typing indicator moved inside chat log --}}
                            <div id="typing-indicator" class="flex hidden">
                                <div class="p-3 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 max-w-lg">
                                    <p><i>MediAI is typing...</i></p>
                                </div>
                            </div>
                        </div>

                        {{-- Chat input form --}}
                        <form id="chat-form" class="flex items-center space-x-2">
                            @csrf
                            <x-text-input id="message-input" name="message" class="flex-1" placeholder="Type your symptoms..." required autocomplete="off" />
                            <x-primary-button id="send-button" type="submit">
                                Send
                            </x-primary-button>
                        </form>
                    </div>

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

            // Base URL for adding items to cart
            const cartAddUrlBase = '{{ url('/cart/add') }}';

            // Simple HTML escape function (prevents XSS)
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

                typingIndicator.classList.remove('hidden');
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
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    typingIndicator.classList.add('hidden');
                    sendButton.disabled = false;
                    renderBotResponse(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    typingIndicator.classList.add('hidden');
                    sendButton.disabled = false;
                    addMessage('Sorry, I encountered an error connecting to the AI. Please try again.', 'bot');
                });
            });

            function addMessage(content, type) {
                const messageWrapper = document.createElement('div');
                messageWrapper.className = 'flex';

                const messageBubble = document.createElement('div');
                messageBubble.className = 'p-3 rounded-lg max-w-lg';

                if (type === 'user') {
                    messageWrapper.classList.add('justify-end');
                    messageBubble.classList.add('bg-blue-600', 'text-white');
                    messageBubble.textContent = content; // secure text only
                } else {
                    messageBubble.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-900', 'dark:text-gray-100');
                    messageBubble.innerHTML = content; // backend-sanitized bot HTML
                }

                messageWrapper.appendChild(messageBubble);
                chatLog.appendChild(messageWrapper);
                scrollToBottom();
            }

            function renderBotResponse(data) {
                const safeText = (str) => escapeHTML(String(str || ''));
                let html = `<p>${safeText(data.analysis)}</p>`;


                if (data.recommendations?.length > 0) {
                    html += '<h4 class="font-semibold mt-3 mb-2">My Recommendations:</h4><ul class="list-disc list-inside space-y-1">';
                    data.recommendations.forEach(rec => {
                        html += `<li><strong>${escapeHTML(rec.medicine_name)}:</strong> ${escapeHTML(rec.reason)}</li>`;
                    });
                    html += '</ul>';
                }

                if (data.matched_products?.length > 0) {
                    html += '<h4 class="font-semibold mt-3 mb-2">Available in our store:</h4>';
                    data.matched_products.forEach(product => {
                        html += `
                            <div class="mt-2 flex items-center bg-white dark:bg-gray-800 p-2 rounded-lg border dark:border-gray-600">
                                <img src="${escapeHTML(product.image)}" alt="${escapeHTML(product.name)}"
                                     class="w-12 h-12 rounded mr-3 object-cover">
                                <div class="flex-1">
                                    <p class="font-bold text-sm">${escapeHTML(product.name)}</p>
                                    <p class="text-sm font-semibold">₹${escapeHTML(product.price.toString())}</p>
                                </div>

                                <form action="${cartAddUrlBase}/${escapeHTML(product.id.toString())}" method="POST">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit"
                                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm"
                                            type="button">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        `;
                    });
                }

                html += `<p class="mt-4 text-xs italic text-gray-500 dark:text-gray-400">${data.disclaimer}</p>`;
                addMessage(html, 'bot');
            }

            function scrollToBottom() {
                chatLog.scrollTop = chatLog.scrollHeight;
            }
        });
    </script>
    @endpush
</x-app-layout>
