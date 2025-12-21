<nav class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-200">
    <div class="flex items-center justify-between px-4 py-3 md:px-8 md:py-4">

        <!-- Logo -->
        @include('filament.panels.project.partials.logo')

        <!-- Desktop Nav -->
        <div class="hidden md:flex items-center gap-2">
            <a href="{{ route('leaderboards') }}" class="rounded-lg px-4 py-2 text-sm font-medium
                {{ request()->is('leaderboards')
                    ? 'bg-gray-100 text-gray-900'
                    : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}
                transition"
            >
                Leaderboards
            </a>


            <a href="{{ route('word-bank') }}" class="rounded-lg px-4 py-2 text-sm font-medium
                {{ request()->is('word-bank')
                    ? 'bg-gray-100 text-gray-900'
                    : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}
                transition"
            >
                Word Bank
            </a>

            <div class="mx-2 h-6 w-px bg-gray-200"></div>

            @auth
                <a href="{{ route('filament.app.pages.dashboard') }}" class="btn btn-primary btn-sm">
                    Play Now
                </a>
            @else
                <a href="{{ route('filament.app.auth.login') }}" class="btn btn-ghost btn-sm">
                    Log In
                </a>
                <a href="{{ route('filament.app.auth.register') }}" class="btn btn-primary btn-sm">
                    Sign Up Free
                </a>
            @endauth
        </div>

        <!-- Mobile Toggle -->
        <button
            wire:click="toggle"
            class="md:hidden inline-flex items-center justify-center rounded-lg p-2
                   text-gray-700 hover:bg-gray-100"
            aria-label="Toggle menu"
        >
            @if (! $open)
                <!-- Hamburger -->
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            @else
                <!-- Close -->
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            @endif
        </button>
    </div>

    <!-- Mobile Menu -->
    @if ($open)
        <div class="md:hidden border-t border-gray-200 bg-white">
            <div class="flex flex-col px-4 py-4 gap-1">
                <a href="{{ route('leaderboards') }}"
                    wire:click="close"
                    class="flex items-center rounded-lg px-4 py-3 text-sm font-medium
                        {{ request()->is('leaderboards')
                            ? 'bg-red-50 text-red-700 border-l-4 border-red-600 pl-3'
                            : 'text-gray-700 hover:bg-gray-100' }}
                        transition"
                >
                    Leaderboards
                </a>


                <a href="{{ route('word-bank') }}"
                    wire:click="close"
                    class="flex items-center rounded-lg px-4 py-3 text-sm font-medium
                        {{ request()->is('word-bank')
                            ? 'bg-red-50 text-red-700 border-l-4 border-red-600 pl-3'
                            : 'text-gray-700 hover:bg-gray-100' }}
                        transition"
                >
                    Word Bank
                </a>

                <div class="my-3 h-px bg-gray-200"></div>

                @auth
                    <a href="{{ route('filament.app.pages.dashboard') }}"
                       wire:click="close"
                       class="btn btn-primary w-full text-center">
                        Play Now
                    </a>
                @else
                    <a href="{{ route('filament.app.auth.login') }}"
                       wire:click="close"
                       class="btn btn-ghost w-full text-center">
                        Log In
                    </a>

                    <a href="{{ route('filament.app.auth.register') }}"
                       wire:click="close"
                       class="btn btn-primary w-full text-center">
                        Sign Up Free
                    </a>
                @endauth
            </div>
        </div>
    @endif
</nav>
