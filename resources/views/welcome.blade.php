<x-layouts.guest>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text fade-in">
                <div class="badge">
                    <span class="badge-icon">🎮</span>
                    New: Free Play Mode Available!
                </div>
                <h1>The Daily Word Game for <span>Laravel</span> Developers</h1>
                <p>Challenge yourself with PHP and Laravel terminology. One word per day. Six guesses. How well do you know your framework?</p>
                <div class="hero-buttons">
                    @auth
                        <a href="{{ url('/game') }}" class="btn btn-primary">Play Today's Word →</a>
                    @else
                        <a href="{{ url('/game/register') }}" class="btn btn-primary">Start Playing Free →</a>
                        <a href="#how-to-play" class="btn btn-secondary">Learn More</a>
                    @endauth
                </div>

                <div class="game-modes">
                    <div class="mode-card featured">
                        <div class="mode-icon">📅</div>
                        <div class="mode-info">
                            <h4>Daily Challenge</h4>
                            <p>Same word for everyone, once per day</p>
                        </div>
                    </div>
                    <div class="mode-card">
                        <div class="mode-icon">♾️</div>
                        <div class="mode-info">
                            <h4>Free Play</h4>
                            <p>Unlimited practice, random words</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="demo-game fade-in delay-2">
                <div class="game-board">
                    <div class="game-row">
                        <div class="game-tile correct">B</div>
                        <div class="game-tile absent">L</div>
                        <div class="game-tile present">A</div>
                        <div class="game-tile absent">D</div>
                        <div class="game-tile absent">E</div>
                    </div>
                    <div class="game-row">
                        <div class="game-tile absent">M</div>
                        <div class="game-tile correct">O</div>
                        <div class="game-tile absent">D</div>
                        <div class="game-tile absent">E</div>
                        <div class="game-tile absent">L</div>
                    </div>
                    <div class="game-row">
                        <div class="game-tile correct">B</div>
                        <div class="game-tile correct">O</div>
                        <div class="game-tile correct">A</div>
                        <div class="game-tile correct">R</div>
                        <div class="game-tile correct">D</div>
                    </div>
                    <div class="game-row">
                        <div class="game-tile"></div>
                        <div class="game-tile"></div>
                        <div class="game-tile"></div>
                        <div class="game-tile"></div>
                        <div class="game-tile"></div>
                    </div>
                    <div class="game-row">
                        <div class="game-tile"></div>
                        <div class="game-tile"></div>
                        <div class="game-tile"></div>
                        <div class="game-tile"></div>
                        <div class="game-tile"></div>
                    </div>
                    <div class="game-row">
                        <div class="game-tile"></div>
                        <div class="game-tile"></div>
                        <div class="game-tile"></div>
                        <div class="game-tile"></div>
                        <div class="game-tile"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="features-inner">
            <div class="section-header fade-in">
                <h2>Why Play Laraword?</h2>
                <p>More than just a game — it's a fun way to keep your Laravel knowledge sharp.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card fade-in delay-1">
                    <div class="feature-icon">🎯</div>
                    <h3>Daily Challenge</h3>
                    <p>A new PHP/Laravel-themed word every day. Come back tomorrow for a fresh puzzle!</p>
                </div>
                <div class="feature-card fade-in delay-2">
                    <div class="feature-icon">♾️</div>
                    <h3>Free Play Mode</h3>
                    <p>Practice anytime with unlimited random words. Perfect for warming up or learning new terms.</p>
                </div>
                <div class="feature-card fade-in delay-3">
                    <div class="feature-icon">🧠</div>
                    <h3>Learn While Playing</h3>
                    <p>Reinforce your knowledge of Laravel concepts, PHP functions, and dev terminology.</p>
                </div>
                <div class="feature-card fade-in delay-1">
                    <div class="feature-icon">🏆</div>
                    <h3>Leaderboards</h3>
                    <p>Compete with other developers. Track your streaks and climb the rankings.</p>
                </div>
                <div class="feature-card fade-in delay-2">
                    <div class="feature-icon">📚</div>
                    <h3>Word Bank</h3>
                    <p>Explore all the Laravel terms in our database. Learn something new every day.</p>
                </div>
                <div class="feature-card fade-in delay-3">
                    <div class="feature-icon">📊</div>
                    <h3>Track Progress</h3>
                    <p>Your game state saves automatically. Come back anytime to finish your puzzle.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Play Section -->
    <section class="how-to-play" id="how-to-play">
        <div class="how-to-play-inner">
            <div class="section-header fade-in">
                <h2>How to Play</h2>
                <p>Simple rules, endless fun. Here's how Laraword works.</p>
            </div>
            <div class="rules-list">
                <div class="rule-item fade-in delay-1">
                    <div class="rule-number">1</div>
                    <div class="rule-content">
                        <h3>Guess the Word</h3>
                        <p>You have 6 attempts to guess the 5-letter PHP/Laravel term. Type your guess and press Enter.</p>
                    </div>
                </div>
                <div class="rule-item fade-in delay-2">
                    <div class="rule-number">2</div>
                    <div class="rule-content">
                        <h3>Check the Colors</h3>
                        <p>After each guess, the tiles change color to show how close you are to the answer.</p>
                    </div>
                </div>
                <div class="rule-item fade-in delay-3">
                    <div class="rule-number">3</div>
                    <div class="rule-content">
                        <h3>Use the Clues</h3>
                        <p>Use the feedback from previous guesses to narrow down the word. The keyboard shows which letters you've tried.</p>
                    </div>
                </div>
                <div class="rule-item fade-in delay-4">
                    <div class="rule-number">4</div>
                    <div class="rule-content">
                        <h3>Choose Your Mode</h3>
                        <p>Play the daily challenge to compete with everyone, or try free play for unlimited practice!</p>
                    </div>
                </div>
            </div>
            <div class="color-legend fade-in">
                <div class="legend-item">
                    <div class="legend-tile correct">A</div>
                    <span class="legend-text">Correct position</span>
                </div>
                <div class="legend-item">
                    <div class="legend-tile present">B</div>
                    <span class="legend-text">Wrong position</span>
                </div>
                <div class="legend-item">
                    <div class="legend-tile absent">C</div>
                    <span class="legend-text">Not in word</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats/Links Section -->
    <section class="stats-section">
        <div class="stats-inner">
            <div class="section-header fade-in">
                <h2>Explore More</h2>
                <p>Check out the leaderboards and word bank.</p>
            </div>
            <div class="stats-grid">
                <a href="{{ url('/leaderboards') }}" class="stat-card fade-in delay-1">
                    <div class="stat-icon">🏆</div>
                    <div class="stat-info">
                        <h3>Leaderboards</h3>
                        <p>See top players, streaks, and stats</p>
                    </div>
                    <span class="stat-arrow">→</span>
                </a>
                <a href="{{ url('/word-bank') }}" class="stat-card fade-in delay-2">
                    <div class="stat-icon">📚</div>
                    <div class="stat-info">
                        <h3>Word Bank</h3>
                        <p>Browse all Laravel terms</p>
                    </div>
                    <span class="stat-arrow">→</span>
                </a>
            </div>
        </div>
    </section>
</x-layouts.guest>