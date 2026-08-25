@props([
    'link'
])
<x-ui.card>
    <h2 class="text-2xl">{{ $link->title }}</h2>
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

