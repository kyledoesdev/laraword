<x-layouts.guest>
    <section class="relative z-10 pt-28 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-[#FF2D20] rounded-full text-sm font-semibold mb-4">
                    <span>📚</span>
                    {{ $words->total() }} Words
                </div>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-4">Word Bank</h1>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                    Explore all of the PHP and Laravel terms in the game.
                </p>
            </div>

            <!-- Search & Filter Bar -->
            <div class="mb-8">
                <form action="{{ url('/word-bank') }}" method="GET" class="flex flex-col sm:flex-row gap-4 justify-center">
                    <div class="relative flex-1 max-w-md">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Search words..." 
                            class="w-full px-5 py-3 pl-12 rounded-xl border-2 border-gray-200 focus:border-[#FF2D20] focus:ring-0 focus:outline-none transition-colors"
                        >
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                </form>
            </div>

            <!-- Alphabet Quick Jump -->
            <div class="flex flex-wrap justify-center gap-2 mb-8">
                @foreach(range('A', 'Z') as $letter)
                    <a 
                        href="{{ url('/word-bank?letter=' . $letter) }}" 
                        class="w-9 h-9 flex items-center justify-center rounded-lg font-semibold text-sm transition-all
                            {{ request('letter') === $letter 
                                ? 'bg-[#FF2D20] text-white' 
                                : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}"
                    >
                        {{ $letter }}
                    </a>
                @endforeach
                <a 
                    href="{{ url('/word-bank') }}" 
                    class="px-4 h-9 flex items-center justify-center rounded-lg font-semibold text-sm transition-all
                        {{ !request('letter') && !request('search')
                            ? 'bg-[#FF2D20] text-white' 
                            : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}"
                >
                    All
                </a>
            </div>

            <!-- Words Grid -->
            @if($words->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                    @foreach($words as $word)
                        <div class="word-card group">
                            <div class="word-tiles">
                                @foreach(str_split($word->word) as $index => $letter)
                                    <span class="word-tile" style="animation-delay: {{ $index * 0.05 }}s">
                                        {{ $letter }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $words->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No words found</h3>
                    <p class="text-gray-500 mb-4">Try a different search term or browse all words.</p>
                    <a href="{{ url('/word-bank') }}" class="btn btn-secondary">View All Words</a>
                </div>
            @endif

            <!-- Suggest Word CTA -->
            <div class="mt-16 bg-gradient-to-r from-[#FF2D20] to-[#e6291c] rounded-2xl p-8 text-center text-white">
                <h2 class="text-2xl font-bold mb-2">Know a word we're missing?</h2>
                <p class="text-white/80 mb-4">Click the bubble in the corner to suggest a new Laravel term!</p>
                <div class="inline-flex items-center gap-2 text-sm bg-white/20 rounded-full px-4 py-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                    </svg>
                    Look for the chat bubble →
                </div>
            </div>
        </div>
    </section>

    <x-support-bubble />
</x-layouts.guest>