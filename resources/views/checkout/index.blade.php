<x-app-layout>
    {{-- Razorpay Checkout Script --}}
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-white tracking-tighter uppercase italic">
                    {{ __('Secure Transaction') }}
                </h2>
                <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest mt-1 flex items-center">
                    <svg class="w-3 h-3 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                    Clinical Level Encryption Active
                </p>
            </div>
            <div class="flex -space-x-2">
                <img class="w-8 h-8 rounded-full border-2 border-gray-900 bg-white p-1" src="https://razorpay.com/favicon.png" alt="Razorpay">
                <img class="w-8 h-8 rounded-full border-2 border-gray-900 bg-white p-1" src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="Paypal">
                <img class="w-8 h-8 rounded-full border-2 border-gray-900 bg-white p-1" src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard">
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-8 p-4 bg-red-500/10 border border-red-500/20 text-red-500 rounded-[2rem] font-bold shadow-sm">
                    <ul class="text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST" x-data="{ paymentMethod: 'card' }">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-2 space-y-8">
                        
                        <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 p-8 md:p-10">
                            <h3 class="text-lg font-black mb-8 uppercase tracking-widest text-emerald-500 flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Shipping Destination
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label value="Full Name" class="text-gray-500 font-bold ml-1" />
                                    <x-text-input class="block mt-2 w-full bg-gray-100 dark:bg-gray-800 border-none cursor-not-allowed opacity-60 rounded-2xl" type="text" value="{{ Auth::user()->name }}" readonly />
                                </div>
                                <div>
                                    <x-input-label for="phone" value="Primary Contact" class="text-gray-500 font-bold ml-1" />
                                    @if(Auth::user()->phone)
                                        <x-text-input class="block mt-2 w-full bg-gray-100 dark:bg-gray-800 border-none cursor-not-allowed opacity-60 rounded-2xl" type="text" value="{{ Auth::user()->phone }}" readonly />
                                        <input type="hidden" name="phone" value="{{ Auth::user()->phone }}">
                                    @else
                                        <x-text-input id="phone" name="phone" class="block mt-2 w-full bg-gray-50 dark:bg-gray-800 border-emerald-500/50 focus:ring-emerald-500 rounded-2xl" type="text" required />
                                    @endif
                                </div>

                                <div class="md:col-span-2 mt-4">
                                    <x-input-label for="delivery_address" value="Street Address / House No." class="text-gray-500 font-bold ml-1" />
                                    <x-text-input id="delivery_address" name="delivery_address" class="block mt-2 w-full bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500 rounded-2xl py-4" type="text" :value="Auth::user()->address" required placeholder="Flat No, Building, Street Name" />
                                </div>

                                <div>
                                    <x-input-label for="landmark" value="Landmark (Back In)" class="text-emerald-500 font-black uppercase text-[10px] tracking-widest" />
                                    <x-text-input id="landmark" name="landmark" class="block mt-2 w-full bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500 rounded-2xl" type="text" :value="Auth::user()->landmark" placeholder="Near Hospital/Park" />
                                </div>
                                <div>
                                    <x-input-label for="alternate_phone" value="Alternate Mobile (Back In)" class="text-emerald-500 font-black uppercase text-[10px] tracking-widest" />
                                    <x-text-input id="alternate_phone" name="alternate_phone" class="block mt-2 w-full bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500 rounded-2xl" type="text" placeholder="Secondary Phone" />
                                </div>

                                <div class="grid grid-cols-3 md:col-span-2 gap-4 mt-4">
                                    <div>
                                        <x-input-label for="city" value="City" class="text-gray-500 font-bold" />
                                        <x-text-input id="city" name="city" class="block mt-2 w-full bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500 rounded-2xl" type="text" :value="Auth::user()->city" required />
                                    </div>
                                    <div>
                                        <x-input-label for="state" value="State" class="text-gray-500 font-bold" />
                                        <x-text-input id="state" name="state" class="block mt-2 w-full bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500 rounded-2xl" type="text" :value="Auth::user()->state" required />
                                    </div>
                                    <div>
                                        <x-input-label for="pincode" value="Pincode" class="text-gray-500 font-bold" />
                                        <x-text-input id="pincode" name="pincode" class="block mt-2 w-full bg-gray-50 dark:bg-gray-800 border-none focus:ring-2 focus:ring-emerald-500 rounded-2xl" type="text" :value="Auth::user()->pincode" required pattern="[0-9]{6}" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 p-8 md:p-10">
                            <h3 class="text-lg font-black mb-8 uppercase tracking-widest text-emerald-500 flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                Settlement Method
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative flex items-center p-6 border-2 rounded-[2rem] cursor-pointer transition-all group" 
                                       :class="paymentMethod === 'card' ? 'bg-emerald-500/10 border-emerald-500 shadow-lg shadow-emerald-500/10' : 'bg-gray-50 dark:bg-gray-800 border-transparent hover:border-emerald-500/30'">
                                    <input type="radio" name="payment_method" value="card" x-model="paymentMethod" class="sr-only">
                                    <div class="flex items-center space-x-4">
                                        <div class="p-3 rounded-xl bg-white dark:bg-gray-700 shadow-sm" :class="paymentMethod === 'card' ? 'text-emerald-500' : 'text-gray-400'">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <div>
                                            <span class="block font-black text-gray-900 dark:text-white uppercase tracking-tighter italic">Online Payment</span>
                                            <span class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest">Instant Approval</span>
                                        </div>
                                    </div>
                                    <div x-show="paymentMethod === 'card'" class="absolute top-4 right-4 text-emerald-500"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg></div>
                                </label>

                                <label class="relative flex items-center p-6 border-2 rounded-[2rem] cursor-pointer transition-all group" 
                                       :class="paymentMethod === 'cod' ? 'bg-emerald-500/10 border-emerald-500 shadow-lg shadow-emerald-500/10' : 'bg-gray-50 dark:bg-gray-800 border-transparent hover:border-emerald-500/30'">
                                    <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="sr-only">
                                    <div class="flex items-center space-x-4">
                                        <div class="p-3 rounded-xl bg-white dark:bg-gray-700 shadow-sm" :class="paymentMethod === 'cod' ? 'text-emerald-500' : 'text-gray-400'">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div>
                                            <span class="block font-black text-gray-900 dark:text-white uppercase tracking-tighter italic">Cash on Delivery</span>
                                            <span class="block text-[10px] text-gray-500 font-bold uppercase tracking-widest">Settle on Arrival</span>
                                        </div>
                                    </div>
                                    <div x-show="paymentMethod === 'cod'" class="absolute top-4 right-4 text-emerald-500"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-gray-800 p-8 lg:sticky lg:top-8">
                            <h3 class="text-xs font-black mb-8 uppercase tracking-widest text-emerald-500">Clinical Manifest</h3>
                            
                            <div class="space-y-4 mb-8 max-h-[300px] overflow-y-auto no-scrollbar">
                                @foreach($cartItems as $item)
                                    <div class="flex items-center space-x-4 bg-gray-50 dark:bg-gray-800/50 p-3 rounded-2xl border border-gray-100 dark:border-gray-700">
                                        <img src="{{ $item->medicine->image ? asset('storage/' . $item->medicine->image) : 'https://via.placeholder.com/100' }}" 
                                             class="w-12 h-12 rounded-xl object-cover shadow-sm">
                                        <div class="flex-1 min-w-0">
                                            <p class="font-black text-xs text-gray-900 dark:text-white uppercase tracking-tighter truncate">{{ $item->medicine->name }}</p>
                                            <p class="text-[10px] text-gray-500 font-bold uppercase">Qty: {{ $item->quantity }} × ₹{{ number_format($item->medicine->price, 2) }}</p>
                                        </div>
                                        <p class="font-black text-xs text-emerald-500">₹{{ number_format($item->medicine->price * $item->quantity, 2) }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-6 border-t border-gray-100 dark:border-gray-800 space-y-6">
                                <div class="flex flex-col items-center">
                                    <span class="text-[10px] text-gray-400 font-black uppercase tracking-[0.2em] mb-1">Total Settlement</span>
                                    <span class="text-4xl font-black text-gray-900 dark:text-white italic tracking-tighter">₹{{ number_format($total, 2) }}</span>
                                </div>

                                @if($requiresPrescription)
                                    <div class="p-4 bg-orange-500/10 border border-orange-500/20 rounded-2xl flex items-start space-x-3">
                                        <svg class="w-5 h-5 text-orange-600 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        <p class="text-[10px] text-orange-800/80 dark:text-orange-200/80 font-bold uppercase leading-relaxed">
                                            This order requires a verified prescription upload post-placement.
                                        </p>
                                    </div>
                                @endif

                                <button type="submit" class="w-full py-5 bg-emerald-500 hover:bg-emerald-400 text-gray-950 font-black rounded-2xl shadow-xl transition-all hover:scale-[1.02] active:scale-95 group text-xs uppercase tracking-widest">
                                    <span x-show="paymentMethod === 'card'">Pay Now</span>
                                    <span x-show="paymentMethod === 'cod'">Cash on Delivery</span>
                                    <svg class="inline-block w-4 h-4 ml-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Razorpay Logic --}}
    @push('scripts')
        @if(isset($razorpayOrderId))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var options = {
                    "key": "{{ $razorpayKeyId }}",
                    "amount": "{{ $total * 100 }}",
                    "currency": "INR",
                    "name": "MediAI Premium",
                    "order_id": "{{ $razorpayOrderId }}",
                    "handler": function (response){
                        fetch('{{ route('checkout.verify') }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_order_id: response.razorpay_order_id,
                                razorpay_signature: response.razorpay_signature
                            })
                        }).then(res => res.json()).then(data => {
                            if(data.status === 'success') window.location.href = data.redirect_url;
                            else alert(data.message || 'Verification Failed');
                        });
                    },
                    "prefill": { "name": "{{ $userName }}", "email": "{{ $userEmail }}", "contact": "{{ $userPhone }}" },
                    "theme": { "color": "#10B981" }
                };
                new Razorpay(options).open();
            });
        </script>
        @endif
    @endpush
</x-app-layout>