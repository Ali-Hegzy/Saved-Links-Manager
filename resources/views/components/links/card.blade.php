@props([
    'title',
    'description',
    'site',
    'status',
    'url',
])
<div class="card bg-bg-card py-2 px-3 rounded-2xl text-text-main border-primary-dimmed border-2">
    <h2 class="text-2xl">{{ $title }}</h2>
    <p class="line-clamp-1">{{ $description }}</p>
    <p>Site : {{ $site }}</p>
    <div class="flex justify-between">
        <p>Watched : {{ $status ? 'Yes' : 'No' }}</p>
        <a href="{{ $url }}" target="_blank" class="underline text-red-500">Watch</a>
    </div>
</div>
