<a href="{{ auth()->check() ? route('filament.app.pages.dashboard') : route('welcome') }}" style="
    display: flex;
    align-items: center;
    gap: 0.5rem; /* gap-2 */
    font-weight: 800; /* font-extrabold */
    font-size: 1.25rem; /* text-xl */
    color: #dc2626; /* text-red-600 */
">
    <div style="
        display: flex;
        height: 2.25rem; /* h-9 */
        width: 2.25rem; /* w-9 */
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem; /* rounded-lg */
        background-color: #dc2626; /* bg-red-600 */
        color: white; /* text-white */
        font-size: 1.25rem; /* text-xl */
        font-weight: 700; /* font-bold */
    ">
        L
    </div>
    {{ config('app.name') }}
</a>
