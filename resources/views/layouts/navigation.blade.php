<nav x-data="{
        isScrollingDown: false,
        lastScrollTop: 0
     }"
     @scroll.window="
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        if (scrollTop > lastScrollTop && scrollTop > 80) {
            isScrollingDown = true;
        } else {
            isScrollingDown = false;
        }
        lastScrollTop = scrollTop;
     "
     :class="{ '-translate-y-full': isScrollingDown }"
     class="fixed w-full top-0 z-40 bg-dark-light border-b border-dark-lighter transform transition-transform duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-7 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('movies.index')" :active="request()->routeIs('movies.index')" class="text-gray-400 hover:text-primary-500">
                        Films
                    </x-nav-link>
                    <x-nav-link :href="route('tvshows.index')" :active="request()->routeIs('tvshows.index')" class="text-gray-400 hover:text-primary-500">
                        Séries
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 flex-1">
                <form action="{{ route('search') }}" method="GET" class="w-full max-w-xl mx-auto">
                    <div class="relative">
                        <input type="text" name="query" placeholder="Rechercher un film ou une série..."
                            value="{{ request('query') }}"
                            class="w-full px-4 py-2 bg-dark text-gray-400 rounded-lg
                                      border border-dark-lighter focus:outline-none
                                      focus:border-primary-500 focus:ring-1 focus:ring-primary-500">

                        <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2
                                       text-gray-400 hover:text-primary-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex items-center space-x-6">
                {{-- Barre de recherche (si vous en avez une) --}}

                @auth
                    {{-- Icône Favoris avec badge --}}
                    <a href="{{ route('favorites.index') }}"
                        class="relative group hidden sm:flex items-center hover:text-primary-500 transition-colors duration-200 {{ request()->routeIs('favorites.index') ? 'text-primary-500' : 'text-gray-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                            fill="{{ request()->routeIs('favorites.index') ? 'currentColor' : 'none' }}" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="hidden group-hover:block ml-2 text-sm">Favoris</span>
                    </a>

                    {{-- Dropdown Utilisateur --}}
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-dark-lighter text-sm leading-4 font-medium rounded-md text-gray-400 bg-dark hover:text-primary-500 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="bg-dark-light border border-dark-lighter rounded-md shadow-lg">
                                    <x-dropdown-link :href="route('profile.edit')"
                                        class="text-gray-400 hover:text-primary-500 hover:bg-dark-lighter">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="text-gray-400 hover:text-primary-500 hover:bg-dark-lighter">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    {{-- Boutons Connexion/Inscription --}}
                    <div class="hidden sm:flex sm:items-center space-x-4">
                        <a href="{{ route('login') }}"
                            class="text-gray-400 hover:text-primary-500 px-3 py-2 rounded-md text-sm font-medium">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-primary-600 hover:bg-primary-700 text-white px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                            Inscription
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger Button -->
            <div class="flex items-center sm:hidden space-x-4">
                @auth
                    {{-- Icône Favoris Mobile --}}
                    <a href="{{ route('favorites.index') }}"
                        class="relative flex items-center text-gray-400 hover:text-primary-500 transition-colors duration-200 {{ request()->routeIs('favorites.index') ? 'text-primary-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                            fill="{{ request()->routeIs('favorites.index') ? 'currentColor' : 'none' }}"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </a>
                @endauth

                <button @click="$dispatch('toggle-mobile-menu')"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-primary-500 hover:bg-dark-lighter focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

{{-- Menu Mobile séparé avec son propre état --}}
<div x-data="{ open: false }"
     @toggle-mobile-menu.window="open = !open"
     @keydown.escape.window="open = false"
     class="fixed inset-0 z-50 pointer-events-none">
    <x-mobile-menu />
</div>

{{-- Div de compensation --}}
<div class="h-16"></div>
