<nav x-data="{ open: false }" class="bg-white border-b border-bluegray-100 dark:bg-gray-900 dark:border-gray-100">
    <!-- Primary Navigation Menu -->
    <!-- Primary Navigation Menu for authentificated users -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-logo class="block h-9 w-auto">{{ config('app.name', 'My Address Book') }}</x-logo>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('dashboard') }}" class="text-bluegray-900 dark:text-bluegray-100"
                        :active="request()->routeIs('dashboard')">
                        @ucfirst(__('app.dashboard'))
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('front.country.index') }}" class="text-bluegray-900 dark:text-bluegray-100"
                        :active="request()->routeIs('front.country.*')">
                        @ucfirst(__('country.countries'))
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('front.category.index') }}" class="text-bluegray-900 dark:text-bluegray-100"
                        :active="request()->routeIs('front.category.*')">
                        @ucfirst(__('category.categories'))
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('front.address.index') }}" class="text-bluegray-900 dark:text-bluegray-100"
                        :active="request()->routeIs('front.address.*')">
                        @ucfirst(__('address.addresses'))
                    </x-jet-nav-link>
                    @auth
                    <x-jet-nav-link href="" class="text-bluegray-900 dark:text-bluegray-100"
                        :active="request()->routeIs('front.stat')">
                        @ucfirst(__('app.statistics'))
                    </x-jet-nav-link>
                    @endauth
                </div>
            </div>

            <div class="-mr-2 flex items-center">
                @auth
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-bluegray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md bg-white text-bluegray-500 hover:text-bluegray-700 dark:bg-black dark:text-bluegray-500 dark:hover:text-bluegray-300 focus:outline-none transition">
                                            {{ Auth::user()->name }}

                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-bluegray-400 dark:text-bluegray-600">
                                    @ucfirst(__('app.account_manage'))
                                </div>

                                <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                    @ucfirst(__('app.profile_manage'))
                                </x-jet-dropdown-link>

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                                @endif

                                <div class="border-t border-bluegray-100 dark:text-bluegray-900"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-jet-dropdown-link href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                        @ucfirst(__('auth.logout'))
                                    </x-jet-dropdown-link>
                                </form>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                </div>
                @else
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <div class="ml-3 relative">
                        <div class="block text-xs text-black dark:text-white">
                            <a href="{{ route('login') }}" title="@ucfirst(__('auth.login'))">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endauth

                <!-- Hamburger -->
                <div class="-mr-2 flex sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-black dark:text-white transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex ml-2">
                    <x-forms.button @click="darkMode = !darkMode" class="focus:outline-none focus:border-bluegray-300 transition text-black dark:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" x-show="darkMode === false" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" x-show="darkMode === true" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </x-forms.button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('dashboard') }}"
                class="text-bluegray-900 dark:text-bluegray-100" :active="request()->routeIs('dashboard')">
                @ucfirst(__('app.dashboard'))
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('front.country.index') }}"
                class="text-bluegray-900 dark:text-bluegray-100" :active="request()->routeIs('front.country.*')">
                @ucfirst(__('app.countries'))
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('front.category.index') }}"
                class="text-bluegray-900 dark:text-bluegray-100" :active="request()->routeIs('front.category.*')">
                @ucfirst(__('app.categories'))
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('front.address.index') }}"
                class="text-bluegray-900 dark:text-bluegray-100" :active="request()->routeIs('front.address.*')">
                @ucfirst(__('app.addresses'))
            </x-jet-responsive-nav-link>
            @auth
            <x-jet-responsive-nav-link href=""
                class="text-bluegray-900 dark:text-bluegray-100" :active="request()->routeIs('front.stat')">
                @ucfirst(__('app.statistics'))
            </x-jet-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-bluegray-200 dark:border-bluegray-800">
            <div class="flex items-center px-4">
                @auth
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="flex-shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-bluegray-800 dark:text-bluegray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-bluegray-500 dark:text-bluegray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    @ucfirst(__('app.profile_manage'))
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                    {{ __('API Tokens') }}
                </x-jet-responsive-nav-link>
                @endif

                <div class="border-t border-bluegray-100 dark:text-bluegray-900"></div>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        this.closest('form').submit();">
                        @ucfirst(__('auth.logout'))
                    </x-jet-responsive-nav-link>
                </form>

                @else
                <x-jet-nav-link href="{{ route('login') }}" class="text-bluegray-900 dark:text-bluegray-100" >
                    @ucfirst(__('auth.login'))
                </x-jet-nav-link>
                @endauth
            </div>
        </div>
    </div>
</nav>
