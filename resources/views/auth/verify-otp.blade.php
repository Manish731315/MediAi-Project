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
</x-guest-layout>