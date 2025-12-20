<div
    x-data="{
        board: @js($game->board_state),
        currentRowIndex: @js($currentRowIndex),
        status: @js($game->status),
        message: @js($message),
        alreadyPlayed: @js($alreadyPlayed ?? false),
        guessesAllowed: @js($guessesAllowed),
        wordLength: @js($wordLength),
        error: false,
        loading: false,
        guessedWords: [],
        letters: [
            ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P'],
            ['A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L'],
            ['Enter', 'Z', 'X', 'C', 'V', 'B', 'N', 'M', 'Backspace']
        ],
        keyStatuses: {},

        init() {
            this.buildKeyStatuses();
            this.buildGuessedWords();
        },

        buildKeyStatuses() {
            this.board.flat().filter(t => t.status).forEach(tile => {
                const key = tile.letter.toUpperCase();
                if (tile.status === 'correct') {
                    this.keyStatuses[key] = 'correct';
                } else if (tile.status === 'present' && this.keyStatuses[key] !== 'correct') {
                    this.keyStatuses[key] = 'present';
                } else if (tile.status === 'absent' && !this.keyStatuses[key]) {
                    this.keyStatuses[key] = 'absent';
                }
            });
        },

        buildGuessedWords() {
            this.board.forEach(row => {
                const word = row.map(t => t.letter).join('');
                if (word.length === this.wordLength && row[0].status) {
                    this.guessedWords.push(word.toLowerCase());
                }
            });
        },

        get currentRow() {
            return this.board[this.currentRowIndex] || [];
        },

        get currentGuess() {
            return this.currentRow.map(t => t.letter).join('');
        },

        onKeyPress(key) {
            if (this.status !== 'active' || this.loading) return;
            
            this.error = false;

            if (/^[A-Za-z]$/.test(key)) {
                this.fillTile(key);
            } else if (key === 'Backspace') {
                this.emptyTile();
                this.message = '';
            } else if (key === 'Enter') {
                this.submitGuess();
            }
        },

        fillTile(key) {
            for (let i = 0; i < this.currentRow.length; i++) {
                if (!this.currentRow[i].letter) {
                    this.board[this.currentRowIndex][i].letter = key.toLowerCase();
                    break;
                }
            }
        },

        emptyTile() {
            for (let i = this.currentRow.length - 1; i >= 0; i--) {
                if (this.currentRow[i].letter) {
                    this.board[this.currentRowIndex][i].letter = '';
                    break;
                }
            }
        },

        async submitGuess() {
            const guess = this.currentGuess.toLowerCase();
            
            if (guess.length < this.wordLength) return;

            if (this.guessedWords.includes(guess)) {
                this.error = true;
                this.message = 'Already guessed!';
                return;
            }

            if (this.loading) return;
            
            this.loading = true;
            this.message = '';
            
            try {
                const result = await $wire.submitGuess(guess);
                
                if (!result.success) {
                    this.error = true;
                    this.message = result.error;
                    this.loading = false;
                    return;
                }

                this.guessedWords.push(guess);

                result.statuses.forEach((status, i) => {
                    this.board[this.currentRowIndex][i].status = status;
                    const key = guess[i].toUpperCase();
                    if (status === 'correct') {
                        this.keyStatuses[key] = 'correct';
                    } else if (status === 'present' && this.keyStatuses[key] !== 'correct') {
                        this.keyStatuses[key] = 'present';
                    } else if (status === 'absent' && !this.keyStatuses[key]) {
                        this.keyStatuses[key] = 'absent';
                    }
                });

                if (result.won) {
                    this.status = 'won';
                    this.message = result.message;
                    if (typeof confetti === 'function') {
                        confetti({ particleCount: 100, spread: 70, origin: { y: 0.6 } });
                    }
                } else if (result.lost) {
                    this.status = 'lost';
                    this.message = result.message;
                } else {
                    this.currentRowIndex = result.nextRow;
                }
            } catch (e) {
                this.error = true;
                this.message = 'Something went wrong';
                console.error(e);
            }
            
            this.loading = false;
        },

        getKeyStatus(key) {
            return this.keyStatuses[key.toUpperCase()] || '';
        }
    }"
    x-init="init()"
    @keydown.window="
        if ($event.target.tagName === 'INPUT' || $event.target.tagName === 'TEXTAREA') return;
        if ($event.key === 'Enter' || $event.key === 'Backspace' || /^[a-zA-Z]$/.test($event.key)) {
            $event.preventDefault();
            onKeyPress($event.key);
        }
    "
    class="wordle-container"
    wire:ignore.self
