<footer class="welcome-footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <div class="logo-icon">L</div>
            Laraword
        </div>

        <div class="footer-links">
            @if (Route::currentRouteName() === 'welcome')
                <a href="{{ url('/#features') }}" class="footer-link">Features</a>
                <a href="{{ url('/#how-to-play') }}" class="footer-link">How to Play</a>
            @endif

            <a href="{{ route('leaderboards') }}" class="footer-link">Leaderboards</a>
            <a href="{{ route('word-bank') }}" class="footer-link">Word Bank</a>
        </div>

        <div class="social-links">
            <a href="https://bsky.app/profile/kyledoes.dev" class="social-link" target="_blank" rel="noopener" aria-label="Blue Sky">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bluesky" viewBox="0 0 16 16">
                    <path d="M3.468 1.948C5.303 3.325 7.276 6.118 8 7.616c.725-1.498 2.698-4.29 4.532-5.668C13.855.955 16 .186 16 2.632c0 .489-.28 4.105-.444 4.692-.572 2.04-2.653 2.561-4.504 2.246 3.236.551 4.06 2.375 2.281 4.2-3.376 3.464-4.852-.87-5.23-1.98-.07-.204-.103-.3-.103-.218 0-.081-.033.014-.102.218-.379 1.11-1.855 5.444-5.231 1.98-1.778-1.825-.955-3.65 2.28-4.2-1.85.315-3.932-.205-4.503-2.246C.28 6.737 0 3.12 0 2.632 0 .186 2.145.955 3.468 1.948"/>
                </svg>
            </a>
            <a href="https://github.com/kyledoesdev" class="social-link" target="_blank" rel="noopener" aria-label="GitHub">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
            </a>
            <a href="https://youtube.com/@kyledoesdev" class="social-link" target="_blank" rel="noopener" aria-label="YouTube">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
            </a>
        </div>

        <div class="footer-credit">
            <p>Made with ❤️ by <a href="https://kyledoes.dev" target="_blank">@kyledoesdev</a></p>
            <div class="footer-tech">
                Built with 
                <a href="https://laravel.com" target="_blank">Laravel</a> • 
                <a href="https://filamentphp.com" target="_blank">Filament</a> • 
                <a href="https://livewire.laravel.com" target="_blank">Livewire</a>
            </div>
        </div>
    </div>
</footer>