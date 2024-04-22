<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home_page') }}">
                        <x-application-logo class="block w-32 h-auto fill-current text-gray-800" />
                    </a>
                </div>
                <div class="hidden sm:flex sm:items-center ml-4">
                    @livewire('search')
                </div>
                <!-- Navigation Links -->
                
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @guest
                    <div class="hidden md:flex md:items-center md:space-x-2">
                        <div class="space-x-3 text-[1.6rem] ltr:mr-5 rtl:ml-5">
                            <a href="/login"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest ltr:mr-2 rtl:ml-2">{{ __('Login') }}</a>
                            <a href="/register"
                            class="inline-flex items-center px-4 py-2 font-semibold text-xs uppercase tracking-widest">{{ __('Register') }}</a>
                        </div>
                    </div>
                @endguest
                @auth
                    <div class="hidden md:flex md:flex-row space-x-3 items-center justify-center">
                        <div class="space-x-3 text-[1.6rem] mr-2 loading-5">
                            <a href=" {{ route('home_page') }} ">
                                {!! url()->current() == route('home_page')
                                    ?'<i class="bx bxs-home-alt-2"></i>'
                                    :'<i class="bx bx-home-alt-2"></i>'
                                !!}
                            </a>
                            <a href="{{route('explore')}}">
                                {!! url()->current() == route('explore')
                                    ?'<i class="bx bxs-compass"></i>'
                                    :'<i class="bx bx-compass"></i>'
                                !!}
                            </a>
                           {{-- <a href="{{route('post.create')}}">
                                {!! url()->current() == route('post.create')
                                    ?'<i class="bx bxs-message-square-add"></i>'
                                    :'<i class="bx bx-message-square-add"></i>'
                                !!}
                            </a>--}}
                            <button onclick="Livewire.dispatch('openModal', { component: 'create-post-modal'})">
                                <i class="bx bx-message-square-add"></i>
                            </button>
                        </div>
                        <x-dropdown align="right" width="96">
                        
                            <x-slot name="trigger">
                                    <button class="text-[1.6rem] ltr:mr-2 rtl:ml-2 leading-5">
                                        <div class="relative">
                                            <i class="bx bxs-inbox"></i>

                                            <livewire:pending-followers-count />
                                        </div>
                                    </button>
                            </x-slot>

                            <x-slot name="content">
                                <livewire:pending-followers-list />
                            </x-slot>
                        </x-dropdown>

                    </div>
                    <div class="hidden md:block">
                                
                            <x-dropdown align="right" width="48">
                        
                                <x-slot name="trigger">
                                        <div class="ml-4">
                                            <img src="{{ auth()->user()->getImage() }}" class="rounded-full w-10 h-10 cursor-pointer"/>
                                        </div>

                                    
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('user_profile' , ['user' => auth()->user()])">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>

                    </div>
                @endauth

            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home_page')" :active="request()->routeIs('home_page')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('explore')">{{ __('Explore') }}</x-responsive-nav-link>
            <x-responsive-nav-link class="cursor-pointer" onclick="Livewire.dispatch('openModal', { component: 'create-post-modal'})">{{ __('New Post') }}</x-responsive-nav-link>

        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @guest
                <x-responsive-nav-link :href="route('login')">{{ __('Login') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">{{ __('Register') }}</x-responsive-nav-link>
            @endguest
            {{-- <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            --}}
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
