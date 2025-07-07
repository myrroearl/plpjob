<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Alumni Job Portal') }} - @yield('title')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        .mobile-menu.active {
            transform: translateX(0);
        }
        .hamburger-button {
            transition: all 0.3s ease-in-out;
        }
        .hamburger-button.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 6px);
        }
        .hamburger-button.active span:nth-child(2) {
            opacity: 0;
        }
        .hamburger-button.active span:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -6px);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <!-- Navigation -->
    <nav class="fixed -top-1 w-screen bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/img/plplogo.png') }}" alt="PLP Logo" class="h-8 w-auto mr-2"></a>
                        {{-- <a href="{{ route('home') }}"><img src="https://lh6.googleusercontent.com/0rCDC0TkoXRF7BlwjdEVHq9A69sIkx-n-NmGUdjVQwFWgV3nL05MDvsWImV61EGzmU2zyyVM0Rs_ZznBMf5rLKU=w16383" alt="PLP Logo" class="h-8 w-auto mr-2"></a> --}}
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-[#0e2b6b]">Job Placement Office</a>
                    </div>
                    @auth
                        <!-- Desktop Navigation -->
                        <div class="hidden md:ml-6 md:flex md:space-x-8">
                            <a href="{{ route('home') }}" 
                               class="{{ request()->routeIs('home') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Home
                            </a>
                            <a href="{{ route('alumnidashboard') }}" 
                               class="{{ request()->routeIs('alumnidashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Dashboard
                            </a>
                            <a href="{{ route('jobs.index') }}"
                               class="{{ request()->routeIs('jobs.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Browse Jobs
                            </a>
                            <a href="{{ route('companies.index') }}"
                               class="{{ request()->routeIs('companies.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Companies
                            </a>
                            <a href="{{ route('saved-jobs.index') }}"
                               class="{{ request()->routeIs('saved-jobs.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Saved Jobs
                            </a>
                        </div>
                    @endauth
                </div>

                <div class="flex items-center">
                    @auth
                        <!-- Mobile Navigation Controls -->
                        <div class="flex md:hidden items-center space-x-4">
                            <!-- Notifications for Mobile -->
                            <a href="{{ route('notifications.index') }}" class="relative text-gray-500 hover:text-gray-700">
                                <span class="sr-only">Notifications</span>
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>

                            <!-- Hamburger Button -->
                            <button type="button" class="hamburger-button inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                <span class="sr-only">Open menu</span>
                                <div class="flex flex-col space-y-1.5">
                                    <span class="block w-6 h-0.5 bg-current transition-transform duration-300"></span>
                                    <span class="block w-6 h-0.5 bg-current transition-opacity duration-300"></span>
                                    <span class="block w-6 h-0.5 bg-current transition-transform duration-300"></span>
                                </div>
                            </button>
                        </div>

                        <!-- Desktop Profile Dropdown -->
                        <div class="hidden md:block ml-3 relative">
                            <div class="flex flex-row items-center justify-center">
                                <a href="{{ route('notifications.index') }}" class="relative text-gray-500 hover:text-gray-700">
                                    <span class="sr-only">Notifications</span>
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">
                                            {{ auth()->user()->unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </a>
                                <button type="button" 
                                        class="profile-dropdown-button flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 ml-6" 
                                        id="user-menu-button"
                                        aria-expanded="false"
                                        aria-haspopup="true">
                                    <img class="h-8 w-8 rounded-full object-cover mr-2" 
                                         src="https://cdn-icons-png.flaticon.com/512/9187/9187604.png" 
                                         alt="{{ auth()->user()->first_name }}">
                                    <div style="d-flex flex-direction: column justify-content: left; align-items: left; text-align: left;">
                                        <h1>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }} </h1>
                                        <p>{{ auth()->user()->degree_name }}</p>
                                    </div>
                                    
                                </button>
                            </div>

                            <!-- Dropdown menu -->
                            <div class="profile-dropdown-menu hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                                 role="menu"
                                 aria-orientation="vertical"
                                 aria-labelledby="user-menu-button"
                                 tabindex="-1">
                                <a href="{{ route('profile.edit') }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                   role="menuitem">
                                    Edit Profile
                                </a>
                                <a href="{{ route('feedback.index') }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                   role="menuitem">
                                    Submit Feedback
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                            role="menuitem">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="space-x-4">
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Login</a>
                            <!-- @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                    Register
                                </a>
                            @endif -->
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        @auth
        <div class="mobile-menu fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform z-50 overflow-y-auto md:hidden">
            <div class="px-4 py-6 space-y-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Menu</h2>
                    <button class="mobile-close p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <nav class="space-y-2">
                    <a href="{{ route('home') }}" 
                       class="block px-4 py-3 rounded-lg {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        Home
                    </a>
                    <a href="{{ route('alumnidashboard') }}" 
                       class="block px-4 py-3 rounded-lg {{ request()->routeIs('alumnidashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('jobs.index') }}" 
                       class="block px-4 py-3 rounded-lg {{ request()->routeIs('jobs.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        Browse Jobs
                    </a>
                    <a href="{{ route('companies.index') }}" 
                       class="block px-4 py-3 rounded-lg {{ request()->routeIs('companies.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        Companies
                    </a>
                    <a href="{{ route('saved-jobs.index') }}" 
                       class="block px-4 py-3 rounded-lg {{ request()->routeIs('saved-jobs.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">
                        Saved Jobs
                    </a>
                </nav>

                <div class="border-t border-gray-200 pt-4">
                    
                    <div class="space-y-2">
                        <a href="{{ route('profile.edit') }}" 
                           class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50">
                            Edit Profile
                        </a>
                        <a href="{{ route('feedback.index') }}" 
                           class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50">
                            Submit Feedback
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full text-left px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-50">
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endauth
    </nav>
    <div class="mt-14">

    </div>
    
    <!-- Page Content -->
    <main>
        
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        @if (session('success'))
        <div class="fixed bottom-4 right-4 z-50 max-w-sm">
            <div class="bg-green-50 border-l-4 border-green-400 p-4 shadow-lg"> 
                <div class="flex"> 
                    <div class="flex-shrink-0"> 
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"> 
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/> 
                        </svg> 
                    </div> 
                    <div class="ml-3"> 
                        <p class="text-sm text-green-700"> 
                            {{ session('success') }} 
                        </p> 
                    </div> 
                </div> 
            </div> 
        </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-50 border-l-4 border-red-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="text-white mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg text-black font-semibold mb-4">About Us</h3>
                    <p class="text-gray-600">
                        Connecting talented alumni with great career opportunities.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg text-black font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#" class="hover:underline">Find Jobs</a></li>
                        <li><a href="#" class="hover:underline">Companies</a></li>
                        <li><a href="#" class="hover:underline">About Us</a></li>
                        <li><a href="#" class="hover:underline">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg text-black font-semibold mb-4">Contact Us</h3>
                    <p class="text-gray-600">
                        Email: plpasig.com<br>
                        Phone: (123) 456-7890
                    </p>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
    <script>
        $(document).ready(function() {
            // Toggle dropdown menu (desktop)
            $('.profile-dropdown-button').click(function(e) {
                e.stopPropagation();
                $('.profile-dropdown-menu').toggleClass('hidden');
            });

            // Close dropdown when clicking outside (desktop)
            $(document).click(function(e) {
                if (!$(e.target).closest('.profile-dropdown-menu').length) {
                    $('.profile-dropdown-menu').addClass('hidden');
                }
            });

            // Mobile menu functionality
            $('.hamburger-button').click(function() {
                $(this).toggleClass('active');
                $('.mobile-menu').toggleClass('active');
                $('body').toggleClass('overflow-hidden');
            });

            $('.mobile-close').click(function() {
                $('.hamburger-button').removeClass('active');
                $('.mobile-menu').removeClass('active');
                $('body').removeClass('overflow-hidden');
            });

            // Close mobile menu when clicking outside
            $(document).click(function(e) {
                if (!$(e.target).closest('.mobile-menu').length && 
                    !$(e.target).closest('.hamburger-button').length) {
                    $('.hamburger-button').removeClass('active');
                    $('.mobile-menu').removeClass('active');
                    $('body').removeClass('overflow-hidden');
                }
            });
        });
    </script>
    
</body>
</html>