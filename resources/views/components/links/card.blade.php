@props([
    'title',
    'description',
    'site',
    'status',
    'url',
])

<x-ui.card>
    <h2 class="text-2xl">{{ $title }}</h2>
    <p class="line-clamp-1">{{ $description }}</p>
    <p>Site : {{ $site }}</p>
    <div class="flex justify-between">
        <p>Watched : {{ $status ? 'Yes' : 'No' }}</p>
        <div class="links">
            <a href="link/{{ $id }}" class="underline text-amber-500">View Link</a>
            <a href="{{ $url }}" target="_blank" class="underline text-red-500">Watch</a>
        </div>
    </div>
</x-ui.card>

