<div x-data="{ open: false }" class="relative flex">
    <button @click="open = ! open" class="cursor-pointer">
        {{-- This SVG is AI Generated --}}
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
            <!-- Top Dot -->
            <circle cx="12" cy="5" r="2" />
            <!-- Center Dot -->
            <circle cx="12" cy="12" r="2" />
            <!-- Bottom Dot -->
            <circle cx="12" cy="19" r="2" />
        </svg>
    </button>

    <div x-cloak x-show="open" @click.outside="open = false">
        <x-ui.card class="absolute right-0 top-8 bg-bg-main">
            {{ $slot }}
        </x-ui.card>
    </div>
</div>
