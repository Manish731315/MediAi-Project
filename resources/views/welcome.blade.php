<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MediAI - Your AI Health Assistant</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-gray-100">

        <nav class="bg-white dark:bg-gray-900 shadow-md fixed w-full z-50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex-shrink-0">
                        <a href="/" class="text-2xl font-bold">
                            <span class="text-white">Medi</span><span class="text-blue-600">AI</span>
                        </a>
                    </div>

                    <div class="hidden md:flex md:items-center md:space-x-8">
                        
                        <a href="{{ route('shop.index') }}" class="text-white hover:text-blue-600 font-medium transition-colors">
                            Shop Medicines
                        </a>
                        <a href="{{ route('dashboard') }}" class="text-white hover:text-blue-600 font-medium transition-colors">
                            AI Doctor
                        </a>
                    </div>

                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            <nav class="flex items-center justify-end gap-4">
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                                    >
                                        Dashboard
                                    </a>
                        @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">Log in</a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-full transition-all duration-300 hover:shadow-lg transform hover:scale-105">Register</a>
                        @endif
                    @endauth
                    </div>
                    @endif
                </div>
            </div>
        </nav>

        <main>
            {{-- Hero Section --}}
            <div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-[url('/storage/backgroundImage/bg.jpg')] bg-cover bg-center shadow-2xl">

                {{-- Animated background shapes --}}
                <div class="absolute inset-0 z-0 opacity-10">
                    <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
                    <div class="absolute top-40 right-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl animate-pulse delay-2000"></div>
                    <div class="absolute bottom-10 left-1/3 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-xl animate-pulse delay-4000"></div>
                </div>

                <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-20">
                    <div class="mb-8 inline-block animate-bounce">
                        <span class="inline-block px-4 py-2 bg-white bg-opacity-20 text-white rounded-full text-sm font-semibold backdrop-blur-md">
                            ✨ Your AI-Powered Health Companion
                        </span>
                    </div>

                    <h1 class="text-5xl sm:text-6xl md:text-7xl font-extrabold tracking-tight text-[#31b6fd] mb-6">
                        Welcome to <span class="text-white relative">
                            Medi<span class="text-blue-600">AI</span>
                            <span class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-200 to-white transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </span>
                    </h1>

                    <p class="mt-6 text-lg sm:text-xl text-blue-50 max-w-3xl mx-auto leading-relaxed">
                        Your intelligent online pharmacy. Get AI-powered symptom analysis and shop for medicines, all in one place.
                    </p>

                    <div class="mt-12 flex flex-col sm:flex-row justify-center items-center gap-4">
                        <a href="{{ route('dashboard') }}" class="group inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white bg-blue-600 rounded-full shadow-xl hover:shadow-2xl hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">
                            <span class="mr-2">💬</span> Talk to AI Doctor
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </a>
                        <a href="{{ route('shop.index') }}" class="group inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-blue-600 bg-white rounded-full shadow-xl hover:shadow-2xl hover:bg-blue-50 transition-all duration-300 transform hover:scale-105">
                            <span class="mr-2">🛒</span> Shop Medicines
                        </a>
                    </div>

                    {{-- Scroll indicator --}}
                    <div class="mt-16 flex justify-center">
                        <div class="animate-bounce">
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Features Section --}}
            <section class="py-20 bg-[#020618] bg-cover bg-center"">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl font-extrabold text-white mb-4">
                            How We Can Help You
                        </h2>
                        <div class="w-20 h-1 bg-gradient-to-r from-blue-600 to-indigo-600 mx-auto rounded-full"></div>
                        <p class="mt-4 text-lg text-gray-100">
                            Safe, simple, and intelligent healthcare at your fingertips
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="group p-8 bg-[#051728] rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 cursor-pointer">
                            <div class="flex items-center justify-center h-20 w-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full mx-auto mb-6 shadow-lg group-hover:rotate-12 transition-transform">
                                <svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-3 text-center">AI Assistant</h3>
                            <p class="text-gray-200 text-center text-sm leading-relaxed">
                                Describe your symptoms and get instant, AI-driven recommendations for over-the-counter medicines available in our store.
                            </p>
                            <div class="mt-4 flex justify-center">
                                <span class="text-blue-600 font-semibold group-hover:translate-x-2 transition-transform inline-flex items-center">
                                    Learn more →
                                </span>
                            </div>
                        </div>
                        
                        <div class="group p-8 bg-[#051728] rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 cursor-pointer">
                            <div class="flex items-center justify-center h-20 w-20 bg-gradient-to-br from-green-400 to-green-600 rounded-full mx-auto mb-6 shadow-lg group-hover:rotate-12 transition-transform">
                                <svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-3 text-center">Full Online Pharmacy</h3>
                            <p class="text-gray-200 text-center text-sm leading-relaxed">
                                Browse and purchase from our wide selection of genuine medicines, health supplements, and wellness products.
                            </p>
                            <div class="mt-4 flex justify-center">
                                <span class="text-green-600 font-semibold group-hover:translate-x-2 transition-transform inline-flex items-center">
                                    Explore →
                                </span>
                            </div>
                        </div>

                        <div class="group p-8 bg-[#051728] rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 cursor-pointer">
                            <div class="flex items-center justify-center h-20 w-20 bg-gradient-to-br from-red-400 to-red-600 rounded-full mx-auto mb-6 shadow-lg group-hover:rotate-12 transition-transform">
                                <svg class="w-10 h-10 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12 12 0 0012 21.642a12 12 0 008.618-3.04A11.955 11.955 0 0112 2.944z" /></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-3 text-center">Safe & Secure</h3>
                            <p class="text-gray-200 text-center text-sm leading-relaxed">
                                Our AI provides guidance, not a diagnosis. We ensure your data and prescription orders are verified for your safety.
                            </p>
                            <div class="mt-4 flex justify-center">
                                <span class="text-red-600 font-semibold group-hover:translate-x-2 transition-transform inline-flex items-center">
                                    Details →
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- CTA Section --}}
            <section class="py-20 bg-[#020618]">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="text-4xl font-extrabold text-white mb-6">
                        Ready to Get Started?
                    </h2>
                    <p class="text-xl text-blue-100 mb-8">
                        Join thousands of people already using MediAI for their health needs.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="#" class="px-8 py-3 bg-white text-blue-600 font-semibold rounded-full hover:bg-blue-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            Get Started Now
                        </a>
                        <a href="#" class="px-8 py-3 bg-blue-700 text-white font-semibold rounded-full hover:bg-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 border-2 border-white">
                            Learn More
                        </a>
                    </div>
                </div>
            </section>
        </main>

        {{-- Footer --}}
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
                            <li><a href="#" class="hover:text-white transition-colors">Shop Medicines</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">AI Doctor</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
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
                    <p class="mt-6 text-sm text-gray-500">&copy; 2025 MediAI. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }

            .delay-2000 {
                animation-delay: 2s;
            }

            .delay-4000 {
                animation-delay: 4s;
            }
        </style>

    </body>
</html>





{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            
        @endif
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
                   
                    <div class="absolute inset-0 rounded-t-lg lg:rounded-t-none lg:rounded-r-lg shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]"></div>
                </div>
            </main>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html> --}}
