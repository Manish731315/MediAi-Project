<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('We have sent a verification code to your Email and Phone. Please enter both below to complete registration.') }}
        <br>
        <strong>(Developer Note: Check storage/logs/laravel.log for the codes)</strong>
    </div>

    <form method="POST" action="{{ route('verification.verify') }}">
        @csrf

        <div>
            <x-input-label for="email_otp" :value="__('Email OTP')" />
            <x-text-input id="email_otp" class="block mt-1 w-full" type="text" name="email_otp" required autofocus />
            <x-input-error :messages="$errors->get('email_otp')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="phone_otp" :value="__('Phone OTP')" />
            <x-text-input id="phone_otp" class="block mt-1 w-full" type="text" name="phone_otp" required />
            <x-input-error :messages="$errors->get('phone_otp')" class="mt-2" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Verify & Register') }}
            </x-primary-button>
        </div>
    </form>
    <div class="mt-6 text-center">
        <p id="timer-text" class="text-sm text-gray-600 dark:text-gray-400">
            Resend code in <span id="timer" class="font-bold text-blue-600">60</span> seconds
        </p>
        
        <form id="resend-form" method="POST" action="{{ route('verification.resend') }}" class="hidden">
            @csrf
            <button type="submit" class="text-sm text-blue-600 hover:underline font-semibold">
                Resend OTP
            </button>
        </form>
    </div>

    <script>
        let timeLeft = 60;
        const timerSpan = document.getElementById('timer');
        const timerText = document.getElementById('timer-text');
        const resendForm = document.getElementById('resend-form');

        const countdown = setInterval(() => {
            timeLeft--;
            timerSpan.innerText = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                timerText.classList.add('hidden'); // Hide the "Resend in..." text
                resendForm.classList.remove('hidden'); // Show the "Resend OTP" button
            }
        }, 1000);
    </script>
</x-guest-layout>