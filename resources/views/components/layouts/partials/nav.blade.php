<nav class="welcome-nav">
    <a href="{{ url('/') }}" class="logo">
        <div class="logo-icon">L</div>
        Laraword
    </a>
    <div class="nav-links">
        @if (Route::currentRouteName() === 'welcome')
            <a href="{{ url('/#features') }}" class="nav-link">Features</a>
            <a href="{{ url('/#how-to-play') }}" class="nav-link">How to Play</a>
        @endif


        <a href="{{ route('leaderboards') }}" class="nav-link {{ request()->is('leaderboards') ? 'active' : '' }}">Leaderboards</a>
        <a href="{{ route('word-bank') }}" class="nav-link {{ request()->is('word-bank') ? 'active' : '' }}">Word Bank</a>
        
        <div class="nav-divider"></div>
        
        @auth
            <a href="{{ route('filament.app.pages.dashboard') }}" class="btn btn-primary btn-sm">Play Now</a>
        @else
            <a href="{{ route('filament.app.auth.login') }}" class="btn btn-ghost btn-sm">Log In</a>
            <a href="{{ route('filament.app.auth.register') }}" class="btn btn-primary btn-sm">Sign Up Free</a>
        @endauth
    </div>
</nav>