<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ __('MediAI') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-[url('/storage/app/public/backgroundImage/bg2.jpg')] bg-cover bg-fixed bg-no-repeat bg-center flex flex-col">
            
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-[#030508]">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="bg-gray-900 text-gray-300">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <div>
                        <h3 class="text-white font-bold mb-4">About MediAI</h3>
                        <p class="text-sm">Your trusted AI-powered health companion for smart healthcare solutions.</p>
                    </div>
                    <div>
                        <h3 class="text-white font-bold mb-4">Quick Links</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="/shop" class="hover:text-white transition-colors">Shop Medicines</a></li>
                            <li><a href="/dashboard" class="hover:text-white transition-colors">AI Doctor</a></li>
                            <li><a href="/" class="hover:text-white transition-colors">About Us</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-white font-bold mb-4">Follow Us</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-white transition-colors">Facebook</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Twitter</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Instagram</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-700 pt-8">
                    <p class="font-bold text-red-500 mb-2">MEDICAL DISCLAIMER</p>
                    <p class="text-sm text-gray-400 max-w-3xl">
                        MediAI and its AI Health Assistant are not medical professionals. The information and recommendations provided are for informational purposes only and do not constitute medical advice. Consult a qualified doctor or healthcare professional for an accurate diagnosis and treatment plan. If you are in an emergency, call your local emergency services.
                    </p>
                    <p class="mt-4 text-sm">&copy; {{ date('Y') }} MediAI. All rights reserved.</p>
                </div>
            </div>
        </footer>
        </div>   
        
        @stack('scripts')
    </body>
</html>