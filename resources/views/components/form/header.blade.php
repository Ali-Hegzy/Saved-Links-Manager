@props([
    'title','description'
])

<header class="flex flex-col items-center mb-2 gap-2">
    <h1 class="text-5xl">{{ $title }}</h1>
    <p class="text-muted">{{ $description }}</p>
</header>
