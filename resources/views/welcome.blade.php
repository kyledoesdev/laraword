<x-layouts.app>

    <!-- Hero Section -->
    <section class="relative z-10 min-h-screen flex items-center justify-center pt-16 pb-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

            <!-- Left Content -->
            <div class="text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-[#FF2D20] rounded-full text-sm font-semibold mb-6">
                    <span>🎮</span>
                    New: Free Play Mode Available!
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                    The Daily Word Game for <span class="text-[#FF2D20]">Laravel</span> Developers
                </h1>

                <p class="text-lg sm:text-xl text-gray-500 mb-8 max-w-xl mx-auto lg:mx-0">
                    Challenge yourself with PHP and Laravel terminology. One word per day. Six guesses.
                </p>

                <div class="flex flex-wrap gap-4 justify-center lg:justify-start mb-10">
                    @auth
                        <a href="{{ url('/game') }}" class="btn btn-primary">
                            Play Today's Word →
                        </a>
                    @else
                        <a href="{{ url('/game/register') }}" class="btn btn-primary">
                            Start Playing Free →
                        </a>
                        <a href="#how-to-play" class="btn btn-ghost">
                            Learn More
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Demo Board -->
            <div class="flex justify-center lg:justify-end">
                <div class="bg-white border-[3px] border-[#FF2D20] rounded-2xl p-3 sm:p-4 shadow-2xl shadow-red-500/20">
                    @php
                        $demoBoard = [
                            [['S', 'absent'], ['C', 'absent'], ['O', 'present'], ['U', 'absent'], ['T', 'absent']],
                            [['F', 'absent'], ['O', 'correct'], ['R', 'absent'], ['G', 'absent'], ['E', 'present']],
                            [['M', 'correct'], ['Y', 'absent'], ['S', 'absent'], ['Q', 'absent'], ['L', 'present']],
                            [['C', 'absent'], ['L', 'present'], ['O', 'present'], ['U', 'absent'], ['D', 'present']],
                            [['M', 'correct'], ['O', 'correct'], ['D', 'correct'], ['E', 'correct'], ['L', 'correct']],
                            [['', ''], ['', ''], ['', ''], ['', ''], ['', '']],
                        ];

                        $statusClasses = [
                            'correct' => 'tile-correct',
                            'present' => 'tile-present',
                            'absent'  => 'tile-absent',
                            ''        => 'tile-empty',
                        ];
                    @endphp

                    @foreach ($demoBoard as $row)
                        <div class="flex gap-1.5 sm:gap-2 mb-2 last:mb-0">
                            @foreach ($row as [$letter, $status])
                                <div class="tile-base w-12 h-12 sm:w-14 sm:h-14 text-xl sm:text-2xl rounded-lg {{ $statusClasses[$status] }}">
                                    {{ $letter }}
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    <!-- Features Section -->
    <section class="relative z-10 py-10 px-4 sm:px-6 lg:px-8 bg-white" id="features">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">
                    Why Play Laraword?
                </h2>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                    More than just a game — it's a fun way to interact with the greater Laravel community.
                </p>
            </div>

            @php
                $features = [
                    ['icon' => '🎯', 'title' => 'Daily Challenge', 'desc' => 'A new Laravel-themed word every day.'],
                    ['icon' => '♾️', 'title' => 'Free Play Mode', 'desc' => 'Unlimited practice with random words.'],
                    ['icon' => '🏆', 'title' => 'Leaderboards', 'desc' => 'Compete with developers worldwide.'],
                    ['icon' => '📚', 'title' => 'Word Bank', 'desc' => 'Explore all Laravel terms.'],
                    ['icon' => '📊', 'title' => 'Track Progress', 'desc' => 'Your progress saves automatically.'],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 place-items-center">
                @foreach ($features as $feature)
                    <div class="w-full max-w-sm bg-gray-50 rounded-2xl p-6 text-center
                                hover:-translate-y-1 hover:shadow-xl transition-all border-2 border-transparent hover:border-[#FF2D20]/20">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#FF2D20] to-[#e6291c] rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                            {{ $feature['icon'] }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-gray-500">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- How to Play Section -->
    <section class="relative z-10 py-20 px-4 sm:px-6 lg:px-8 bg-gray-50" id="how-to-play">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-4">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">
                    How to Play
                </h2>
                <p class="text-lg text-gray-500">
                    Simple rules, endless fun.
                </p>
            </div>

            @php
                $rules = [
                    ['title' => 'Guess the Word', 'desc' => 'You have 6 attempts to guess the 5-letter Laravel term.'],
                    ['title' => 'Check the Colors', 'desc' => 'Tiles change color to show how close you are.'],
                    ['title' => 'Use the Clues', 'desc' => 'Narrow down the word using previous guesses.'],
                    ['title' => 'Choose Your Mode', 'desc' => 'Daily challenge or free play mode.'],
                ];
            @endphp

            <div class="space-y-4">
                @foreach ($rules as $index => $rule)
                    <div class="flex flex-col sm:flex-row gap-4 items-start bg-white rounded-2xl p-6 border border-gray-100">
                        <div class="w-12 h-12 rounded-xl bg-[#FF2D20] text-white flex items-center justify-center font-bold text-xl shrink-0">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $rule['title'] }}</h3>
                            <p class="text-gray-500">{{ $rule['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Tile Examples -->
            <div class="flex flex-col sm:flex-row justify-center gap-6 mt-12">
                <div class="flex items-center gap-3">
                    <div class="tile-base tile-correct w-12 h-12 rounded-lg">A</div>
                    <span class="text-gray-600 font-medium">Correct position</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="tile-base tile-present w-12 h-12 rounded-lg">B</div>
                    <span class="text-gray-600 font-medium">Wrong position</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="tile-base tile-absent w-12 h-12 rounded-lg">C</div>
                    <span class="text-gray-600 font-medium">Not in word</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Explore Section -->
    <section class="relative z-10 py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-3xl mx-auto text-center mb-10">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">
                Explore More
            </h2>
            <p class="text-lg text-gray-500">
                Check out the leaderboards and word bank.
            </p>
        </div>

        <div class="max-w-3xl mx-auto grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ url('/leaderboards') }}" class="group flex items-center gap-4 bg-gray-50 border-2 border-gray-200 rounded-2xl p-5 hover:border-[#FF2D20] hover:shadow-xl transition-all">
                <div class="w-14 h-14 bg-gradient-to-br from-[#FF2D20] to-[#e6291c] rounded-xl flex items-center justify-center text-2xl">
                    🏆
                </div>
                <div class="flex-1 text-left">
                    <h3 class="font-bold text-gray-900">Leaderboards</h3>
                    <p class="text-sm text-gray-500">See top players</p>
                </div>
            </a>

            <a href="{{ url('/word-bank') }}" class="group flex items-center gap-4 bg-gray-50 border-2 border-gray-200 rounded-2xl p-5 hover:border-[#FF2D20] hover:shadow-xl transition-all">
                <div class="w-14 h-14 bg-gradient-to-br from-[#FF2D20] to-[#e6291c] rounded-xl flex items-center justify-center text-2xl">
                    📚
                </div>
                <div class="flex-1 text-left">
                    <h3 class="font-bold text-gray-900">Word Bank</h3>
                    <p class="text-sm text-gray-500">Browse all terms</p>
                </div>
            </a>
        </div>
    </section>

    <!-- CTA -->
    <section class="relative z-10 py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-[#FF2D20] to-[#e6291c]">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">
                Ready to Test Your Skills?
            </h2>
            <p class="text-xl text-white/80 mb-8">
                Join developers who play Laraword daily.
            </p>

            @auth
                <a href="{{ url('/game') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-[#FF2D20] font-bold rounded-xl hover:bg-gray-100 transition-all">
                    Play Today's Word →
                </a>
            @else
                <a href="{{ url('/game/register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-[#FF2D20] font-bold rounded-xl hover:bg-gray-100 transition-all">
                    Get Started Free →
                </a>
            @endauth
        </div>
    </section>

</x-layouts.app>
