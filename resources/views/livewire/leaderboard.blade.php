<div>
    <section class="relative z-10 pt-28 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-[#FF2D20] rounded-full text-sm font-semibold mb-4">
                    <span>🏆</span>
                    Top Players
                </div>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-4">Leaderboards</h1>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                    See who's dominating the daily challenge. Can you make it to the top?
                </p>
            </div>

            <!-- Leaderboards Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Streak Leaders -->
                <div class="bg-white rounded-2xl border-2 border-gray-200 overflow-hidden transition-all hover:border-[#FF2D20] hover:shadow-[0_8px_30px_rgba(255,45,32,0.1)]">
                    <div class="flex items-center gap-4 p-4 sm:p-6 bg-gradient-to-r from-red-50 to-white border-b-2 border-gray-100">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-[#FF2D20] to-[#e6291c] rounded-xl flex items-center justify-center text-2xl shrink-0">
                            🔥
                        </div>
                        <div>
                            <h2 class="text-lg sm:text-xl font-bold text-gray-900">Longest Streak</h2>
                            <p class="text-sm text-gray-500">Consecutive days played</p>
                        </div>
                    </div>

                    <div class="p-2">
                        @forelse($streakLeaders as $index => $leader)
                            <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 rounded-xl transition-colors {{ $index < 3 ? 'bg-gradient-to-r from-[#FF2D20]/5 to-transparent hover:from-[#FF2D20]/10' : 'hover:bg-gray-50' }}">
                                <!-- Rank -->
                                <div class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center shrink-0">
                                    @if($index === 0)
                                        <span class="text-2xl sm:text-3xl">🥇</span>
                                    @elseif($index === 1)
                                        <span class="text-2xl sm:text-3xl">🥈</span>
                                    @elseif($index === 2)
                                        <span class="text-2xl sm:text-3xl">🥉</span>
                                    @else
                                        <span class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center bg-gray-100 rounded-lg font-bold text-sm text-gray-500">
                                            {{ $index + 1 }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Avatar -->
                                <div class="shrink-0">
                                    @if($leader['user']->avatar)
                                        <img src="{{ $leader['user']->avatar }}" alt="{{ $leader['user']->name }}" class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl object-cover border-2 border-gray-200">
                                    @else
                                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-br from-[#FF2D20] to-[#e6291c] text-white flex items-center justify-center font-bold text-lg">
                                            {{ strtoupper(substr($leader['user']->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Name -->
                                <div class="flex-1 min-w-0">
                                    <span class="font-semibold text-gray-900 truncate block text-sm sm:text-base">{{ $leader['user']->name }}</span>
                                </div>

                                <!-- Stat -->
                                <div class="flex flex-col items-end shrink-0">
                                    <span class="text-xl sm:text-2xl font-extrabold text-[#FF2D20] leading-none">{{ $leader['streak'] }}</span>
                                    <span class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-wide">{{ Str::plural('day', $leader['streak']) }}</span>
                                </div>
                            </div>
                        @empty
                            @for($i = 0; $i < 5; $i++)
                                <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 rounded-xl opacity-60">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center shrink-0">
                                        <span class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center bg-gray-100 rounded-lg font-bold text-sm text-gray-300">{{ $i + 1 }}</span>
                                    </div>
                                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gray-200 flex items-center justify-center text-gray-400 font-bold shrink-0">?</div>
                                    <div class="flex-1 min-w-0">
                                        <span class="text-gray-300 text-sm sm:text-base">Waiting for players...</span>
                                    </div>
                                    <div class="text-xl sm:text-2xl font-extrabold text-gray-300">-</div>
                                </div>
                            @endfor
                        @endforelse

                        @if($streakLeaders->count() > 0 && $streakLeaders->count() < 5)
                            @for($i = $streakLeaders->count(); $i < 5; $i++)
                                <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 rounded-xl opacity-60">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center shrink-0">
                                        <span class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center bg-gray-100 rounded-lg font-bold text-sm text-gray-300">{{ $i + 1 }}</span>
                                    </div>
                                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gray-200 flex items-center justify-center text-gray-400 font-bold shrink-0">?</div>
                                    <div class="flex-1 min-w-0">
                                        <span class="text-gray-300 text-sm sm:text-base">Be the next!</span>
                                    </div>
                                    <div class="text-xl sm:text-2xl font-extrabold text-gray-300">-</div>
                                </div>
                            @endfor
                        @endif
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 text-center">
                        <p class="text-sm text-gray-500">Play daily to build your streak!</p>
                    </div>
                </div>

                <!-- Efficiency Leaders -->
                <div class="bg-white rounded-2xl border-2 border-gray-200 overflow-hidden transition-all hover:border-[#FF2D20] hover:shadow-[0_8px_30px_rgba(255,45,32,0.1)]">
                    <div class="flex items-center gap-4 p-4 sm:p-6 bg-gradient-to-r from-red-50 to-white border-b-2 border-gray-100">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-[#FF2D20] to-[#e6291c] rounded-xl flex items-center justify-center text-2xl shrink-0">
                            🎯
                        </div>
                        <div>
                            <h2 class="text-lg sm:text-xl font-bold text-gray-900">Best Efficiency</h2>
                            <p class="text-sm text-gray-500">Lowest average guesses (min. 3 wins)</p>
                        </div>
                    </div>

                    <div class="p-2">
                        @forelse($efficiencyLeaders as $index => $leader)
                            <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 rounded-xl transition-colors {{ $index < 3 ? 'bg-gradient-to-r from-[#FF2D20]/5 to-transparent hover:from-[#FF2D20]/10' : 'hover:bg-gray-50' }}">
                                <!-- Rank -->
                                <div class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center shrink-0">
                                    @if($index === 0)
                                        <span class="text-2xl sm:text-3xl">🥇</span>
                                    @elseif($index === 1)
                                        <span class="text-2xl sm:text-3xl">🥈</span>
                                    @elseif($index === 2)
                                        <span class="text-2xl sm:text-3xl">🥉</span>
                                    @else
                                        <span class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center bg-gray-100 rounded-lg font-bold text-sm text-gray-500">
                                            {{ $index + 1 }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Avatar -->
                                <div class="shrink-0">
                                    @if($leader['user']->avatar_url)
                                        <img src="{{ $leader['user']->avatar_url }}" alt="{{ $leader['user']->name }}" class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl object-cover border-2 border-gray-200">
                                    @else
                                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-br from-[#FF2D20] to-[#e6291c] text-white flex items-center justify-center font-bold text-lg">
                                            {{ strtoupper(substr($leader['user']->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Name & Meta -->
                                <div class="flex-1 min-w-0 flex flex-col gap-0.5">
                                    <span class="font-semibold text-gray-900 truncate text-sm sm:text-base">{{ $leader['user']->name }}</span>
                                    <span class="text-xs text-gray-500">{{ $leader['games_won'] }} {{ Str::plural('win', $leader['games_won']) }}</span>
                                </div>

                                <!-- Stat -->
                                <div class="flex flex-col items-end shrink-0">
                                    <span class="text-xl sm:text-2xl font-extrabold text-[#FF2D20] leading-none">{{ $leader['avg_attempts'] }}</span>
                                    <span class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-wide">avg</span>
                                </div>
                            </div>
                        @empty
                            @for($i = 0; $i < 5; $i++)
                                <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 rounded-xl opacity-60">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center shrink-0">
                                        <span class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center bg-gray-100 rounded-lg font-bold text-sm text-gray-300">{{ $i + 1 }}</span>
                                    </div>
                                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gray-200 flex items-center justify-center text-gray-400 font-bold shrink-0">?</div>
                                    <div class="flex-1 min-w-0">
                                        <span class="text-gray-300 text-sm sm:text-base">Waiting for players...</span>
                                    </div>
                                    <div class="text-xl sm:text-2xl font-extrabold text-gray-300">-</div>
                                </div>
                            @endfor
                        @endforelse

                        @if($efficiencyLeaders->count() > 0 && $efficiencyLeaders->count() < 5)
                            @for($i = $efficiencyLeaders->count(); $i < 5; $i++)
                                <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 rounded-xl opacity-60">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center shrink-0">
                                        <span class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center bg-gray-100 rounded-lg font-bold text-sm text-gray-300">{{ $i + 1 }}</span>
                                    </div>
                                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gray-200 flex items-center justify-center text-gray-400 font-bold shrink-0">?</div>
                                    <div class="flex-1 min-w-0">
                                        <span class="text-gray-300 text-sm sm:text-base">Be the next!</span>
                                    </div>
                                    <div class="text-xl sm:text-2xl font-extrabold text-gray-300">-</div>
                                </div>
                            @endfor
                        @endif
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 text-center">
                        <p class="text-sm text-gray-500">Win 3+ games to qualify!</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="mt-16 bg-gradient-to-r from-[#FF2D20] to-[#e6291c] rounded-2xl p-8 text-center text-white">
                <h2 class="text-2xl font-bold mb-2">Ready to compete?</h2>
                <p class="text-white/80 mb-6">Play today's challenge and climb the leaderboards!</p>
                @auth
                    <a href="{{ route('filament.app.auth.login') }}" class="btn btn-secondary">Play Now →</a>
                @else
                    <a href="{{ route('filament.app.auth.register') }}" class="btn btn-secondary">Start Playing Free →</a>
                @endauth
            </div>
        </div>
    </section>
</div>