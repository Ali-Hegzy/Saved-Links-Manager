@props([
    'link'
])
<x-ui.card>
    <div class="upper flex flex-row justify-between">
        <h2 class="text-2xl line-clamp-1">{{ $link->title }}</h2>
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
                    <ul class="flex flex-col gap-2">
                        <li>
                            <form action="/link/{{ $link->id }}/delete" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="cursor-pointer">DELETE</button>
                            </form>
                        </li>
                    </ul>
                </x-ui.card>
            </div>

        </div>
    </div>
    <p class="line-clamp-1">{{ $link->description }}</p>
    <p>Site : {{ $link->site }}</p>
    <div class="flex justify-between">
        <p>Watched : {{ $link->status ? 'Yes' : 'No' }}</p>
        <div class="links">
            <a href="/link/{{ $link->id }}" class="underline text-amber-500">View Link</a>
            <a href="{{ $link->url }}" target="_blank" class="underline text-red-500">Watch</a>
        </div>
    </div>
</x-ui.card>

