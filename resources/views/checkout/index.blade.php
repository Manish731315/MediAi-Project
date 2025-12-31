<x-app-layout>
    {{-- 1. Add Razorpay Checkout Script --}}
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout & Payment') }}
        </h2>
    </x-slot>
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Whoops! Something went wrong.</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- We add x-data here for Alpine.js --}}
            <form action="{{ route('checkout.store') }}" method="POST" x-data="{ paymentMethod: 'card' }">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Left Column: Payment Details -->
                   <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-semibold mb-4">Shipping Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <x-input-label value="Name" />
                                    <x-text-input class="block mt-1 w-full bg-gray-100 cursor-not-allowed" type="text" value="{{ Auth::user()->name }}" readonly />
                                </div>
                                <div>
                                    <x-input-label value="Phone" />
                                    <x-text-input class="block mt-1 w-full bg-gray-100 cursor-not-allowed" type="text" value="{{ Auth::user()->phone }}" readonly />
                                </div>
                            </div>

                            <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2 border-b pb-1">Address</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                
                                <div class="md:col-span-2">
                                    <x-input-label for="delivery_address" value="Street Address / House No." />
                                    <x-text-input id="delivery_address" name="delivery_address" class="block mt-1 w-full" type="text" :value="Auth::user()->address" required placeholder="Flat No, Building, Street" />
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="landmark" value="Landmark (Optional)" />
                                    <x-text-input id="landmark" name="landmark" class="block mt-1 w-full" type="text" :value="Auth::user()->landmark" placeholder="Near City Hospital" />
                                </div>

                                <div>
                                    <x-input-label for="city" value="City" />
                                    <x-text-input id="city" name="city" class="block mt-1 w-full" type="text" :value="Auth::user()->city" required />
                                </div>

                                <div>
                                    <x-input-label for="state" value="State" />
                                    <x-text-input id="state" name="state" class="block mt-1 w-full" type="text" :value="Auth::user()->state" required />
                                </div>

                                <div>
                                    <x-input-label for="pincode" value="Pincode" />
                                    <x-text-input id="pincode" name="pincode" class="block mt-1 w-full" type="text" :value="Auth::user()->pincode" required pattern="[0-9]{6}" />
                                </div>

                                <div>
                                    <x-input-label for="country" value="Country" />
                                    <x-text-input id="country" name="country" class="block mt-1 w-full bg-gray-100" type="text" value="India" readonly />
                                </div>
                                
                                <div>
                                    <x-input-label for="alternate_phone" value="Alternate Phone (Optional)" />
                                    <x-text-input id="alternate_phone" name="alternate_phone" class="block mt-1 w-full" type="text" />
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Please confirm or update your delivery address for this order.</p>
                        </div>
                    </div>


                
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-semibold mb-4">Payment Method</h3>

                            <!-- Payment Method Toggles -->
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border dark:border-gray-700 rounded-lg cursor-pointer" :class="{ 'bg-blue-50 dark:bg-blue-900 border-blue-500': paymentMethod === 'card' }">
                                    <input type="radio" name="payment_method" value="card" x-model="paymentMethod" class="text-blue-600">
                                    <span class="ms-3 font-medium dark:text-gray-200">Pay with Card / UPI / Netbanking</span>
                                </label>
                                <label class="flex items-center p-4 border dark:border-gray-700 rounded-lg cursor-pointer" :class="{ 'bg-blue-50 dark:bg-blue-900 border-blue-500': paymentMethod === 'cod' }">
                                    <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="text-blue-600">
                                    <span class="ms-3 font-medium dark:text-gray-200">Cash on Delivery (COD)</span>
                                </label>
                            </div>

                            <!-- Dummy Card Form (Hidden) -->
                            <div class="space-y-4 mt-6" x-show="paymentMethod === 'card'" x-transition>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    You will be redirected to our secure payment gateway (Razorpay).
                                </p>
                            </div>
                            
                            <!-- COD Info (Conditional) -->
                            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg" x-show="paymentMethod === 'cod'" x-transition>
                                <p class="text-sm text-gray-700 dark:text-gray-200">
                                    You have selected Cash on Delivery. You will pay for your order when it arrives at your doorstep.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Order Summary -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-semibold mb-4">Order Summary</h3>
                            
                            <div class="space-y-3 mb-4">
                                @foreach($cartItems as $item)
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-medium">{{ $item->medicine->name }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Qty: {{ $item->quantity }}</p>
                                        </div>
                                        {{-- 2. Update Currency --}}
                                        <p class="text-gray-700 dark:text-gray-300 font-medium">₹{{ number_format($item->medicine->price * $item->quantity, 2) }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t dark:border-gray-700 pt-4">
                                <div class="flex justify-between items-center font-bold text-xl">
                                    <span>Total:</span>
                                    <span>₹{{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            @if($requiresPrescription)
                                <div class="mt-4 p-3 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 border border-yellow-300 dark:border-yellow-700 rounded-lg">
                                    <p class="font-bold">Prescription Required</p>
                                    <p class="text-sm">You will be asked to upload one after placing your order.</p>
                                </div>
                            @endif

                            <div class="mt-6">
                                <x-primary-button class="w-full justify-center text-lg py-3">
                                    <span x-show="paymentMethod === 'card'">Pay ₹{{ number_format($total, 2) }}</span>
                                    <span x-show="paymentMethod === 'cod'">Place Order (COD)</span>
                                </x-primary-button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- 3. Add Razorpay JS Logic --}}
    @push('scripts')
        {{-- This script block only runs if the controller passed Razorpay data --}}
        @if(isset($razorpayOrderId))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var options = {
                    "key": "{{ $razorpayKeyId }}",
                    "amount": "{{ $total * 100 }}", // Amount in paise
                    "currency": "INR",
                    "name": "MediAI",
                    "description": "Payment for Order",
                    "order_id": "{{ $razorpayOrderId }}",
                    "handler": function (response){
                        // This function is called when payment is successful
                        
                        // Send the payment details to our server for verification
                        fetch('{{ route('checkout.verify') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                razorpay_payment_id: response.razorpay_payment_id,
                                razorpay_order_id: response.razorpay_order_id,
                                razorpay_signature: response.razorpay_signature
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.status === 'success') {
                                // Redirect to the success page
                                window.location.href = data.redirect_url;
                            } else {
                                // Payment failed verification
                                alert(data.message || 'Payment verification failed. Please contact support.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred during payment verification. Please contact support.');
                        });
                    },
                    "prefill": {
                        "name": "{{ $userName }}",
                        "email": "{{ $userEmail }}",
                        "contact": "{{ $userPhone }}"
                    },
                    "theme": {
                        "color": "#3B82F6" // Blue color
                    }
                };
                
                var rzp1 = new Razorpay(options);
                
                rzp1.on('payment.failed', function (response){
                    alert('Payment failed: ' + response.error.description);
                });
                
                // Open the modal immediately
                rzp1.open();
            });
        </script>
        @endif
    @endpush
</x-app-layout>