>
    <!-- Floating Laravel Cubes Background -->
    <div class="laravel-cubes-bg" aria-hidden="true">
        @for ($i = 0; $i < 10; $i++)
            <div class="laravel-cube"></div>
        @endfor
    </div>

    <div class="wordle-main">
        <div class="wordle-header">
            <h2 class="wordle-title">LaraWord {{ $isFreePlay ? '(Free Play)' : '' }}</h2>
            <p class="wordle-subtitle">Guess the PHP/Laravel term</p>
        </div>

        @if ($isFreePlay && $game->isComplete())
            <a href="{{ route('filament.app.pages.free-play') }}" class="btn btn-primary btn-sm">Play Again?</a>
        @endif

        <template x-if="alreadyPlayed">
            <div class="already-played-notice">
                <p>You've already played today! Come back tomorrow for a new word.</p>
            </div>
        </template>

        <div class="wordle-game">
            <template x-for="(row, rowIndex) in board" :key="'row-' + rowIndex">
                <div 
                    class="wordle-row"
                    :class="{ 'invalid': error && rowIndex === currentRowIndex }"
                >
                    <template x-for="(tile, tileIndex) in row" :key="'tile-' + rowIndex + '-' + tileIndex">
                        <div 
                            class="wordle-tile"
                            :class="{
                                'filled': tile.letter && !tile.status,
                                'correct': tile.status === 'correct',
                                'present': tile.status === 'present',
                                'absent': tile.status === 'absent'
                            }"
                            x-text="tile.letter.toUpperCase()"
                        ></div>
                    </template>
                </div>
            </template>
        </div>

        <div 
            class="wordle-message"
            :class="{ 'error': error }"
            x-text="message"
        ></div>

        <div class="wordle-keyboard">
            <template x-for="(letterRow, rowIndex) in letters" :key="'kb-' + rowIndex">
                <div class="keyboard-row">
                    <template x-for="key in letterRow" :key="'key-' + key">
                        <button
                            type="button"
                            class="wordle-key"
                            :class="{
                                'wide': key === 'Enter' || key === 'Backspace',
                                'correct': getKeyStatus(key) === 'correct',
                                'present': getKeyStatus(key) === 'present',
                                'absent': getKeyStatus(key) === 'absent'
                            }"
                            @click="onKeyPress(key)"
                            :disabled="status !== 'active' || loading"
                        >
                            <span x-text="key === 'Backspace' ? '⌫' : (key === 'Enter' ? 'ENTER' : key)"></span>
                        </button>
                    </template>
                </div>
            </template>
        </div>
    </div>

    <style>
        .wordle-container {
            --correct: #22c55e;
            --present: #eab308;
            --absent: #6b7280;
            --laravel: #FF2D20;
            --laravel-dark: #e6291c;
            font-family: system-ui, -apple-system, sans-serif;
            position: relative;
        }

        .wordle-main {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1rem;
            max-width: 500px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .wordle-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .wordle-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 0.5rem;
            color: var(--laravel);
        }

        .wordle-subtitle {
            font-size: 0.875rem;
            color: rgb(var(--gray-500));
            margin: 0;
        }

        .wordle-message {
            min-height: 1.75rem;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 1rem;
            color: var(--laravel);
        }

        .wordle-message.error {
            color: #dc2626;
        }

        .wordle-message:empty {
            visibility: hidden;
        }

        .already-played-notice {
            background: linear-gradient(135deg, #fef2f2 0%, #fff 100%);
            border: 2px solid var(--laravel);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .dark .already-played-notice {
            background: linear-gradient(135deg, rgba(255,45,32,0.1) 0%, rgba(255,45,32,0.05) 100%);
        }

        .already-played-notice p {
            margin: 0;
            color: var(--laravel-dark);
            font-weight: 500;
        }

        .dark .already-played-notice p {
            color: #fca5a5;
        }

        .wordle-game {
            background: white;
            border: 3px solid var(--laravel);
            border-radius: 16px;
            padding: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(255, 45, 32, 0.1), 0 2px 4px -2px rgba(255, 45, 32, 0.1);
        }

        .dark .wordle-game {
            background: rgb(var(--gray-900));
            border-color: var(--laravel);
        }

        .wordle-row {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .wordle-row:last-child {
            margin-bottom: 0;
        }

        .wordle-tile {
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            text-transform: uppercase;
            border: 2px solid rgb(var(--gray-300));
            border-radius: 8px;
            background: rgb(var(--gray-50));
            color: rgb(var(--gray-900));
            transition: all 0.15s ease;
        }

        .dark .wordle-tile {
            background: rgb(var(--gray-800));
            border-color: rgb(var(--gray-600));
            color: white;
        }

        .wordle-tile.filled {
            border-color: var(--laravel);
            background: white;
        }

        .dark .wordle-tile.filled {
            background: rgb(var(--gray-700));
            border-color: var(--laravel);
        }

        .wordle-tile.correct {
            background: var(--correct);
            border-color: var(--correct);
            color: white;
        }

        .wordle-tile.present {
            background: var(--present);
            border-color: var(--present);
            color: white;
        }

        .wordle-tile.absent {
            background: var(--absent);
            border-color: var(--absent);
            color: white;
        }

        .wordle-row.invalid .wordle-tile:not(.correct):not(.present):not(.absent) {
            border-color: #dc2626;
            animation: shake 0.3s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }

        .wordle-keyboard {
            width: 100%;
            max-width: 484px;
        }

        .keyboard-row {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-bottom: 6px;
        }

        .wordle-key {
            min-width: 36px;
            height: 52px;
            padding: 0 12px;
            border: none;
            border-radius: 6px;
            background: rgb(var(--gray-200));
            color: rgb(var(--gray-900));
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.1s ease;
            flex: 1;
            max-width: 44px;
        }

        .wordle-key.wide {
            min-width: 56px;
            max-width: 66px;
            font-size: 0.75rem;
        }

        .dark .wordle-key {
            background: rgb(var(--gray-700));
            color: white;
        }

        .wordle-key:hover:not(:disabled) {
            background: rgb(var(--gray-300));
        }

        .dark .wordle-key:hover:not(:disabled) {
            background: rgb(var(--gray-600));
        }

        .wordle-key:active:not(:disabled) {
            transform: scale(0.95);
        }

        .wordle-key.correct {
            background: var(--correct);
            color: white;
        }

        .wordle-key.present {
            background: var(--present);
            color: white;
        }

        .wordle-key.absent {
            background: var(--absent);
            color: white;
        }

        .wordle-key:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .laravel-cubes-bg {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .laravel-cube {
            position: absolute;
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #FF2D20 0%, #e6291c 100%);
            border-radius: 4px;
            opacity: 0.08;
            animation: float-cube linear infinite;
        }

        .dark .laravel-cube {
            opacity: 0.12;
        }

        .laravel-cube::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, transparent 50%);
            border-radius: 4px;
        }

        .laravel-cube:nth-child(1) {
            left: 5%;
            width: 40px;
            height: 40px;
            animation-duration: 25s;
            animation-delay: 0s;
        }

        .laravel-cube:nth-child(2) {
            left: 15%;
            width: 20px;
            height: 20px;
            animation-duration: 20s;
            animation-delay: -5s;
        }

        .laravel-cube:nth-child(3) {
            left: 25%;
            width: 35px;
            height: 35px;
            animation-duration: 28s;
            animation-delay: -10s;
        }

        .laravel-cube:nth-child(4) {
            left: 35%;
            width: 25px;
            height: 25px;
            animation-duration: 22s;
            animation-delay: -3s;
        }

        .laravel-cube:nth-child(5) {
            left: 45%;
            width: 45px;
            height: 45px;
            animation-duration: 30s;
            animation-delay: -8s;
        }

        .laravel-cube:nth-child(6) {
            left: 55%;
            width: 30px;
            height: 30px;
            animation-duration: 24s;
            animation-delay: -12s;
        }

        .laravel-cube:nth-child(7) {
            left: 65%;
            width: 22px;
            height: 22px;
            animation-duration: 26s;
            animation-delay: -2s;
        }

        .laravel-cube:nth-child(8) {
            left: 75%;
            width: 38px;
            height: 38px;
            animation-duration: 21s;
            animation-delay: -7s;
        }

        .laravel-cube:nth-child(9) {
            left: 85%;
            width: 28px;
            height: 28px;
            animation-duration: 27s;
            animation-delay: -15s;
        }

        .laravel-cube:nth-child(10) {
            left: 92%;
            width: 32px;
            height: 32px;
            animation-duration: 23s;
            animation-delay: -4s;
        }

        @keyframes float-cube {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.08;
            }
            .dark 10% {
                opacity: 0.12;
            }
            90% {
                opacity: 0.08;
            }
            100% {
                transform: translateY(-100px) rotate(720deg);
                opacity: 0;
            }
        }

        /* Subtle horizontal drift variation */
        .laravel-cube:nth-child(odd) {
            animation-name: float-cube-drift-left;
        }

        .laravel-cube:nth-child(even) {
            animation-name: float-cube-drift-right;
        }

        @keyframes float-cube-drift-left {
            0% {
                transform: translateY(100vh) translateX(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.08;
            }
            50% {
                transform: translateY(50vh) translateX(-30px) rotate(360deg);
            }
            90% {
                opacity: 0.08;
            }
            100% {
                transform: translateY(-100px) translateX(0) rotate(720deg);
                opacity: 0;
            }
        }

        @keyframes float-cube-drift-right {
            0% {
                transform: translateY(100vh) translateX(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.08;
            }
            50% {
                transform: translateY(50vh) translateX(30px) rotate(360deg);
            }
            90% {
                opacity: 0.08;
            }
            100% {
                transform: translateY(-100px) translateX(0) rotate(720deg);
                opacity: 0;
            }
        }
    </style>
</div>
